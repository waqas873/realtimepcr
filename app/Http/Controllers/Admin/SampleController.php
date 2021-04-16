<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Sample;
use DB;

class SampleController extends Controller
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
            return redirect('admin/cpanel')->with('error_message','Invalid request of adding sample.');
        }
        
        unset($formData['_token']);
        $result = Sample::insert($formData);

        if(!empty($result)){
            return redirect('admin/cpanel')->with('success_message','Sample has been saved successfully.');
        }

        return redirect('admin/cpanel');
    }
}
