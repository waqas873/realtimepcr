<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use App\Liability;

class LiabilitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Karachi");
        $this->date_time = date('Y:m:d H:i:s');
    }

    public function liabilities()
    {
        $data = [];
        $result = new Liability;
        $data['records'] = $result->all();
        $data['current_assets'] = $result->where('type' , 1)->where('sub_type' , 1)->sum('value');
        $data['non_current_assets'] = $result->where('type' , 1)->where('sub_type' , 2)->sum('value');
        $data['current_liabilities'] = $result->where('type' , 2)->where('sub_type' , 1)->sum('value');
        $data['non_current_liabilities'] = $result->where('type' , 2)->where('sub_type' , 2)->sum('value');
        return view('admin.accounts.liabilities',$data);
    }

    public function update($id='0')
    {
    	$data = [];
    	$data['response'] = false;
    	$result = Liability::where('id',$id)->get();
    	if(!empty($result)){
    		$data['result'] = $result[0];
    		$data['response'] = true;
    	}
    	echo json_encode($data);
    }

    public function processAdd(Request $request)
    {
    	$data = [];
    	$data['response'] = false;

    	$formData = $request->all();
    	$rules = [
	        'name'=>'required|min:1',
	        'type'=>'required',
	        'sub_type'=>'required',
	        'value'=>'required',
	    ];
	    $messages = [];
	    $attributes = [
	    	'sub type' => 'sub type'
	    ];
    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	//$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
        	$id = $formData['id'];
        	unset($formData['_token'],$formData['id']);
        	$formData['user_id'] = Auth::user()->id;
        	if(!empty($id)){
                $result = Liability::where('id',$id)->update($formData);
        	}
        	else{
        		$result = Liability::insert($formData);
        	}
	        $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function delete($id = '0')
    {
        $permissions = permissions();
        if($permissions['role']!=1){
            return redirect('admin/home'); exit;
        }
        $data  = [];
        $resutl = Liability::where('id',$id)->first();
        if(empty($resutl)){
            return redirect('admin/accounts/liabilities')->with('error_message' , 'This record does not exist.');
        }
        Liability::where('id',$id)->delete();
        return redirect('admin/accounts/liabilities')->with('success_message' , 'Record has been deleted successfully.');
    }

}
