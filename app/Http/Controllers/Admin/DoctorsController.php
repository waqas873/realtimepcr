<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Doctor;
use App\User;

class DoctorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['doctors_read']))){
            return redirect('admin/home');
        }
        $data = [];
        $data['doctors'] = Doctor::all();
        return view('doctors.index',$data);
    }

    public function update($id='0')
    {
    	$data = [];
    	$data['response'] = false;
    	$user = User::where('id',$id)->get();
    	$doctor = Doctor::where('user_id',$id)->get();
    	if(!empty($user)){
    		$data['user'] = $user[0];
    		$data['doctor'] = $doctor[0];
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
	        'affiliate_share'=>'required',
	        'hospital'=>'required|min:1'
	    ];
        if(empty($formData['id'])){
            $rules['email'] = 'required|unique:users|email';
        }
        else{
            $rules['email'] = 'required|email';
        }
	    $messages = [];
	    $attributes = [];
    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	//$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $errors = $validator->errors();
            $data['name'] = $errors->first('name');
            $data['email'] = $errors->first('email');
            $data['hospital'] = $errors->first('hospital');
            $data['affiliate_share'] = $errors->first('affiliate_share');
        }
        else{
        	$id = $formData['id'];
        	unset($formData['_token'],$formData['id']);
        	
        	if(!empty($id)){
        		$result = User::where('id',$id)->get();
        		if(!empty($result)){
        			$user = [];
        			$user['name'] = $formData['name'];
        			$user['email'] = $formData['email'];
                    if(!empty($formData['password'])){
                        $user['password'] = Hash::make($formData['password']);
                    }
        			User::where('id',$id)->update($user);
        			$doctor = [];
        			$doctor['hospital'] = $formData['hospital'];
        			$doctor['affiliate_share'] = $formData['affiliate_share'];
                    $doctor['contact'] = (!empty($formData['contact']))?$formData['contact']:null;
                    $doctor['bank_name'] = (!empty($formData['bank_name']))?$formData['bank_name']:null;
                    $doctor['account_no'] = (!empty($formData['account_no']))?$formData['account_no']:null;
                    //$doctor['password'] = (!empty($formData['password']))?$formData['password']:null;
        			Doctor::where('user_id',$id)->update($doctor);
        			$data['response'] = true;
        		}
        	}
        	else{
        		$doctor = new User;
        		$doctor->name = $formData['name'];
        		$doctor->email = $formData['email'];
        		$doctor->role = 2;
                if(!empty($formData['password'])){
                    $doctor->password = Hash::make($formData['password']);
                }
                else{
                    $doctor->password = Hash::make(123456789);
                }
        		if($doctor->save()){
        			$id = $doctor->id;
        			$save = [];
        			$save['user_id'] = $id;
        			$save['hospital'] = $formData['hospital'];
                    $save['contact'] = (!empty($formData['contact']))?$formData['contact']:null;
                    $save['bank_name'] = (!empty($formData['bank_name']))?$formData['bank_name']:null;
                    $save['account_no'] = (!empty($formData['account_no']))?$formData['account_no']:null;
        			$save['affiliate_share'] = $formData['affiliate_share'];
        			$result = Doctor::insert($save);
        			$data['response'] = true;
        		}
        	}
        }
        echo json_encode($data);
    }
}
