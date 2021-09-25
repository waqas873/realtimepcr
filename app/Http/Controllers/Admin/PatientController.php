<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Patient;
use App\Passenger;
use App\Patient_test;
use App\Test;
use App\User;
use App\Test_profile;
use App\Deleted_patient;
use App\Amount;
use App\Airline;
use App\Profile_test;
use App\Invoice;
use App\Cash;
use App\Country;
use App\Log;
use App\Lab;
use App\Category;
use App\Collection_point;
use Session;

class PatientController extends Controller
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
        $data = [];
        $data['labs'] = Lab::where('status' , 1)->orderBy('id' , 'DESC')->get();
        $data['collection_points'] = Collection_point::where('status' , 1)->orderBy('id' , 'DESC')->get();
        $data['tests'] = Test::where('id','>',0)->orderBy('id' , 'DESC')->get();
        $data['categories'] = Category::where('id','>',0)->orderBy('id' , 'DESC')->get();
        $data['doctors'] = User::where('role',2)->orderBy('id' , 'DESC')->get();
        $data['users'] = User::where('role',0)->orWhere('role',5)->orderBy('id' , 'DESC')->get();
        $data['lab_users'] = User::where('role',4)->orderBy('id' , 'DESC')->get();
        $data['airlines'] = Airline::all();
        $data['countries'] = Country::all();
        return view('admin.patients.index',$data);
    }

    public function patient_tests()
    {
        $data = [];
        $data['labs'] = Lab::where('status' , 1)->orderBy('id' , 'DESC')->get();
        $data['collection_points'] = Collection_point::where('status' , 1)->orderBy('id' , 'DESC')->get();
        $data['tests'] = Test::where('id','>',0)->orderBy('id' , 'DESC')->get();
        $data['doctors'] = User::where('role',2)->orderBy('id' , 'DESC')->get();
        $data['users'] = User::where('role',0)->orWhere('role',5)->orderBy('id' , 'DESC')->get();
        $data['lab_users'] = User::where('role',4)->orderBy('id' , 'DESC')->get();
        $data['airlines'] = Airline::all();
        $data['countries'] = Country::all();
        return view('admin.patients.patient_tests',$data);
    }

    public function update($patient_id = 0)
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['patients_update']))){
            return redirect('admin/patients');
        }

        $data = [];
        $result = Patient::where('id' , $patient_id)->where('is_deleted' , '0')->get();
        if(empty($result[0])){
            return redirect('admin/patients')->with('error_message' , 'Invalid request to update the patient');
        }
        $data['result'] = $result[0];
        $data['doctors'] = User::where('role' , 2)->get();
        $data['airlines'] = Airline::all();
        $data['countries'] = Country::all();
        return view('admin.patients.update',$data);
    }

    public function process_update(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['reason'] = false;

        $formData = $request->all();
        //dd($formData,true);
        $patient_id = $formData['patient_id'];

        $rules = [
            'name'=>'required|min:3',
            'contact_no'=>'required|min:10|max:17|unique:patients,contact_no,'.$patient_id
        ];
        if(!empty($formData['email'])){
            $rules['email'] = 'email';
        }
        if(!empty($formData['cnic'])){
            //$rules['cnic'] = 'required|min:13|max:13|unique:patients,cnic,'.$patient_id;
            $rules['cnic'] = 'required|min:13|max:13';
        }

        $messages = [];
        $attributes = [];
        $covid = false;
        if(isset($formData['passport_no'])){
            $pangr = Passenger::where('patient_id' , $patient_id)->first();
            $rules['passport_no'] = 'required|min:1|unique:passengers,passport_no,'.$pangr->id;
            $rules['airline'] = 'required|min:1';
            //$rules['collection_point'] = 'required|min:1';
            $rules['country_id'] = 'required';
            $rules['flight_date'] = 'required|min:1';
            $rules['flight_time'] = 'required|min:1';

            $attributes['passport_no'] = 'passport no';
            $attributes['country_id'] = 'country';
            $attributes['flight_date'] = 'flight date';
            $attributes['flight_time'] = 'flight time';
            $covid = true;
        }

        $validator = Validator::make($formData,$rules,$messages,$attributes);
        //$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $errors = $validator->errors();
            $data['name'] = $errors->first('name');
            $data['contact_no'] = $errors->first('contact_no');

            $data['email'] = (!empty($formData['email']))?$errors->first('email'):'';
            $data['cnic'] = (!empty($formData['cnic']))?$errors->first('cnic'):'';

            $data['passport_no'] = ($covid==true)?$errors->first('passport_no'):'';
            $data['airline'] = ($covid==true)?$errors->first('airline'):'';
            $data['country_id'] = ($covid==true)?$errors->first('country_id'):'';
            $data['flight_date'] = ($covid==true)?$errors->first('flight_date'):'';
            $data['flight_time'] = ($covid==true)?$errors->first('flight_time'):'';
        }
        else{
            if(Session::has('reason'))
            {
                $patient = [];
                $patient['name'] = $formData['name'];
                $patient['cnic'] = $formData['cnic'];
                $patient['dob'] = $formData['dob'];
                $patient['sex'] = $formData['sex'];
                $patient['contact_no'] = $formData['contact_no'];
                $patient['email'] = $formData['email'];
                $patient['reffered_by'] = $formData['reffered_by'];
                $permissions = permissions();
                if($permissions['role'] == 1 || (!empty($permissions['patients_timing_change']))){
                    if(!empty($formData['sample_date'])){
                        $patient['sample_date'] = $formData['sample_date'];
                    }
                }

                $patient['updated_at'] = $this->date_time;

                if(!empty($_FILES['avatar']['tmp_name'])){
                    $file = $_FILES['avatar'];
                    $imgData = base64_encode(file_get_contents($file['tmp_name']));
                    //$src = 'data: '.mime_content_type($img_file).';base64,'.$imgData;
                    $url = $_SERVER["DOCUMENT_ROOT"];
                    $uid = time().uniqid(rand());
                    $output = $url.'/assets/webcam/avatar/'.$uid.'_avatar.jpg';
                    $contents = file_get_contents($file['tmp_name']);
                    file_put_contents($output, $contents);
                    $patient['image'] = $uid.'_avatar.jpg';
                }

                Patient::where('id' , $patient_id)->update($patient);

                if(!empty($formData['invoice_id'])){
                    $invoice_id = $formData['invoice_id'];
                    $update = ['created_at'=>$formData['created_at'],'updated_at'=>$formData['reporting_time']];
                    Invoice::where('id' , $invoice_id)->update($update);
                }

                $log = new Log;
                $log->user_id = Auth::user()->id;
                $log->activity = 'updated';
                $log->reason = Session::get('reason');
                $log->log_of = 'patient';
                $log->log_of_id = $patient_id;
                $log->save();

                if($covid==true){
                    $passenger['passport_no'] = $formData['passport_no'];
                    $passenger['airline'] = $formData['airline'];
                    $passenger['country_id'] = $formData['country_id'];
                    $passenger['flight_date'] = $formData['flight_date'];
                    $passenger['flight_time'] = $formData['flight_time'];
                    $passenger['flight_no'] = $formData['flight_no'];
                    $passenger['booking_ref_no'] = $formData['booking_ref_no'];
                    $passenger['ticket_no'] = $formData['ticket_no'];
                    $passenger['updated_at'] = $this->date_time;
                    Passenger::where('patient_id' , $patient_id)->update($passenger);
                    
                    $invoice_id = 0;
                    $result = Passenger::where('patient_id' , $patient_id)->get();
                    $invoice_id = $result[0]->invoice_id;
                    //$udpate = ['updated_at'=>$formData['reporting_time']];
                    //dd($formData['reporting_time']);
                    //Patient_test::where('patient_id' , $patient_id)->where('invoice_id' , $invoice_id)->update($udpate);

                    $result = Patient_test::where('patient_id' , $patient_id)->where('test_id' , 760)->where('type' , 2)->get();
                    if(!empty($result[0]->id)){
                        $this->api_update_request($patient_id);
                    }

                }
                Session::forget('reason');
                $data['response'] = true;
            }
            else{
                $data['reason'] = true;
            }
            //dd($formData);

            
            // Patient::insert($formData);
            // $patient_id = DB::getPdo()->lastInsertId();
        }
        
        echo json_encode($data);
    }

    public function api_update_request($patient_id = 0)
    {
        $patient = Patient::find($patient_id);
        if(empty($patient->id)){
            return false;
        }
        $curl = curl_init();
        $user_name = "rtladmin";
        $API_Secret_Key = "a19a0323fd1f94992bdb8b3822da41746qmqv0PzLnTKEY";
        $parameters = array(
            "pcode" => "pat-".$patient->id, 
            "pname" => $patient->name,
            "ppass" => $patient->passenger->passport_no,
            "pcnic" => $patient->cnic,
            "sampt" => $patient->created_at,
            "pres" => "", 
            "rept" => "",
            "tname" => "COVID"
        );
        $url = "https://app.arham.services/api/v1/pushdata?";
        foreach($parameters as $key=>$value){
            $url .= urlencode($key)."=".urlencode($value)."&";
        }
        $url = substr($url, 0, -1);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".base64_encode($user_name.":".$API_Secret_Key)
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response_decoded = json_decode($response);
        if(!empty($response_decoded->code) && $response_decoded->code == 1){
            $patient_test = Patient_test::where('patient_id' , $patient_id)->where('type' , 2)->where('test_id' , 760)->orderBy('id' , 'DESC')->get();
            if(!empty($patient_test[0]->id)){
                $id = $patient_test[0]->id;
                $patient_test = Patient_test::where('id' , $id)->update(['api_sent'=>1]);
                return true;
            }
        }
        return false;
    }

    public function process_reason(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();

        $rules = [
            'reason'=>'required|min:20'
        ];
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        //$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $errors = $validator->errors();
            $data['reason'] = $errors->first('reason');
        }
        else{
            $reason = $formData['reason'];
            Session::put('reason' , $reason);
            $data['response'] = true;
        }
        
        echo json_encode($data);
    }

    public function delete_reason()
    {
        $data = [];
        $data['reason'] = false;
        if(!Session::has('reason')){
            $data['reason'] = true;
        }
        echo json_encode($data);
    }

    public function detail($patient_id = '0')
    {
        $data  = [];
        $patient = Patient::where('id',$patient_id)->where('is_deleted' , '0')->get();
        if(empty($patient[0])){
            return redirect('admin/reports')->with('error_message' , 'This patient does not exist.');
        }

        $data['patient'] = $patient[0];
        $data['amount_paid'] = Invoice::where('patient_id' , $patient_id)->sum('amount_paid');
        $data['amount_remaining'] = Invoice::where('patient_id' , $patient_id)->sum('amount_remaining');

        $data['open_cases'] = Invoice::where('status','<=','3')->where('patient_id',$patient_id)->orderBy('id' , 'DESC')->get();
        $data['delivered_reports'] = Invoice::where('status','5')->where('patient_id',$patient_id)->orderBy('id' , 'DESC')->get();
        $data['invoices'] = Invoice::where('patient_id',$patient_id)->orderBy('id' , 'DESC')->get();
        return view('admin.patients.detail',$data);
    }

    public function delete($patient_id = '0')
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['patients_delete']))){
            return redirect('admin/patients');
        }

        $data  = [];
        $patient = Patient::where('id',$patient_id)->first();
        if(empty($patient)){
            return redirect('admin/patients')->with('error_message' , 'This patient does not exist.');
        }

        $this->api_delete_request($patient_id);

        $deleted = new Deleted_patient;
        $deleted->user_id = $patient->user_id;
        $deleted->name = $patient->name;
        $deleted->cnic = $patient->cnic;
        $deleted->dob = $patient->dob;
        $deleted->sex = $patient->sex;
        $deleted->contact_no = $patient->contact_no;
        $deleted->email = $patient->email;
        $deleted->reffered_by = $patient->reffered_by;
        $deleted->deleted_by = Auth::user()->id;
        $deleted->save();
        $id = $deleted->id;
        
        $result = Patient::where('id',$patient_id)->delete();

        $log = new Log;
        $log->user_id = Auth::user()->id;
        $log->activity = 'deleted';
        $log->reason = Session::get('reason');
        $log->log_of = 'patient';
        $log->log_of_id = $id;
        $log->save();
        
        Session::forget('reason');

        $result = Invoice::where('patient_id',$patient_id)->delete();
        $result = Patient_test::where('patient_id',$patient_id)->delete();
        $result = Passenger::where('patient_id',$patient_id)->delete();

        return redirect('admin/patients')->with('success_message' , 'Patient has been deleted successfully.');
    }

    public function delete_multiple_patients(Request $request)
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['patients_delete']))){
            return redirect('admin/patients');
        }

        $data  = [];
        $post = $request->all();
        if(empty($post['patient_ids'])){
            return redirect('admin/patients')->with('error_message' , 'Please select a patient to delete.');
        }
        //dd($post['patient_ids']);
        foreach($post['patient_ids'] as $patient_id){
            $patient = Patient::where('id',$patient_id)->first();
            if(empty($patient)){
                continue;
            }
            $this->api_delete_request($patient_id);

            $deleted = new Deleted_patient;
            $deleted->user_id = $patient->user_id;
            $deleted->name = $patient->name;
            $deleted->cnic = $patient->cnic;
            $deleted->dob = $patient->dob;
            $deleted->sex = $patient->sex;
            $deleted->contact_no = $patient->contact_no;
            $deleted->email = $patient->email;
            $deleted->reffered_by = $patient->reffered_by;
            $deleted->deleted_by = Auth::user()->id;
            $deleted->save();
            $id = $deleted->id;

            $result = Patient::where('id',$patient_id)->delete();

            $log = new Log;
            $log->user_id = Auth::user()->id;
            $log->activity = 'deleted';
            $log->reason = "Multiple deleted";
            $log->log_of = 'patient';
            $log->log_of_id = $id;
            $log->save();

            $result = Invoice::where('patient_id',$patient_id)->delete();
            $result = Patient_test::where('patient_id',$patient_id)->delete();
            $result = Passenger::where('patient_id',$patient_id)->delete();
                
        }
        return redirect('admin/patients')->with('success_message' , 'Patients has been deleted successfully.');
    }

    public function delete_permanently($patient_id = '0')
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['deleted_patients_delete']))){
            return redirect('admin/home');
        }
        $data  = [];
        $patient = Deleted_patient::where('id',$patient_id)->first();
        if(empty($patient)){
            return redirect('admin/deleted-patients')->with('error_message' , 'This patient does not exist.');
        }
        $result = Deleted_patient::where('id',$patient_id)->delete();
        return redirect('admin/deleted-patients')->with('success_message' , 'Patient has been deleted successfully.');
    }

    public function api_delete_request($patient_id = 0)
    {
        $patient = Patient::find($patient_id);
        if(empty($patient->id)){
            return false;
        }
        $curl = curl_init();
        $user_name = "rtladmin";
        $API_Secret_Key = "a19a0323fd1f94992bdb8b3822da41746qmqv0PzLnTKEY";
        $parameters = array(
            "pascode" => "pat-".$patient->id, 
            "labcode" => "RTL-192-8582"
        );
        $url = "https://app.arham.services/api/v1/canceltest?";
        foreach($parameters as $key=>$value){
            $url .= urlencode($key)."=".urlencode($value)."&";
        }
        $url = substr($url, 0, -1);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".base64_encode($user_name.":".$API_Secret_Key)
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response_decoded = json_decode($response);
        if(!empty($response_decoded->code) && $response_decoded->code == 1){
            return true;
        }
        return false;
    }

    public function get_patients(Request $request)
    {
        $like = array();
        $result_array = [];
        $post = $request->all();

        $orderByColumnIndex = $post['order'][0]['column'];
        $orderByColumn = $post['columns'][$orderByColumnIndex]['data'];
        $orderType = $post['order'][0]['dir'];
        $offset = $post['start'];
        $limit = $post['length'];
        $draw = $post['draw'];
        $search = $post['search']['value'];

        $from_date = $post['from_date'];
        $to_date = $post['to_date'];
        $lab_id = $post['lab_id'];
        $test_id = $post['test_id'];
        $doctor_id = $post['doctor_id'];
        $user_id = $post['user_id'];
        $payment_filter = $post['payment_filter'];
        $lab_user = $post['lab_user'];
        $collection_point_id = $post['collection_point_id'];
        $local_overseas = $post['local_overseas'];
        $airline = $post['airline'];
        $country_id = $post['country_id'];
        $test_result = $post['test_result'];
        $passport_no = $post['passport_no'];
        $flight_no = $post['flight_no'];

        
        //$status = $post['status_filter'];

        $auth = Auth::user();

        $result_count = Patient_test::where('id' ,'>' , 0)->count();

        $result = new Patient_test;

        if(!empty($lab_id) && $lab_id!="all"){
            $users = User::where('lab_id' , $lab_id)->get();
            $staff = [0];
            if(!empty($users[0])){
                foreach($users as $key => $value){
                    array_push($staff, $value->id);
                }
            }
            $result = $result->whereIn('user_id' , $staff);
        }

        if(!empty($collection_point_id) && $collection_point_id!="all"){
            $users = User::where('collection_point_id' , $collection_point_id)->get();
            $staff = [0];
            if(!empty($users[0])){
                foreach($users as $key => $value){
                    array_push($staff, $value->id);
                }
            }
            $result = $result->whereIn('user_id' , $staff);
        }

        if(!empty($lab_user) && $lab_user!="all"){
            $result = $result->where('processed_by',$lab_user);
        }

        if(!empty($local_overseas) && $local_overseas!="all"){
            $result = $result->where('type',$local_overseas);
        }

        if(!empty($test_id) && $test_id!="all"){
            $result = $result->where('test_id',$test_id);
        } 

        if(!empty($doctor_id) && $doctor_id!="all"){
            $result = $result->whereHas('patient', function($q) use($doctor_id){
                    $q->where('reffered_by', $doctor_id);
                }
            );
        } 
        
        if(!empty($user_id) && $user_id!="all"){
            $result = $result->where('user_id', $user_id);
        } 

        if(!empty($payment_filter) && $payment_filter!="all"){
            $result = $result->whereHas('invoice', function($q) use($payment_filter){
                    if($payment_filter==1){
                        $q->where('amount_remaining',0);
                    }
                    else{
                        $q->where('amount_remaining','>',0);
                    }
                }
            );
        } 

        if(!empty($airline) && $airline!='all'){
            $result = $result->whereHas('passenger', function($q) use($airline){
                $q->where([
                    ['airline' , $airline]
                ]);
            });
        }

        if(!empty($country_id) && $country_id!='all'){
            $result = $result->whereHas('passenger', function($q) use($country_id){
                $q->where([
                    ['country_id' , $country_id]
                ]);
            });
        }

        if(!empty($search)){
            if(ctype_digit($search)){
                $result = $result->whereHas('invoice', function($q) use($search){
                        $q->where('unique_id', 'like', '%' .$search. '%');
                    }
                );
            }
        }

        if(!empty($passport_no)){
            $result = $result->whereHas('passenger', function($q) use($passport_no){
                    $q->where('passport_no', 'like', '%' .$passport_no. '%');
                }
            );
        }
        if(!empty($flight_no)){
            $result = $result->whereHas('passenger', function($q) use($flight_no){
                    $q->where('flight_no', 'like', '%' .$flight_no. '%');
                }
            );
        }

        // if(!empty($test_result) && $test_result != 'Awaiting Results'){
        //     $result = $result->whereHas('patient_tests', function($q) use($test_result){
        //         $q->where('id','>',0)->whereHas('patient_test_results', function($q) use($test_result){
        //             $q->where('dropdown_value',$test_result);
        //         });
        //     });
        // }

        if(!empty($test_result) && $test_result != 'Awaiting Results'){
            $result = $result->whereHas('patient_test_results', function($q) use($test_result){
                    $q->where('dropdown_value', $test_result);
                }
            );
        }

        if(!empty($test_result) && $test_result == 'Awaiting Results'){
            $result = $result->where('status', 0);
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }
        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
            foreach($result_data as $item){
                $single_field['check'] = '<input type="checkbox" name="patient_ids[]" class="eachBox" value="'.$item->patient_id.'">';
                $single_field['id'] = '#'.$item->id;
                $single_field['name'] = (!empty($item->patient->name))?$item->patient->name:'unavailable';
                $single_field['reffered_by'] = (!empty($item->patient->user->name))?$item->patient->user->name:'---';
                $single_field['tests'] = '---';
                if(!empty($item->test->name)){
                    $tooltip = '';
                    $single_field['tests'] = '<a href="javascript::" data-toggle="tooltip" title="'.$tooltip.'">'.$item->test->name.'</a>';
                }
                $single_field['invoice_id'] = (!empty($item->invoice->unique_id))?'#'.$item->invoice->unique_id:'---';

                $amount_paid = 0;
                $amount_remaining = 0;
                if(!empty($item->invoice)){
                   $amount_paid = $amount_paid+$item->invoice->amount_paid;
                   $amount_remaining = $amount_remaining+$item->invoice->amount_remaining;
                }
                $single_field['amount_paid'] = "Rs ".$amount_paid;
                $single_field['amount_remaining'] = "Rs ".$amount_remaining;
                $single_field['added_by'] = (!empty($item->users->name))?$item->users->name:'-- --';
                $single_field['action'] = '<a href="'.url('admin/patient-update/'.$item->patient_id).'">Edit</a> | 
                    <a href="'.url('admin/patient-delete/'.$item->patient_id).'" class="delete_patient"><i class="fa fa-trash"></i></a> | 
                    <a href="javascript::" class="">View</a>';
                $result_array[] = $single_field;
            }
            $data['draw'] = $draw;
            $data['recordsTotal'] = $result_count;
            $data['recordsFiltered'] = $result_count_rows;
            $data['data'] = $result_array;
        } else {
            $data['draw'] = $draw;
            $data['recordsTotal'] = 0;
            $data['recordsFiltered'] = 0;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    public function get_patient_tests(Request $request)
    {
        $like = array();
        $result_array = [];
        $post = $request->all();

        $orderByColumnIndex = $post['order'][0]['column'];
        $orderByColumn = $post['columns'][$orderByColumnIndex]['data'];
        $orderType = $post['order'][0]['dir'];
        $offset = $post['start'];
        $limit = $post['length'];
        $draw = $post['draw'];
        $search = $post['search']['value'];

        $from_date = $post['from_date'];
        $to_date = $post['to_date'];
        $lab_id = $post['lab_id'];
        $test_id = $post['test_id'];
        $doctor_id = $post['doctor_id'];
        $user_id = $post['user_id'];
        $payment_filter = $post['payment_filter'];
        $lab_user = $post['lab_user'];
        $collection_point_id = $post['collection_point_id'];
        $local_overseas = $post['local_overseas'];
        $airline = $post['airline'];
        $country_id = $post['country_id'];
        $test_result = $post['test_result'];
        
        //$status = $post['status_filter'];

        $auth = Auth::user();

        $result_count = Patient_test::where('id' ,'>' , 0)->count();

        $result = new Patient_test;

        if(!empty($lab_id) && $lab_id!="all"){
            $users = User::where('lab_id' , $lab_id)->get();
            $staff = [0];
            if(!empty($users[0])){
                foreach($users as $key => $value){
                    array_push($staff, $value->id);
                }
            }
            $result = $result->whereIn('user_id' , $staff);
        }

        if(!empty($collection_point_id) && $collection_point_id!="all"){
            $users = User::where('collection_point_id' , $collection_point_id)->get();
            $staff = [0];
            if(!empty($users[0])){
                foreach($users as $key => $value){
                    array_push($staff, $value->id);
                }
            }
            $result = $result->whereIn('user_id' , $staff);
        }

        if(!empty($lab_user) && $lab_user!="all"){
            $result = $result->where('processed_by',$lab_user);
        }

        if(!empty($local_overseas) && $local_overseas!="all"){
            $result = $result->where('type',$local_overseas);
        }

        if(!empty($test_id) && $test_id!="all"){
            $result = $result->where('test_id',$test_id);
        } 

        if(!empty($doctor_id) && $doctor_id!="all"){
            $result = $result->whereHas('patient', function($q) use($doctor_id){
                    $q->where('reffered_by', $doctor_id);
                }
            );
        } 
        
        if(!empty($user_id) && $user_id!="all"){
            $result = $result->where('user_id', $user_id);
        } 

        if(!empty($payment_filter) && $payment_filter!="all"){
            $result = $result->whereHas('invoice', function($q) use($payment_filter){
                    if($payment_filter==1){
                        $q->where('amount_remaining',0);
                    }
                    else{
                        $q->where('amount_remaining','>',0);
                    }
                }
            );
        } 

        if(!empty($airline) && $airline!='all'){
            $result = $result->whereHas('passenger', function($q) use($airline){
                $q->where([
                    ['airline' , $airline]
                ]);
            });
        }

        if(!empty($country_id) && $country_id!='all'){
            $result = $result->whereHas('passenger', function($q) use($country_id){
                $q->where([
                    ['country_id' , $country_id]
                ]);
            });
        }

        if(!empty($search)){
            if(ctype_digit($search)){
                $result = $result->whereHas('invoice', function($q) use($search){
                        $q->where('unique_id', 'like', '%' .$search. '%');
                    }
                );
            }
            else{
                $result = $result->where('name', 'like', '%' .$search. '%');
            }
        }

        // if(!empty($test_result) && $test_result != 'Awaiting Results'){
        //     $result = $result->whereHas('patient_tests', function($q) use($test_result){
        //         $q->where('id','>',0)->whereHas('patient_test_results', function($q) use($test_result){
        //             $q->where('dropdown_value',$test_result);
        //         });
        //     });
        // }

        if(!empty($test_result) && $test_result != 'Awaiting Results'){
            $result = $result->whereHas('patient_test_results', function($q) use($test_result){
                    $q->where('dropdown_value', $test_result);
                }
            );
        }
        if(!empty($test_result) && $test_result == 'Awaiting Results'){
            $result = $result->where('status', 0);
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }
        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
            foreach($result_data as $item){

                $single_field['id'] = '#'.$item->id;
                $single_field['name'] = (!empty($item->patient->name))?$item->patient->name:'unavailable';
                $single_field['reffered_by'] = (!empty($item->patient->user->name))?$item->patient->user->name:'---';
                $single_field['tests'] = '---';
                if(!empty($item->test->name)){
                    $tooltip = '';
                    // foreach($item->patient_tests as $key2 => $test){
                    //     $i = $key2+1;
                    //     $tooltip .= $test->test->name;
                    //     ($i<$cc)?$tooltip .= ' , ':'';
                    // }
                    $single_field['tests'] = '<a href="javascript::" data-toggle="tooltip" title="'.$tooltip.'">'.$item->test->name.'</a>';
                }
                $single_field['invoice_id'] = (!empty($item->invoice->unique_id))?'#'.$item->invoice->unique_id:'---';

                $amount_paid = 0;
                $amount_remaining = 0;
                if(!empty($item->invoice)){
                   $amount_paid = $amount_paid+$item->invoice->amount_paid;
                   $amount_remaining = $amount_remaining+$item->invoice->amount_remaining;
                }
                $single_field['amount_paid'] = "Rs ".$amount_paid;
                $single_field['amount_remaining'] = "Rs ".$amount_remaining;
                $single_field['added_by'] = (!empty($item->users->name))?$item->users->name:'-- --';
                $single_field['action'] = '<a href="'.url('admin/patient-update/'.$item->patient_id).'">Edit</a> | 
                    <a href="'.url('admin/patient-delete/'.$item->patient_id).'" class="delete_patient"><i class="fa fa-trash"></i></a> | 
                    <a href="javascript::" class="">View</a>';
                $result_array[] = $single_field;
            }
            $data['draw'] = $draw;
            $data['recordsTotal'] = $result_count;
            $data['recordsFiltered'] = $result_count_rows;
            $data['data'] = $result_array;
        } else {
            $data['draw'] = $draw;
            $data['recordsTotal'] = 0;
            $data['recordsFiltered'] = 0;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    public function patientsDeleted()
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['deleted_patients_read']))){
            return redirect('admin/home');
        }
        $data = [];
        return view('admin.patients.deleted_patients',$data);
    }

    public function get_deleted_patients(Request $request)
    {
        $like = array();
        $result_array = [];
        $post = $request->all();

        $orderByColumnIndex = $post['order'][0]['column'];
        $orderByColumn = $post['columns'][$orderByColumnIndex]['data'];
        $orderType = $post['order'][0]['dir'];
        $offset = $post['start'];
        $limit = $post['length'];
        $draw = $post['draw'];
        $search = $post['search']['value'];

        //$from_date = $post['from_date'];
        //$to_date = $post['to_date'];

        $result_count = Deleted_patient::where('id' ,'>' , 0)->count();

        $result = new Deleted_patient;
        if(!empty($search)){
            $result = $result->where('name', 'like', '%' .$search. '%');
        }
        $result_count_rows = count($result->get());
        $result_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
            $permissions = permissions();
            foreach($result_data as $item){
                $single_field['name'] = (!empty($item->name))?$item->name:'unavailable';
                $single_field['created_at'] = $item->created_at;
                $logs = new Log;
                $logs = $logs->where('activity','deleted')->where('log_of','patient')->where('log_of_id',$item->id)->first();
                $single_field['reason'] =  (!empty($logs->reason))?$logs->reason:'-- --';

                $single_field['deleted_by'] = (!empty($item->user->name))?$item->user->name:'-- --';
                
                if($permissions['role']==7 && (empty($permissions['deleted_patients_delete']))){
                    $single_field['action'] = '-- --';
                }
                else{
                    $single_field['action'] = ' 
                    <a href="'.url('admin/patient-delete-permanently/'.$item->id).'" class="delete_patient_parmanently"><i class="fa fa-trash"></i></a>';
                }
                
                $result_array[] = $single_field;
            }
            $data['draw'] = $draw;
            $data['recordsTotal'] = $result_count;
            $data['recordsFiltered'] = $result_count_rows;
            $data['data'] = $result_array;
        } else {
            $data['draw'] = $draw;
            $data['recordsTotal'] = 0;
            $data['recordsFiltered'] = 0;
            $data['data'] = '';
        }
        echo json_encode($data);
    }


    public function export_patients(Request $request)
    {
        $data = [];
        $formData = $request->all();
        //dd($formData,true);
        $from_date = $formData['from_date'];
        $to_date = $formData['to_date'];
        $lab_id = $formData['lab_id'];
        $test_id = $formData['test_id'];
        $doctor_id = $formData['doctor_id'];
        $user_id = $formData['user_id'];
        $payment_filter = $formData['payment_filter'];
        $lab_user = $formData['lab_user'];
        $collection_point_id = $formData['collection_point_id'];
        $local_overseas = $formData['local_overseas'];
        $airline = $formData['airline'];

        $result = new Patient;

        if(!empty($lab_id) && $lab_id!="all"){
            $users = User::where('lab_id' , $lab_id)->get();
            $staff = [0];
            if(!empty($users[0])){
                foreach($users as $key => $value){
                    array_push($staff, $value->id);
                }
            }
            $result = $result->whereIn('user_id' , $staff);
        }

        if(!empty($collection_point_id) && $collection_point_id!="all"){
            $users = User::where('collection_point_id' , $collection_point_id)->get();
            $staff = [0];
            if(!empty($users[0])){
                foreach($users as $key => $value){
                    array_push($staff, $value->id);
                }
            }
            $result = $result->whereIn('user_id' , $staff);
        }

        if(!empty($lab_user) && $lab_user!="all"){
            $result = $result->whereHas('patient_tests', function($q) use($lab_user){
                $q->where([['processed_by',$lab_user]]);
            });
        }

        if(!empty($local_overseas) && $local_overseas!="all"){
            $result = $result->whereHas('patient_tests', function($q) use($local_overseas){
                $q->where([['type',$local_overseas]]);
            });
        }

        if(!empty($test_id) && $test_id!="all"){
            $result = $result->whereHas('patient_tests', function($q) use($test_id){
                $q->where([['test_id',$test_id]]);
            });
        } 

        if(!empty($doctor_id) && $doctor_id!="all"){
            $result = $result->where('reffered_by', $doctor_id);
        } 
        
        if(!empty($user_id) && $user_id!="all"){
            $result = $result->where('user_id', $user_id);
        } 

        if(!empty($payment_filter) && $payment_filter!="all"){
            $result = $result->whereHas('invoice', function($q) use($payment_filter){
                    if($payment_filter==1){
                        $q->where('amount_remaining',0);
                    }
                    else{
                        $q->where('amount_remaining','>',0);
                    }
                }
            );
        } 

        if(!empty($airline) && $airline!='all'){
            $result = $result->whereHas('passenger', function($q) use($airline){
                $q->where([
                    ['airline' , $airline]
                ]);
            });
        }
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }
        $data['patients'] = $result->orderBy('id' , 'DESC')->get();
        
        return view('admin.patients.export_patient',$data);
    }

    public function reporting_time($invoice_id = 0)
    {
        $data = [];
        $data['response'] = false;
        $invoice = new Invoice;
        $invoice = $invoice->find($invoice_id);
        if(!empty($invoice->id)){
            $created_at = explode(' ', $invoice->created_at);
            $data['created_at'] = $created_at[0].' '.$created_at[1];
            $updated_at = explode(' ', $invoice->updated_at);
            $data['updated_at'] = $updated_at[0].' '.$updated_at[1];
            $data['response'] = true;
        }
        echo json_encode($data);
    }


}
