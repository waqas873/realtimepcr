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
use App\Category;
use App\Ledger;
use App\Doctor_category;
use App\Doctor_test;
use App\Test;

class DoctorsController extends Controller
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
        if($permissions['role']==7 && (empty($permissions['doctors_read']))){
            return redirect('admin/home');
        }
        $data = [];
        $data['doctors'] = Doctor::all();
        return view('doctors.index',$data);
    }

    public function viewProfile($id = 0)
    {
        $data = [];
        $cp = new Doctor;
        $result = $cp->find($id);
        if(!empty($result)){
            $data['result'] = $result;
            $data['tests'] = Test::all();
            $data['doctor_tests'] = Doctor_test::all();
            if(empty($result->doctor_categories[0])){
                $categories = Category::all();
                if(!empty($categories)){
                    foreach($categories as $key => $value){
                        $save = new Doctor_category;
                        $save->user_id = Auth::user()->id;
                        $save->doctor_id = $id;
                        $save->category_id = $value->id;
                        $save->discount_percentage = 0;
                        $save->save();
                    }
                }
            }
            $amount_paid = Ledger::where('doctor_id',$id)->where('is_credit',1)->sum('amount');
            $amount_payable = Ledger::where('doctor_id',$id)->where('is_debit',1)->sum('amount');
            $data['amount_paid'] = $amount_paid;
            $data['amount_payable'] = $amount_payable-$amount_paid;
            return view('doctors.view_profile',$data);
        }
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

    public function updateDoctorCategory($id='0')
    {
        $data = [];
        $data['response'] = false;
        $result = Doctor_category::find($id);
        if(!empty($result)){
            $data['result'] = $result;
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function processUpdateDoctorCategory(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [
            'id'=>'required',
            'discount_percentage' => 'required|min:1|max:3',
            'custom_prizes' => 'required'
        ];
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            $id = $formData['id'];
            unset($formData['_token'],$formData['id']);
            if(!empty($id)){
                $result = Doctor_category::where('id',$id)->update($formData);
                $data['response'] = true;
            }
        }
        echo json_encode($data);
    }

    public function updateDoctorTest($id='0')
    {
        $data = [];
        $data['response'] = false;
        $result = Doctor_test::find($id);
        if(!empty($result)){
            $data['result'] = $result;
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function processDoctorTest(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [
            'doctor_id'=>'required',
            'test_id' => 'required',
            'discounted_price' => 'required'
        ];
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            $id = $formData['id'];
            unset($formData['_token'],$formData['id']);
            if(!empty($id)){
                $result = Doctor_test::where('id',$id)->update($formData);
            }
            else{
                $formData['user_id'] = Auth::user()->id;
                Doctor_test::insert($formData);
            }
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function delete_doctor_test($id = 0 , $doctor_id = 0)
    {
        $data  = [];
        $result = Doctor_test::find($id);
        if(empty($result)){
            return redirect('admin/doctor-profile/'.$doctor_id)->with('error_message' , 'This record does not exist.');
        }
        Doctor_test::where('id',$id)->delete();
        return redirect('admin/doctor-profile/'.$doctor_id)->with('success_message' , 'Record has been deleted successfully.');
    }

}
