<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\User;
use App\Collection_point;
use App\Category;
use App\Ledger;
use App\Collection_point_category;
use App\Collection_point_test;
use App\Test;
use App\Airline;
use App\Patient;

class Collection_pointController extends Controller
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
        $data['collection_points'] = Collection_point::where('status' , 1)->orderBy('id' , 'DESC')->get();
        return view('admin.collection_points.index',$data);
    }

    public function entriesReports($id = 0)
    {
        $data = [];
        return view('admin.collection_points.entries_reports',$data);
    }

    public function viewProfile($id = 0)
    {
        $data = [];
        $cp = new Collection_point;
        $result = $cp->find($id);
        if(!empty($result)){
            $data['result'] = $result;
            $data['tests'] = Test::all();
            $data['cp_tests'] = Collection_point_test::all();
            if(empty($result->cp_categories[0])){
                $categories = Category::all();
                if(!empty($categories)){
                    foreach($categories as $key => $value){
                        $save = new Collection_point_category;
                        $save->user_id = Auth::user()->id;
                        $save->collection_point_id = $id;
                        $save->category_id = $value->id;
                        $save->discount_percentage = 0;
                        $save->save();
                    }
                }
            }
            // $total_amount = Ledger::where('collection_point_id',$id)->where(function($query){
            //         $query->where('is_debit',1)->orWhere('is_credit',1);
            // })->sum('amount');
            $amount_paid = Ledger::where('collection_point_id',$id)->where('is_credit',1)->sum('amount');
            $amount_payable = Ledger::where('collection_point_id',$id)->where('is_debit',1)->sum('amount');
            $data['amount_paid'] = $amount_paid;
            $data['amount_payable'] = $amount_payable-$amount_paid;
            return view('admin.collection_points.view_profile',$data);
        }
    }

    public function cpLedgers($id = 0)
    {
        $data = [];
        return view('admin.collection_points.cp_ledgers',$data);
    }

    public function update($id='0')
    {
        $data = [];
        $data['response'] = false;
        $result = Collection_point::where('id',$id)->first();
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
        //dd($formData,true);
    	$rules = [
	        //'name'=>'required|unique:collection_points|min:2',
            'name'=>'required|min:2',
	        'domain' => 'required|min:1',
	        'focal_person' => 'required|min:1',
	        'contact_no'=>'required|min:10|max:17',
	        'city' => 'required',
	        'address' => 'required|min:3'
	    ];
	    $messages = [];
	    $attributes = [];
        $attributes['focal_person'] = 'focal person';
        $attributes['contact_no'] = 'contact no';

    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	//$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $errors = $validator->errors();
            $data['name'] = $errors->first('name');
            $data['contact_no'] = $errors->first('contact_no');
            $data['city'] = $errors->first('city');
            $data['domain'] = $errors->first('domain');
            $data['focal_person'] = $errors->first('focal_person');
            $data['address'] = $errors->first('address');
        }
        else{
            $id = $formData['id'];
            unset($formData['_token'],$formData['id']);
            //dd($formData);
            $user = Auth::user();
            if(!empty($id)){
                $result = Collection_point::where('id',$id)->update($formData);
            }
            else{
                $save = new Collection_point;
                $save->user_id = $user->id;
                $save->name = $formData['name'];
                $save->city = $formData['city'];
                $save->domain = $formData['domain'];
                $save->focal_person = $formData['focal_person'];
                $save->contact_no = $formData['contact_no'];
                $save->address = $formData['address'];
                $save->created_at = $this->date_time;
                $save->updated_at = $this->date_time;
                $save->save();
            }
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function updateCpCategory($id='0')
    {
        $data = [];
        $data['response'] = false;
        $result = Collection_point_category::find($id);
        if(!empty($result)){
            $data['result'] = $result;
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function processUpdateCpCategory(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [
            'id'=>'required',
            'discount_percentage' => 'required|min:1|max:3',
            'custom_prizes' => 'required'
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
                $result = Collection_point_category::where('id',$id)->update($formData);
                $data['response'] = true;
            }
        }
        echo json_encode($data);
    }

    public function updateCpTest($id='0')
    {
        $data = [];
        $data['response'] = false;
        $result = Collection_point_test::find($id);
        if(!empty($result)){
            $data['result'] = $result;
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function processCpTest(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [
            'collection_point_id'=>'required',
            'test_id' => 'required',
            'discounted_price' => 'required'
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
                $result = Collection_point_test::where('id',$id)->update($formData);
            }
            else{
                $formData['user_id'] = Auth::user()->id;
                Collection_point_test::insert($formData);
            }
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function delete($cp_id = '0')
    {
        $data  = [];
        $result = Collection_point::find($cp_id);
        if(empty($result)){
            return redirect('admin/collection-points')->with('error_message' , 'This collection point does not exist.');
        }
        $users = $result->users;
        foreach($users as $key => $value){
            $patients = Patient::where('user_id' , $value->id)->first();
            if(!empty($patients)){
                $update = ['status'=>'0'];
                User::where('id',$value->id)->update($update);
            }
            else{
                User::where('id',$value->id)->delete();
            }
        }
        $update = ['status'=>'0'];
        Collection_point::where('id',$cp_id)->update($update);
        return redirect('admin/collection-points')->with('success_message' , 'Collection point and its related inactive users have been deleted successfully.');
    }

    public function delete_cp_test($id = 0 , $cp_id = 0)
    {
        $data  = [];
        $result = Collection_point_test::find($id);
        if(empty($result)){
            return redirect('admin/cp-view-profile/'.$cp_id)->with('error_message' , 'This record does not exist.');
        }
        Collection_point_test::where('id',$id)->delete();
        return redirect('admin/cp-view-profile/'.$cp_id)->with('success_message' , 'Record has been deleted successfully.');
    }

}
