<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function process_add(Request $request)
    {
    	$formData = $request->all();
    	$rules = [
	        'name'=>'required|min:1',
	    ];
	    $messages = [];
	    $attributes = [];
    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	//$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            return redirect('admin/cpanel')->with('error_message','Invalid request of adding category.');
        }
        
        unset($formData['_token']);
        $result = Category::insert($formData);

        if(!empty($result)){
            return redirect('admin/cpanel')->with('success_message','Category has been saved successfully.');
        }
        return redirect('admin/cpanel');
    }

    public function processCategory(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $formData = $request->all();
        $rules = [
            'name'=>'required|min:1'
        ];
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            unset($formData['_token']);
            $result = Category::insert($formData);
            $data['response'] = true;
        }
        echo json_encode($data);
    }

}
