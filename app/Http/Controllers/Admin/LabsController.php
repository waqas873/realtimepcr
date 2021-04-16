<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\User;
use App\Lab;

class LabsController extends Controller
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
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['labs_read']))){
            return redirect('admin/home');
        }
        $data = [];
        $data['labs'] = Lab::orderBy('id' , 'DESC')->get();
        return view('admin.labs.index',$data);
    }

    public function process_add(Request $request)
    {
        $data = [];
        $data['response'] = false;

    	$formData = $request->all();
        //dd($formData,true);
    	$rules = [
	        'name'=>'required|unique:labs|min:2',
	        'type' => 'required',
	        'domain' => 'required|min:1',
            'city' => 'required|min:1',
	        'focal_person' => 'required|min:1',
	        'contact_no'=>'required|min:10|max:17',
	        'address' => 'required|min:3'
	    ];
        //dd($rules);
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
            $data['type'] = $errors->first('type');
            $data['domain'] = $errors->first('domain');
            $data['city'] = $errors->first('city');
            $data['focal_person'] = $errors->first('focal_person');
            $data['address'] = $errors->first('address');
        }
        else{
            unset($formData['_token']);
            //dd($formData);
            $user = Auth::user();

            $save = new Lab;
            $save->user_id = $user->id;
            $save->name = $formData['name'];
            $save->type = $formData['type'];
            $save->domain = $formData['domain'];
            $save->city = $formData['city'];
            $save->focal_person = $formData['focal_person'];
            $save->contact_no = $formData['contact_no'];
            $save->address = $formData['address'];

            $save->created_at = $this->date_time;
            $save->updated_at = $this->date_time;
            if($save->save()){
                $data['response'] = true;
            }
        }
        echo json_encode($data);
    }

}
