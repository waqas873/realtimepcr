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
use App\Purchase;

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
            // $amount_paid = Ledger::where('supplier_id',$id)->where('is_credit',1)->sum('amount');
            // $amount_payable = Ledger::where('supplier_id',$id)->where('is_debit',1)->sum('amount');
            // $data['amount_paid'] = $amount_paid;
            // $data['amount_payable'] = $amount_payable-$amount_paid;
            $data['amount_paid'] = 0;
            $data['amount_payable'] = 0;
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

    public function processPurchase(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [
            'supplier_id'=>'required',
            'date'=>'required',
            'purchase_type' => 'required|min:1',
            'price' => 'required|min:1'
        ];
        $messages = [];
        $attributes = [];
        $attributes['purchase_type'] = 'purchase type';

        $validator = Validator::make($formData,$rules,$messages,$attributes);
        //$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            unset($formData['_token']);
            $user = Auth::user();
            $save = new Purchase;
            $save->user_id = $user->id;
            $save->supplier_id = $formData['supplier_id'];
            $save->purchase_type = $formData['purchase_type'];
            $save->price = $formData['price'];
            $save->date = $formData['date'];
            $save->description = $formData['description'];
            $save->remaining_balance = $formData['price'];
            if(!empty($formData['advance_payment'])){
                $save->advance_payment = $formData['advance_payment'];
                if($formData['advance_payment'] > 0 && $formData['price'] > $formData['advance_payment']){
                    $save->remaining_balance = $formData['price']-$formData['advance_payment'];
                }
            }
            $inv_uniq_id = '000000';
            $uniqueness = false;
            while($uniqueness == false){
                $inv_uniq_id = rand(1,1000000);
                $invRes = Purchase::where('unique_id',$inv_uniq_id)->first();
                if(empty($invRes)){
                    $uniqueness = true;
                }
            }
            $save->unique_id = $inv_uniq_id;
            $save->created_at = $this->date_time;
            $save->updated_at = $this->date_time;
            $save->save();

            $purchase_id = $save->id;
            $this->addLedger($formData['price'],$formData['advance_payment'],$purchase_id);
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function addLedger($amount = 0,$advance = 0,$purchase_id = null)
    {
        $user = Auth::user();
        $ledger = new Ledger;
        $ledger->user_id = $user->id;
        $ledger->purchase_id = $purchase_id;
        if(empty($amount)){
            return false;
        }
        $ledger->amount = $amount;
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
        $ledger->description = "Amount payable to vendor";
        $ledger->is_debit = 1;
        $ledger->save();
        if($advance > 0){
            $ledger = new Ledger;
            $ledger->user_id = $user->id;
            $ledger->purchase_id = $purchase_id;
            $ledger->amount = $advance;
            $ledger->unique_id = $uniq_id;
            $ledger->description = "Amount paid to vendor";
            $ledger->is_credit = 1;
            $ledger->save();
        }
        return true;
    }

    public function purchases_datatable(Request $request)
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

        $auth = Auth::user();
        
        $result = new Purchase;
            
        $supplier_id = $post['supplier_id'];
        $result_count = Purchase::where('supplier_id',$supplier_id)->count();
        $result = $result->where('supplier_id' , $supplier_id);

        if(!empty($search)){
            $result = $result->where('unique_id', 'like', '%' .$search. '%');
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'ASC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
            foreach($result_data as $item){
                $single_field['unique_id'] = '#'.$item->unique_id;
                $single_field['purchase_type'] = '';
                $purchase_types = [['id'=>1,'name'=>'Kits'],['id'=>2,'name'=>'Boxes']];
                foreach ($purchase_types as $key => $value) {
                    if($value['id']==$item->purchase_type){
                        $single_field['purchase_type'] = $value['name'];
                    }
                }
                $single_field['description'] = (!empty($item->description))?$item->description:'---';
                $single_field['price'] = 'Rs: '.$item->price;
                $single_field['advance_payment'] = 'Rs: '.$item->advance_payment;
                $single_field['remaining_balance'] = 'Rs: '.$item->remaining_balance;
                $single_field['action'] = '
                   <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                          <a href="'.url('admin/delete-purchase/'.$item->id).'" class="delete_purchase">
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

}
