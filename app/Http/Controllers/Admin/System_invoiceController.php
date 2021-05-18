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
                $save->collection_point_id = $cp_id;
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

    public function get_datatable(Request $request)
    {
        $like = array();
        $result_array = [];
        $post = $request->all();

        $orderByColumnIndex = $post['order'][0]['column'];
        $orderByColumn = $post['columns'][$orderByColumnIndex]['data'];
        $orderType = $post['order'][0]['dir'];
        $offset = $post['start'];
        $limit = $post['length'];
        $draw = $post['draw'];
        $search = $post['search']['value'];

        $collection_point_id = $post['collection_point_id'];

        $auth = Auth::user();

        $result_count = System_invoice::where('collection_point_id',$collection_point_id)->count();

        $result = new System_invoice;
        $result = $result->where('collection_point_id' , $collection_point_id);

        if(!empty($search)){
            $result = $result->where('unique_id', 'like', '%' .$search. '%');
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'ASC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
        	$total_balance = 0;
            foreach($result_data as $item){
            	$single_field['date'] = $item->date;
                $single_field['unique_id'] = '#'.$item->unique_id;
                $single_field['amount'] = 'Rs: '.$item->amount;
                $single_field['description'] = (!empty($item->description))?$item->description:'---';
                $single_field['payment_method'] = $item->payment_method;
                $single_field['action'] = '
                   <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                          <a href="javascript::" class="system_invoice_update_id" rel="'.$item->id.'">
                            <button class="dropdown-item" type="button">Edit</button>
                          </a>
                          <a href="'.url('admin/delete-system-invoice/'.$item->id.'/'.$item->collection_point_id).'" class="delete_system_invoice">
                            <button class="dropdown-item" type="button">Delete</button>
                          </a>
                        </div>
                    </div>
                ';
                $result_array[] = $single_field;
            }
            $data['draw'] = $draw;
            $data['recordsTotal'] = $result_count;
            $data['recordsFiltered'] = $result_count_rows;
            $data['data'] = $result_array;
        } else {
            $data['draw'] = $draw;
            $data['recordsTotal'] = 0;
            $data['recordsFiltered'] = 0;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    public function delete($id = 0,$cp_id = 0)
    {
        $data  = [];
        $class = new System_invoice;
        $result = $class->find($id);
        if(empty($result)){
            return redirect('admin/cp-view-profile/'.$cp_id)->with('error_message' , 'This record does not exist.');
        }
        $result->delete();
        Ledger::where('system_invoice_id',$id)->delete();
        return redirect('admin/cp-view-profile/'.$cp_id)->with('success_message' , 'Record has been deleted successfully.');
    }


}
