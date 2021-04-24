<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Test_category;

class TestcategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateParameter($id='0')
    {
    	$data = [];
    	$data['response'] = false;
    	$result = Test_category::where('id',$id)->first();
    	if(!empty($result)){
    		$data['result'] = $result;
    		$data['response'] = true;
    	}
    	echo json_encode($data);
    }

    public function processParameters(Request $request)
    {
    	$data = [];
    	$data['response'] = false;

    	$formData = $request->all();
    	$rules = [
	        'name'=>'required|min:1',
	        'units'=>'required|min:1',
	        'normal_value'=>'required|min:1',
	        'status'=>'required'
	    ];
	    $messages = [];
	    $attributes = [
	    	'normal_value' => 'normal value'
	    ];
    	$validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
        	$id = $formData['id'];
        	unset($formData['_token'],$formData['id']);
        	if(!empty($id)){
                $result = Test_category::where('id',$id)->update($formData);
        	}
        	else{
        		$formData['user_id'] = Auth::user()->id;
        		$formData['type'] = 4;
        		$result = Test_category::insert($formData);
        	}
	        $data['response'] = true;
        }
        echo json_encode($data);
    }

}
