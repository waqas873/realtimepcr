<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Test;
use App\Test_profile;
use App\Profile_test;
use App\Category;
use App\Reporting_unit;
use App\Sample;
use DB;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update($id='0')
    {
    	$data = [];
    	$data['response'] = false;
    	$result = Test::where('id',$id)->get();
    	if(!empty($result)){
    		$data['test'] = $result[0];
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
	        'name'=>'required|min:1',
	        'category_id'=>'required',
	        'reporting_hrs'=>'required|min:1',
	        'sample_id'=>'required',
	        'reporting_unit_id'=>'required',
	        'price'=>'required|min:1'
	    ];
        if($formData['reporting_unit_id']==4){
            $rules['units'] = 'required|min:1';
            $rules['normal_value'] = 'required|min:1';
        }
	    $messages = [];
	    $attributes = [
	    	'category_id' => 'category name',
	    	'reporting_hrs' => 'reporting time',
	    	'sample_id' => 'sample',
	    	'reporting_unit_id' => 'reporting unit'
	    ];
        if($formData['reporting_unit_id']==4){
            $attributes['normal_value'] = 'normal value';
        }
    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	//$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
        	$id = $formData['id'];
            $rui = $formData['reporting_unit_id'];
            // if($formData['reporting_unit_id']==4){
            //     unset($formData['reporting_unit_id']);
            // }
        	unset($formData['_token'],$formData['id']);
            if(empty($formData['comments'])){
                $formData['comments'] = null;
            }
        	if(!empty($id)){
                if($rui != 4){
                    $formData['units'] = null;
                    $formData['normal_value'] = null;
                }
                $result = Test::where('id',$id)->update($formData);
        	}
        	else{
        		$formData['unique_id'] = '#'.rand(1,100000000);
        		$result = Test::insert($formData);
        	}
	        $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function process_add_profile(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $id = $formData['id'];
        if(!empty($id)){
            $rules = [
                'name'=>'required|min:1',
                'price'=>'required',
                'tests'=>'required'
            ];
        }
        else{
            $rules = [
                'name'=>'required|unique:test_profiles|min:1',
                'price'=>'required',
                'tests'=>'required'
            ];
        }
        
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        //$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $errors = $validator->errors();
            $data['name'] = $errors->first('name');
            $data['price'] = $errors->first('price');
            $data['tests'] = $errors->first('tests');
        }
        else{
            $id = $formData['id'];
            if(!empty($id)){
                $update = ['name'=>$formData['name']];
                $update['price'] = $formData['price'];
                Test_profile::where('id',$id)->update($update);
                Profile_test::where('test_profile_id',$id)->delete(); 
                $test_profile_id = $id;
            }
            else{
                $save = new Test_profile;
                $save->name = $formData['name'];
                $save->price = $formData['price'];
                if($save->save()){
                    $test_profile_id = $save->id;
                }
            }
            if(!empty($formData['tests'])){
                $tests = $formData['tests'];
                foreach($tests as $test_id){
                    $save = [];
                    $save['test_profile_id'] = $test_profile_id;
                    $save['test_id'] = $test_id;
                    Profile_test::insert($save);
                }
            }
            
            $data['response'] = true;
        }
        
        echo json_encode($data);
    }

    public function update_test_profile($id='0')
    {
        $data = [];
        $data['response'] = false;
        $tests = Test::orderBy('id','DESC')->get();
        $data['tests'] = '';
        $result = Test_profile::where('id',$id)->get();
        if(!empty($result)){
            $data['profile'] = $result[0];
            $data['response'] = true;
            if(!empty($tests)){
                foreach($tests as $record){
                    
                    $profile_test = Profile_test::where('test_profile_id',$id)->where('test_id',$record->id)->get();
                    //dd($profile_test);
                    $selected = ' ';
                    if(!empty($profile_test)){
                        $selected = 'selected="selected"';
                    }

                    $data['tests'] .= '<option value="'.$record->id.'">'.$record->name.'</option>';
                }
            }
        }
        echo json_encode($data);
    }

    public function delete($id='0')
    {
        $result = Test::where('id',$id)->get();
        if(!empty($result)){
            Test::where('id',$id)->delete();
            return redirect('admin/cpanel')->with('success_message','Test has been deleted successfully.');
        }
        return redirect('admin/cpanel');
    }

    public function delete_test_profile($id='0')
    {
        $result = Test_profile::where('id',$id)->get();
        if(!empty($result)){
            Test_profile::where('id',$id)->delete();
            Profile_test::where('test_profile_id',$id)->delete();
            return redirect('admin/cpanel')->with('success_message','Test Profile has been deleted successfully.');
        }
        return redirect('admin/cpanel');
    }

}
