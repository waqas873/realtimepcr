<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\User;
use App\Ledger;
use App\System_invoice;

class System_invoiceController extends Controller
{
    public $date_time;

    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Karachi");
        $this->date_time = date('Y:m:d H:i:s');
    }

    public function index()
    {
        $data = [];
        //return view('admin.collection_points.index',$data);
    }

    public function update($id='0')
    {
        $data = [];
        $data['response'] = false;
        $result = System_invoice::where('id',$id)->first();
        if(!empty($result)){
            $data['result'] = $result;
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function process_add(Request $request)
    {
        $data = [];
        $data['response'] = false;

    	$formData = $request->all();
    	$rules = [
            'date'=>'required',
	        'amount' => 'required|min:1',
	        'payment_method' => 'required|min:1'
	    ];
	    $messages = [];
	    $attributes = [];
        $attributes['payment_method'] = 'payment method';

    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	//$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            $id = $formData['id'];
            unset($formData['_token'],$formData['id']);
            $cp_id = null;
            if(!empty($formData['collection_point_id'])){
            	$cp_id = $formData['collection_point_id'];
            	unset($formData['collection_point_id']);
            }
            $user = Auth::user();
            if(!empty($id)){
                $result = System_invoice::where('id',$id)->update($formData);
                $update = [];
                $update['amount'] = $formData['amount']; 
                Ledger::where('system_invoice_id',$id)->update($update);
            }
            else{
                $save = new System_invoice;
                $save->user_id = $user->id;
                $save->date = $formData['date'];
                $save->amount = $formData['amount'];
                $save->payment_method = $formData['payment_method'];
                if(!empty($formData['description'])){
                	$save->description = $formData['description'];
                }
                $inv_uniq_id = '000000';
                $uniqueness = false;
                while($uniqueness == false){
                    $inv_uniq_id = rand(1,1000000);
                    $invRes = System_invoice::where('unique_id',$inv_uniq_id)->first();
                    if(empty($invRes)){
                        $uniqueness = true;
                    }
                }
                $save->unique_id = $inv_uniq_id;
                $save->created_at = $this->date_time;
                $save->updated_at = $this->date_time;
                $save->save();

                $system_invoice_id = $save->id;
                $this->addLedger($formData['amount'],$system_invoice_id,$cp_id,'Amount recieved from collection point.');
            }
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function addLedger($amount = 0,$si_id = null,$cp_id = null,$description = null)
    {
        $user = Auth::user();
        $ledger = new Ledger;
        $ledger->user_id = $user->id;
        $ledger->system_invoice_id = $si_id;
        if(empty($amount)){
            return false;
        }
        $ledger->amount = $amount;
        $ledger->collection_point_id = $cp_id;
        $uniq_id = '000000';
        $uniqueness = false;
        while($uniqueness == false){
            $uniq_id = rand(1,1000000);
            $invRes = Ledger::where('unique_id',$uniq_id)->first();
            if(empty($invRes)){
                $uniqueness = true;
            }
        }
        $ledger->unique_id = $uniq_id;
        $ledger->description = $description;
        $ledger->is_credit = 1;
        //$result = Ledger::where('collection_point_id',$cp_id)->latest()->first();
        $ledger->save();
        return true;
    }




}
