<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Product;
use App\Product_history;
use App\Test;
use App\Supplier;
use App\User;
use App\Lab;

class ProductController extends Controller
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
        if($permissions['role']==7 && (empty($permissions['products_read']))){
            return redirect('admin/home');
        }
        $data = [];
        $data['suppliers'] = Supplier::all();
        $data['tests'] = Test::all();
        $data['labs'] = Lab::all();
        return view('admin.products.index',$data);
    }

    public function process_add(Request $request)
    {
    	$data = [];
    	$data['response'] = false;

    	$formData = $request->all();
    	$rules = [
    		'product_category_id'=>'required',
	        'name'=>'required|min:1',
	        'price'=>'required|min:1',
	        'lot_number'=>'required',
	        'expiry_date'=>'required',
            'lab_id'=>'required',
            'test_id'=>'required',
            'supplier_id'=>'required',
	        'quantity'=>'required|min:1'
	    ];
	    $messages = [];
	    $attributes = [
	    	'quantity' => 'pack size',
	    	'lot_number' => 'lot number',
            'lab_id' => 'lab',
            'supplier_id' => 'supplier',
	    	'product_category_id' => 'product category',
	    	'expiry_date' => 'expiry date'
	    ];
    	$validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
        	unset($formData['_token']);
        	$user = Auth::user();

    		// $result = Product::where('name' , $formData['name'])->first();
    		// if(!empty($result)){
    		// 	$total_quantity = $result->available_quantity+$formData['quantity'];
    		// 	$update = ['available_quantity'=>$total_quantity,'test_id'=>$formData['test_id'],'product_category_id'=>$formData['product_category_id']];
      //           Product::where('id',$result->id)->update($update);
      //           $product_id = $result->id;
    		// }
    		// else{
    		// 	$product = new Product;
    		// 	$product->name = $formData['name'];
    		// 	$product->test_id = $formData['test_id'];
    		// 	$product->available_quantity = $formData['quantity'];
    		// 	$product->product_category_id = $formData['product_category_id'];
    		// 	$product->save();
    		// 	$product_id = $product->id;
    		// }

    		$history = new Product_history;
    		$history->user_id = $user->id;
            $history->name = $formData['name'];
    		//$history->product_id = $product_id;
            $history->lab_id = $formData['lab_id'];
            $history->test_id = $formData['test_id'];
            $history->product_category_id = $formData['product_category_id'];
    		$history->supplier_id = $formData['supplier_id'];
    		$history->lot_number = $formData['lot_number'];
    		$history->expiry_date = $formData['expiry_date'];
    		$history->quantity = $formData['quantity'];
    		$history->remaining_quantity = $formData['quantity'];
            $single_price = $formData['price']/$formData['quantity'];
    		$history->single_price = $single_price;
    		$history->total_price = $formData['price'];
    		$history->save();

	        $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function update($id='0')
    {
    	$data = [];
    	$data['response'] = false;
    	$result = Product_history::where('id',$id)->get();
    	if(!empty($result)){
    		$data['result'] = $result[0];
    		$data['response'] = true;
    	}
    	echo json_encode($data);
    }

    public function get_products(Request $request)
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

        //$from_date = $post['from_date'];

        $auth = Auth::user();
        $result_count = Product_history::where('id' ,'>' , 0)->count();

        $result = new Product_history;  

        if(!empty($search)){
            if(ctype_digit($search)){
                $result = $result->whereHas('invoice', function($q) use($search){
                        $q->where('unique_id', 'like', '%' .$search. '%');
                    }
                );
            }
            else{
                $result = $result->where('name', 'like', '%' .$search. '%');
            }
        }
        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
            $permissions = permissions();
            foreach($result_data as $item){
                $single_field['name'] = (!empty($item->product->name))?$item->product->name:'unavailable';
                $single_field['assigned_test'] = (!empty($item->product->test->name))?$item->product->test->name:'---';
                $single_field['quantity'] = (!empty($item->quantity))?$item->quantity:0;
                $single_field['remaining_quantity'] = (!empty($item->remaining_quantity))?$item->remaining_quantity:0;
                $single_field['expiry_date'] = (!empty($item->expiry_date))?$item->expiry_date:0;
                
                if($permissions['role']==7 && (empty($permissions['products_delete']))){
                    $single_field['action'] = '-- --';
                }
                else{
                    $single_field['action'] = '
                    <a href="'.url('admin/product-delete/'.$item->id).'" class="delete_id"><i class="fa fa-trash"></i></a>';
                }

                // $single_field['action'] = '<a rel="'.$item->id.'" href="javascript::" class="update_id">Edit</a> | 
                //     <a href="'.url('admin/-delete/'.$item->id).'" class="delete_patient"><i class="fa fa-trash"></i></a>';
                
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

    public function delete($id = 0)
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['products_delete']))){
            return redirect('admin/home');
        }
        $data  = [];
        $result = Product_history::where('id',$id)->first();
        if(empty($result)){
            return redirect('admin/products')->with('error_message' , 'This record does not exist.');
        }
        if($result->quantity != $result->remaining_quantity){
        	return redirect('admin/products')->with('error_message' , 'The available kits are less then total kits.');
        }
        else{
        	Product_history::where('id',$id)->delete();
            return redirect('admin/products')->with('success_message' , 'Record has been deleted successfully.');
        }
    }

}
