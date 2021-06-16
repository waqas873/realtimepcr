<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Supplier;
use App\Ledger;
use App\User;

class SupplierController extends Controller
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
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['suppliers_read']))){
            return redirect('admin/home');
        }
        $data = [];
        $data['list'] = Supplier::all();
        return view('admin.suppliers.index',$data);
    }

    public function viewProfile($id = 0)
    {
        $data = [];
        $cp = new Supplier;
        $result = $cp->find($id);
        if(!empty($result)){
            $data['result'] = $result;
            $amount_paid = Ledger::where('supplier_id',$id)->where('is_credit',1)->sum('amount');
            $amount_payable = Ledger::where('supplier_id',$id)->where('is_debit',1)->sum('amount');
            $data['amount_paid'] = $amount_paid;
            $data['amount_payable'] = $amount_payable-$amount_paid;
            return view('admin.suppliers.view_profile',$data);
        }
    }

    public function process_add(Request $request)
    {
    	$data = [];
    	$data['response'] = false;

    	$formData = $request->all();
    	$rules = [
	        'name'=>'required|min:1',
	        'email'=>'required',
	        'contact'=>'required|min:1'
	    ];
	    $messages = [];
	    $attributes = [];
    	$validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
        	$id = $formData['id'];
        	unset($formData['_token'],$formData['id']);
        	if(!empty($id)){
                $result = Supplier::where('id',$id)->update($formData);
        	}
        	else{
        		$formData['user_id'] = Auth::user()->id;
        		$result = Supplier::insert($formData);
        	}
	        $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function update($id='0')
    {
    	$data = [];
    	$data['response'] = false;
    	$result = Supplier::where('id',$id)->get();
    	if(!empty($result)){
    		$data['result'] = $result[0];
    		$data['response'] = true;
    	}
    	echo json_encode($data);
    }

}
