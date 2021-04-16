<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Session;

class UserController extends Controller
{
	public $date_time;

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next){
        	if(Session::get('user_id')==null){
                return redirect('/redirected');
            }
            return $next($request);
        });

        date_default_timezone_set("Asia/Karachi");
        $this->date_time = date('Y:m:d H:i:s');
    }

    public function update()
    {
    	$data = [];
    	$data['user'] = Auth::user();
    	return view('users.update' , $data);
    }

    public function process_update(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['oldpass'] = false;

        $formData = $request->all();

        $user = Auth::user();

        $rules = [
            'old_password'=>'required',
            'password'=>'required|confirmed|min:5'
        ];
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);

        if(!Hash::check($formData['old_password'], $user->password)){ 
            $data['oldpass'] = true;
            echo json_encode($data);
            exit;
        }

        if($validator->fails()){
            $errors = $validator->errors();
            //$data['old_password'] = $errors->first('old_password');
            $data['password'] = $errors->first('password');
        }
        else{
            //dd($formData);
            //$old = $formData['old_password'];
            $user = Auth::user();
            $user_id = $user->id;

            $update = [];
            $update['password'] = Hash::make($formData['password']);
            User::where('id' , $user_id)->update($update);

            $data['response'] = true;
        }
        echo json_encode($data);
    }
}
