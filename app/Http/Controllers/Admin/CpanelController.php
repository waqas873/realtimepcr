<?php

//namespace App\Http\Middleware;
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Category;
use App\Account_category;
use App\Test;
use App\Test_category;
use App\Test_profile;
use App\Profile_test;
use App\Sample;
use App\Reporting_unit;
use App\Product;
use App\Permission;
use DB;

class CpanelController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($profile_id='0')
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['app_cpanel_read']))){
            return redirect('admin/home');
        }
    	$data  = [];
        $data['categories'] = Category::all();
        $data['admin_permissions'] = Permission::all();
        $data['samples'] = Sample::all();
        $data['reporting_units'] = Reporting_unit::all();
        $data['draft_tests'] = Test::where('product_id' , null)->orderBy('id','DESC')->get();
        $data['local_tests'] = Test::where('registration_type' , 1)->orderBy('id','DESC')->get();
        $data['overseas_tests'] = Test::where('registration_type' , 2)->orderBy('id','DESC')->get();
        $data['products'] = Product::where('product_category_id' , 1)->orderBy('id','DESC')->get();
        $data['test_profiles'] = Test_profile::orderBy('id','DESC')->get();
        
        if($profile_id > 0){
            $test_profile = Test_profile::where('id',$profile_id)->get();
            if(!empty($test_profile)){
                $data['tp'] = $test_profile[0];
                $data['profile_tests'] = Profile_test::where('test_profile_id',$profile_id)->get();
            }
        }

        $data['account_categories'] = Account_category::all();
        $data['test_categories'] = Test_category::all();
        
        //dd($data['categories']);
        return view('admin.cpanel.index',$data);
    }

    public function changePermission(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [
            'id'=>'required',
            'status'=>'required'
        ];
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        //$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            $id = $formData['id'];
            $status = ($formData['status']==1)?0:1;
            $update = ['status'=>$status];
            $result = Permission::where('id',$id)->update($update);
            $data['status'] = $status;
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function processAccountCategory(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [
            'name'=>'required|min:1',
            'type'=>'required'
        ];
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);

        $validator->after(function ($validator) use($formData){
            $type = $formData['type'];
            $name = $formData['name'];
            $result = Account_category::where('name' , $name)->where('type',$type)->first();
            if(!empty($result)){
                $validator->errors()->add(
                    'name', 'This category is already taken.');
            }
        });

        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            unset($formData['_token']);
            $user = Auth::user();
            $formData['user_id'] = $user->id;
            $result = Account_category::insert($formData);
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function processTestCategory(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [
            'name'=>'required|min:1',
            'type'=>'required'
        ];
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);

        $validator->after(function ($validator) use($formData){
            $type = $formData['type'];
            $name = $formData['name'];
            $result = Test_category::where('name' , $name)->where('type',$type)->first();
            if(!empty($result)){
                $validator->errors()->add(
                    'name', 'This category is already taken.');
            }
        });

        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            unset($formData['_token']);
            $user = Auth::user();
            $formData['user_id'] = $user->id;
            $result = Test_category::insert($formData);
            $data['response'] = true;
        }
        echo json_encode($data);
    }

}
