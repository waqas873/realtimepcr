<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Collection_point;
use App\Lab;
use App\Patient;
use App\Invoice;
use App\Country;
use App\Test;
use App\Ledger;
use App\Airline;
use App\Commission_test;

class StaffController extends Controller
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
        if($permissions['role']==7 && (empty($permissions['app_users_read']))){
            return redirect('admin/home');
        }
        $data = [];

        $data['labs'] = Lab::where('status' , 1)->orderBy('id' , 'DESC')->get();
        $data['collection_points'] = Collection_point::where('status' , 1)->orderBy('id' , 'DESC')->get();
        $data['airlines'] = Airline::orderBy('id' , 'DESC')->get();
        $data['countries'] = Country::all();
        $data['tests'] = Test::where('id' ,'>', 0)->orderBy('name' , 'ASC')->get();

        $data['lab_users'] = User::where('role' , 4)->orWhere('role' , '0')->orderBy('id' , 'DESC')->get();
        $data['cp_users'] = User::where('role' , 5)->orderBy('id' , 'DESC')->get();
        $data['embassy_users'] = User::where('role' , 3)->orderBy('id' , 'DESC')->get();
        $data['airline_users'] = User::where('role' , 6)->orderBy('id' , 'DESC')->get();

        return view('admin.staff.index',$data);
    }

    public function viewEmbassyProfile($id = 0)
    {
        $data = [];
        $cp = new User;
        $result = $cp->where('role',3)->find($id);
        if(!empty($result)){
            $data['result'] = $result;
            $data['tests'] = Test::all();
            $data['collection_points'] = Collection_point::all();
            $data['labs'] = Lab::all();
            $data['commission_tests'] = Commission_test::where('collection_point_id','>',0)->orWhere('lab_id','>',0)->get();
            $amount_paid = Ledger::where('embassy_user_id',$id)->where('is_credit',1)->sum('amount');
            $amount_payable = Ledger::where('embassy_user_id',$id)->where('is_debit',1)->sum('amount');
            $data['amount_paid'] = $amount_paid;
            $data['amount_payable'] = $amount_payable-$amount_paid;
            return view('admin.staff.embassy_profile',$data);
        }
    }

    public function viewAirlineProfile($id = 0)
    {
        $data = [];
        $cp = new User;
        $result = $cp->where('role',6)->find($id);
        if(!empty($result)){
            $data['result'] = $result;
            $data['tests'] = Test::all();
            $data['commission_tests'] = Commission_test::where('collection_point_id','=',null)->where('lab_id','=',null)->get();
            $amount_paid = Ledger::where('airline_user_id',$id)->where('is_credit',1)->sum('amount');
            $amount_payable = Ledger::where('airline_user_id',$id)->where('is_debit',1)->sum('amount');
            $data['amount_paid'] = $amount_paid;
            $data['amount_payable'] = $amount_payable-$amount_paid;
            return view('admin.staff.airline_profile',$data);
        }
    }

    public function updateCommissionTest($id='0')
    {
        $data = [];
        $data['response'] = false;
        $result = Commission_test::find($id);
        if(!empty($result)){
            $data['result'] = $result;
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function processCommissionTest(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [
            'to_user_id'=>'required',
            'test_id' => 'required',
            'commission_price' => 'required'
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
            if(!empty($formData['lab_id']) && !empty($formData['collection_point_id'])){
                $formData['collection_point_id'] = null;
            }
            if(!empty($id)){
                $result = Commission_test::where('id',$id)->update($formData);
            }
            else{
                $formData['user_id'] = Auth::user()->id;
                Commission_test::insert($formData);
            }
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function delete_commission_test($id = 0)
    {
        $data  = [];
        $result = Commission_test::find($id);
        if(empty($result)){
            return redirect('admin/embassy-profile/'.$result->to_user_id)->with('error_message' , 'This record does not exist.');
        }
        Commission_test::where('id',$id)->delete();
        return redirect('admin/embassy-profile/'.$result->to_user_id)->with('success_message' , 'Record has been deleted successfully.');
    }

    public function staff_patients($labCp = '' , $id = 0)
    {
        $data = [];
        if($labCp=='lab'){
            $source = new Lab;
        }
        else if($labCp=='collection-point'){
            $source = new Collection_point;
        }
        else{
            return redirect('/admin/reports')->with('error_message' , 'Invalid request.');
        }

        $source = $source->find($id);
        $users = $source->users;
        
        if(empty($users)){
            return redirect('/admin/reports')->with('error_message' , 'There is not any user regarding this request.');
        }
        $data['users'] = $users;

        $staff = [];
        foreach($users as $key => $value){
            array_push($staff, $value->id);
        }

        if($labCp == 'lab'){
            $data['lab'] = $source;
        }
        else{
            $data['cp'] = $source;
        }

        $data['title'] = $source->name;

        $data['patients_registered'] = Patient::whereIn('user_id' , $staff)->count();
        $data['open_cases'] = Invoice::whereIn('user_id' , $staff)->where([
            ['status' ,'<', 5]
        ])->count();
        $data['closed_cases'] = Invoice::whereIn('user_id' , $staff)->where([
            ['status' , 5]
        ])->count();
        $data['pending_balance'] = Invoice::whereIn('user_id' , $staff)->sum('amount_remaining');
        return view('admin.staff.patients',$data);
    }

    public function process_lab_user(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['username_exist'] = false;

    	$formData = $request->all();
        //dd($formData,true);
    	$rules = [
    		'lab_id'=>'required',
    		'role'=>'required',
	        'name'=>'required|min:2',
	        'cnic'=>'required|min:13|max:13',
	        'contact_no'=>'required|min:10|max:17',
	        'username' => 'required|min:5|alpha_num',
	        'password' => 'required|min:5',
	        'pay' => 'required|min:3'
	    ];
	    $messages = [];
	    $attributes = [];
        $attributes['contact_no'] = 'contact no';

    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	//$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $errors = $validator->errors();
            $data['name'] = $errors->first('name');
            $data['contact_no'] = $errors->first('contact_no');
            $data['lab_id'] = $errors->first('lab_id');
            $data['role'] = $errors->first('role');
            $data['cnic'] = $errors->first('cnic');
            $data['username'] = $errors->first('username');
            $data['password'] = $errors->first('password');
            $data['pay'] = $errors->first('pay');
        }
        else{
            unset($formData['_token']);
            //dd($formData);
            $user = Auth::user();

            $save = new User;
            $save->name = $formData['name'];
            $save->contact_no = $formData['contact_no'];
            $save->lab_id = $formData['lab_id'];
            $save->role = $formData['role'];
            $save->cnic = $formData['cnic'];
            $save->pay = $formData['pay'];
            $save->password = Hash::make($formData['password']);

            $lab_domain = '';
            $result = Lab::where('id',$formData['lab_id'])->get();
            if(!empty($result)){
                $lab_domain = $result[0]->domain;
            }
            $save->email = $formData['username'].$lab_domain;

            $save->created_at = $this->date_time;
            $save->updated_at = $this->date_time;

            $result = User::where('email',$save->email)->get();
            if(empty($result[0])){
                $save->save();
                $data['response'] = true;
            }
            else{
            	$data['username_exist'] = true;
            }
        }
        echo json_encode($data);
    }

    public function process_cp_user(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['username_exist'] = false;

    	$formData = $request->all();
        //dd($formData);
    	$rules = [
    		//'collectoin_point_id'=>'required',
            'cp_role'=>'required',
	        'name'=>'required|min:2',
	        'contact_no'=>'required|min:10|max:17',
	        'username' => 'required|min:5|alpha_num',
	        'password' => 'required|min:5'
	    ];
	    $messages = [];
	    $attributes = [];
        $attributes['cp_contact_no'] = 'contact no';
        $attributes['cp_role'] = 'user type';

    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	//$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $errors = $validator->errors();
            $data['cp_role'] = $errors->first('cp_role');
            $data['cp_name'] = $errors->first('name');
            $data['cp_contact_no'] = $errors->first('contact_no');
            //$data['cp_collection_point_id'] = $errors->first('collection_point_id');
            $data['cp_username'] = $errors->first('username');
            $data['cp_password'] = $errors->first('password');
        }
        else{
            unset($formData['_token']);
            //dd($formData);
            $user = Auth::user();

            $cp_role = $formData['cp_role'];

            $save = new User;
            $save->name = $formData['name'];
            $save->contact_no = $formData['contact_no'];
            $save->role = $cp_role;
            if($cp_role==5){
                $save->collection_point_id = $formData['collection_point_id'];
            }
            if($cp_role==6){
                $save->airline_id = $formData['airline_id'];
            }
            if($cp_role==3){
                $save->country_id = $formData['country_id'];
                $save->test_id = $formData['test_id'];
            }
            $save->password = Hash::make($formData['password']);
            
            if($cp_role==5){
                $lab_domain = '';
                $result = Collection_point::where('id',$formData['collection_point_id'])->get();
                if(!empty($result[0])){
                    $lab_domain = $result[0]->domain;
                }
                $save->email = $formData['username'].$lab_domain;
            }
            else{
                $save->email = $formData['username']."@realtimepcr.pk";
            }
            

            $save->created_at = $this->date_time;
            $save->updated_at = $this->date_time;

            $result = User::where('email',$save->email)->get();
            if(empty($result[0])){
                $save->save();
                $data['response'] = true;
            }
            else{
            	$data['username_exist'] = true;
            }
        }
        echo json_encode($data);
    }

    public function get_patients(Request $request)
    {
        $like = array();
        $patients_array = [];
        $post = $request->all();

        $orderByColumnIndex = $post['order'][0]['column'];
        $orderByColumn = $post['columns'][$orderByColumnIndex]['data'];
        $orderType = $post['order'][0]['dir'];
        $offset = $post['start'];
        $limit = $post['length'];
        $draw = $post['draw'];
        $search = $post['search']['value'];
        
        $collection_point_id = $post['collection_point_id'];
        $lab_id = $post['lab_id'];
        $user_id = $post['user_id'];
        $from_date = $post['from_date'];
        $to_date = $post['to_date'];

        if(!empty($lab_id)){
            $source = new Lab;
            $source = $source->find($lab_id);
        }
        else{
            $source = new Collection_point;
            $source = $source->find($collection_point_id);
        }
        $users = $source->users;

        $staff = [];
        if(is_numeric($user_id)){
            array_push($staff, $user_id);
        }
        else{
            foreach($users as $key => $value){
                array_push($staff, $value->id);
            }
        }
        
        $patients_count = Patient::whereIn('user_id' , $staff)->count();
        //dd($patients_count);
        
        $patient = new Patient;

        $result = $patient->whereIn('user_id' , $staff);
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }
        $patients_count_rows = count($result->get());
        
        if(!empty($search)){
            //$result = $result->where();
        }
        
        $patients_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();

        //dd($patients_data);

        if(isset($patients_data)){
            foreach($patients_data as $item){
                $date = date_create($item['created_at']);
                $date = date_format($date,'Y-m-d H:i:s');
                $single_field['created_at'] = $date;
                $single_field['id'] = '#'.$item->id;
                $single_field['name'] = $item->name;
                $single_field['cnic'] = "$item->cnic";
                $single_field['contact_no'] = $item->contact_no;
                $single_field['username'] = (!empty($item->users->name))?$item->users->name:'---';
                $url = url('/admin/patient-detail/'.$item->id);
                $single_field['invoices'] = '<a href="'.$url.'" target="_blank" rel="'.$item->id.'">View Details</a>';
                $patients_array[] = $single_field;
            }
            $data['draw'] = $draw;
            $data['recordsTotal'] = $patients_count;
            $data['recordsFiltered'] = $patients_count_rows;
            $data['data'] = $patients_array;
        } else {
            $data['draw'] = $draw;
            $data['recordsTotal'] = 0;
            $data['recordsFiltered'] = 0;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    public function delete($user_id = '0')
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['app_users_delete']))){
            return redirect('admin/home');
        }
        $data  = [];
        $user = User::find($user_id);
        if(empty($user)){
            return redirect('admin/staff')->with('error_message' , 'This user does not exist.');
        }
        if($user->role==6 || $user->role==3){
            $result = User::where('id',$user_id)->delete();
        }
        if($user->role==5){
            $result = Patient::where('user_id',$user_id)->first();
            if(empty($result)){
                User::where('id',$user_id)->delete();
            }
            else{
                $update = ['status'=>'0'];
                User::where('id',$user_id)->update($update);
            }
        }
        return redirect('admin/staff')->with('success_message' , 'User has been deleted successfully.');
    }

}
