<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Admin_permission;
use App\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $permissions = permissions();
        if($permissions['role']!=1){
            return redirect('admin/home'); exit;
        }
        $data = [];
        $data['admins'] = User::where('role',7)->get();
        return view('admin.admins.index',$data);
    }

    public function add()
    {
        $permissions = permissions();
        if($permissions['role']!=1){
            return redirect('admin/home'); exit;
        }
        $data = [];
        return view('admin.admins.add',$data);
    }

    public function processAdd(Request $request)
    {
    	$data = [];
    	$data['response'] = false;

    	$formData = $request->all();
    	$rules = [
	        'name'=>'required|min:1',
	        'contact_no'=>'required',
            'status'=>'required',
	        'email'=>'required|unique:users|email'
	    ];
	    if(!empty($formData['password'])){
            $rules['password'] = 'min:5';
        }
	    $messages = [];
	    $attributes = [];
    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            unset($formData['_token']);
        	
    		$admin = new User;
    		$admin->name = $formData['name'];
    		$admin->email = $formData['email'];
    		$admin->contact_no = $formData['contact_no'];
            $admin->status = $formData['status'];
    		$admin->role = 7;
    		$admin->password = Hash::make(123456789);
            if(!empty($formData['password'])){
                $admin->password = Hash::make($formData['password']);
            }
    		if($admin->save()){
    			$id = $admin->id;
    			unset($formData['name'],$formData['email'],$formData['password'],$formData['contact_no'],$formData['status']);
    			foreach($formData as $key => $value){
    				$save = [];
    				$save['user_id'] = $id;
    				$save['permission'] = $value;
    				Admin_permission::insert($save);
    			}
    			$data['response'] = true;
    		}
        }
        echo json_encode($data);
    }

    public function update($id = 0)
    {
        $permissions = permissions();
        if($permissions['role']!=1){
            return redirect('admin/home'); exit;
        }
        $data = [];
        $id = decodeBase64($id);
        $result = User::where('id',$id)->first();
        if(empty($result)){
            return redirect('admin/sub-admins')->with('error_message' , 'Invalid request to update the admin');
        }
        $data['result'] = $result;
        return view('admin.admins.update',$data);
    }

    public function processUpdate(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [
            'name'=>'required|min:1',
            'contact_no'=>'required',
            'status'=>'required'
        ];
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            $id = $formData['id'];
            
            $admin = new User;
            $admin = $admin->where('id',$id)->first();
            $admin->name = $formData['name'];
            $admin->contact_no = $formData['contact_no'];
            $admin->status = $formData['status'];

            unset($formData['_token'],$formData['id'],$formData['name'],$formData['contact_no'],$formData['status']);

            if($admin->save()){
                Admin_permission::where('user_id',$id)->delete();
                foreach($formData as $key => $value){
                    $save = [];
                    $save['user_id'] = $id;
                    $save['permission'] = $value;
                    Admin_permission::insert($save);
                }
                $data['response'] = true;
            }
        }
        echo json_encode($data);
    }

    public function delete_admin($id = '0')
    {
        $permissions = permissions();
        if($permissions['role']!=1){
            return redirect('admin/home'); exit;
        }
        $data  = [];
        $resutl = User::where('id',$id)->first();
        if(empty($resutl)){
            return redirect('admin/sub-admins')->with('error_message' , 'This admin does not exist.');
        }
        User::where('id',$id)->delete();
        Admin_permission::where('user_id',$id)->delete();
        return redirect('admin/sub-admins')->with('success_message' , 'Admin has been deleted successfully.');
    }

}
