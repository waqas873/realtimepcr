<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use DB;
use App\Invoice;
use App\Amount;
use App\Cash;
use App\Patient;
use App\Patient_test;
use App\Patient_tests_repeated;
use App\Test_category;
use App\Patient_test_result;
use App\Patient_medicine_result;
use App\Test;
use App\User;
use App\Airline;

class LabUserController extends Controller
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
        return redirect('lab/open-cases');

        $data = [];
    	return view('lab.index',$data);
    }

    public function open_cases()
    {
        $data = [];
        $user = Auth::user();

        $data['testsList'] = Test::all();
        $data['airlines'] = Airline::all();
        $data['users'] = User::where('role',0)->orderBy('id' , 'DESC')->get();

        $result = new Patient_test;

        $in_process = $result;
        if(!empty($user->lab->type) && $user->lab->type==2){
            $in_process = $in_process->where('user_id' , $user->id);
        }
        $data['in_process'] = $in_process->where('status' , '0')->count();

        $performed = $result;
        if(!empty($user->lab->type) && $user->lab->type==2){
            $performed = $performed->where('user_id' , $user->id);
        }
        $data['performed'] = $performed->where(function($query){
            $query->where('status',1)->orWhere('status' ,'=', 2)->orWhere('status' ,'=', 3);
        })->count();

        $result = $result->where('status' , '0');
        if(!empty($user->lab->type) && $user->lab->type==2){
            $result = $result->where('user_id' , $user->id);
        }
        $data['tests'] = $result->orderBy('id' , 'DESC')->get();

        $result = new Patient_tests_repeated;
        $repeated_tests = $result->where('user_id' , $user->id)->sum('no_of_repeat');
        $data['repeated_tests'] = $repeated_tests;
        $total_tests = $repeated_tests+$data['performed'];
        $data['repeat_ratio'] = 0;
        if($repeated_tests>0 && $total_tests>0){
            $repeat_ratio = ($repeated_tests/$total_tests)*100;
            $data['repeat_ratio'] = round($repeat_ratio , 2);
        }
        $data['test_categories'] = Test_category::all();
    	return view('lab.open_cases',$data);
    }

    public function get_open_cases(Request $request)
    {
        $like = [];
        $result_array = [];
        $post = $request->all();

        $orderByColumnIndex = $post['order'][0]['column'];
        $orderByColumn = $post['columns'][$orderByColumnIndex]['data'];
        $orderType = $post['order'][0]['dir'];
        $offset = $post['start'];
        $limit = $post['length'];
        $draw = $post['draw'];
        $search = $post['search']['value'];

        $test_type = $post['test_type'];
        $airline = $post['airline'];
        $test_id = $post['test_id'];
        $start_date = $post['start_date'];
        $end_date = $post['end_date'];
        $user_id = $post['user_id'];

        $auth = Auth::user();

        $result_count = Patient_test::count();

        $result = new Patient_test;

        $result = $result->where('status' , '0');
        if(!empty($auth->lab->type) && $auth->lab->type==2){
            $result = $result->where('user_id' , $auth->id);
        }
        
        if(!empty($start_date) && !empty($end_date)){
            $result = $result->whereHas('invoice', function($q) use($post){
                $q->whereBetween('created_at', [$post['start_date'], $post['end_date']]);
            });
        }
        if(!empty($test_id)){
            $result = $result->where('test_id' , $test_id);
        }
        if(!empty($airline)){
            $result = $result->whereHas('passenger', function($q) use($airline){
                $q->where([
                    ['airline' , $airline]
                ]);
            });
        }

        // if(!empty($test_type)){
        //     $result = $result->whereHas('patient_test_results', function($q) use($test_type){
        //         $q->where([
        //             ['type' , $test_type]
        //         ]);
        //     });
        // }

        if(!empty($user_id) && $user_id!="all"){
            $result = $result->where('user_id', $user_id);
        }

        if(!empty($search)){
            $result = $result->whereHas('invoice', function($q) use($search){
                $q->where('unique_id','like', '%'.$search.'%');
            });
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();

        if(isset($result_data)){
            foreach($result_data as $item){
                if(!empty($test_type) && $item->test->reporting_units->type != $test_type){
                    continue;
                }
                $single_field['check'] = '<input type="checkbox" name="patient_test_ids[]" class="eachBox" value="'.$item->id.'">';
                $single_field['unique_id'] = (!empty($item->invoice->unique_id)) ? '#' . $item->invoice->unique_id : '---';
                $single_field['name'] = (!empty($item->patient->name)) ? $item->patient->name : '---';
                $single_field['test'] = (!empty($item->test->name))?$item->test->name:'-- --';
                $single_field['created_at'] = $item->created_at;
                $single_field['kits'] = '<a href="" class="" data-toggle="modal" data-target="#kitView"> <span class="btn btn-light" style=""> 0 </span> Select Kit</a>';
                $rut = !(empty($item->test->reporting_units->type))?$item->test->reporting_units->type:'';
                $id = createBase64($item->id);
                $action = '<a href="'.$item->id.'" rel="'.$rut.'" class="btn btn-success waves-effect waves-light submit_reports">Submit Report</a>';
                $action .= '<div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                      <a href="'.url('lab/repeat-test/'.$id).'" class="repeat_test_id">
                        <button class="dropdown-item" type="button">Repeat Test</button>
                      </a>
                      <a href="'.url('lab/manual/'.$id).'" class="">
                        <button class="dropdown-item" type="button">MS-Word Report</button>
                      </a>
                    </div>
                  </div>';
                  $single_field['action'] = $action;
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

    public function addTestResult(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $type = $formData['type'];

        $rules = [];
        $attributes = [];
        if($type==1 || $type==2 || $type==3 || $type==5){
            $rules['dropdown_value'] = 'required';
            $attributes['dropdown_value'] = 'dropdown value';
        }
        if($type==3){
            $rules['input_value'] = 'required';
            $attributes['input_value'] = 'input value';
        }
        if($type==6){
            $rules['specie'] = 'required';
            $rules['duration'] = 'required';
        }
        $messages = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);

        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            unset($formData['_token']);
            $patient_test_id = $formData['patient_test_id'];
            
            if(!empty($formData['patient_test_ids'][0])){
                $patient_test_ids = $formData['patient_test_ids'][0];
                unset($formData['patient_test_ids']);
            }
            if(isset($formData['patient_test_ids'])){
                unset($formData['patient_test_ids']);
            }

            $user = Auth::user();

            if(empty($patient_test_ids)){
                $result = Patient_test::where('status' , '0')->find($patient_test_id);
                if(!empty($result)){
                    $update = ['status'=>3,'updated_at'=>$this->date_time,'processed_by'=>$user->id];
                    if($result->type==2){
                        if(!empty($formData['dropdown_value']) && $formData['dropdown_value']=="Detected")
                        {
                            $update['status'] = 1;
                            if($result->api_cancelled == 0){
                                $this->api_result_request($result->patient_id, "positive");
                            }
                        }
                        if(!empty($formData['dropdown_value']) && $formData['dropdown_value']=="Not Detected"){
                            $update['status'] = 2;
                            if($result->api_cancelled == 0){
                                $this->api_result_request($result->patient_id, "negative");
                            }
                        }
                    }
                    Patient_test::where('id' , $patient_test_id)->update($update);
                    
                    $invoice_updated_at = (!empty($formData['invoice_updated_at']))?$formData['invoice_updated_at']:null;
                    unset($formData['invoice_updated_at']);
                    $invoice_id = $result->invoice_id;
                    $this->invoice_update($invoice_id,$invoice_updated_at);

                    $msg = 'Test has been updated successfully.';
                    $sms_sent = $this->send_sms($patient_test_id);
                    if($sms_sent==true){
                        $msg .= 'Message has been sent to patient.';
                    }
                    
                    Patient_test_result::where('patient_test_id',$patient_test_id)->delete(); 
                    $formData['user_id'] = $user->id;
                    if($type==6 || $type==4){
                        $test_categories = $formData['test_categories'];
                        $results = $formData['results'];
                        unset($formData['test_categories'],$formData['results']);
                    }
                    Patient_test_result::insert($formData);
                    $id = DB::getPdo()->lastInsertId();
                    if($type==6 || $type==4){
                        foreach($test_categories as $key => $value){
                            $save = [];
                            $save['patient_test_result_id'] = $id;
                            $save['test_category_id'] = $value;
                            $save['result'] = (!empty($results[$key]))?$results[$key]:null;
                            if(!empty($results[$key])){
                                Patient_medicine_result::insert($save);
                            }
                        }
                    }
                    $data['response'] = true;
                }
            }
            else{
                $patient_test_ids = explode(',', $patient_test_ids);
                foreach($patient_test_ids as $patient_test_id){
                    if($patient_test_id=='on'){
                        continue;
                    }
                    $result = Patient_test::where('status' , '0')->find($patient_test_id);
                    if(!empty($result)){
                        $update = ['status'=>3,'updated_at'=>$this->date_time,'processed_by'=>$user->id];
                        if($result->type==2){
                            if(!empty($formData['dropdown_value']) && $formData['dropdown_value']=="Detected")
                            {
                                $update['status'] = 1;
                                if($result->api_cancelled == 0){
                                    $this->api_result_request($result->patient_id, "positive");
                                }
                            }
                            if(!empty($formData['dropdown_value']) && $formData['dropdown_value']=="Not Detected"){
                                $update['status'] = 2;
                                if($result->api_cancelled == 0){
                                    $this->api_result_request($result->patient_id, "negative");
                                }
                            }
                        }
                        Patient_test::where('id' , $patient_test_id)->update($update);
                        
                        $invoice_updated_at = (!empty($formData['invoice_updated_at']))?$formData['invoice_updated_at']:null;
                        unset($formData['invoice_updated_at']);
                        $invoice_id = $result->invoice_id;
                        $this->invoice_update($invoice_id,$invoice_updated_at);
                        
                        Patient_test_result::where('patient_test_id',$patient_test_id)->delete(); 
                        $formData['user_id'] = $user->id;
                        Patient_test_result::insert($formData);
                        $data['response'] = true;
                    }
                }
            }
        }
        echo json_encode($data);
    }

    public function reports()
    {
        $data = [];
        // $user = Auth::user();

        // $result = new Patient_test;
        // if(!empty($user->lab->type) && $user->lab->type==2){
        //     $result = $result->where('user_id' , $user->id);
        // }
        // $data['tests'] = $result->where(function($query){
        //     $query->where('status',1)->orWhere('status' ,'=', 2);
        // })->orderBy('id' , 'DESC')->get();

    	return view('lab.reports',$data);
    }

    public function get_reports(Request $request)
    {
        $like = array();
        $data_array = [];
        $post = $request->all();

        $orderByColumnIndex = $post['order'][0]['column'];
        $orderByColumn = $post['columns'][$orderByColumnIndex]['data'];
        $orderType = $post['order'][0]['dir'];
        $offset = $post['start'];
        $limit = $post['length'];
        $draw = $post['draw'];
        $search = $post['search']['value'];
        //$airline = $post['airline'];

        $user = Auth::user();

        $result = new Patient_test;
        if(!empty($user->lab->type) && $user->lab->type==2){
            $result = $result->where('user_id' , $user->id);
        }
        $result_count = $result->count();

        $result = new Patient_test;
        if(!empty($user->lab->type) && $user->lab->type==2){
            $result = $result->where('user_id' , $user->id);
        }
        $result = $result->where(function($query){
            $query->where('status',1)->orWhere('status' ,'=', 2)->orWhere('status' ,'=', 3);
        });
        $result = $result->whereHas('invoice', function($q){
                $q->where('status','<' , 5);
        });
        if(!empty($search)){
            $result = $result->whereHas('invoice', function($q) use($search){
                $q->where('unique_id','like' , '%'.$search.'%');
            });
        }
        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();

        //dd($result_data);

        if(isset($result_data)){
            foreach($result_data as $item){
                $single_field['unique_id'] = '#'.$item->invoice->unique_id;
                $single_field['patient_name'] = $item->patient->name;
                $single_field['test_name'] = $item->test->name;
                $single_field['status'] = ($item->status==1)?'Detected':'Not Detected';
                $single_field['action'] = '<a href="'.url('track/'.$item->invoice->unique_id).'" class="btn btn-sm btn-success detected_or_not">View</a> | <a href="'.url('lab/revoke/'.$item->id).'" class="btn btn-sm btn-success revoke">Revoke</a>';
                $data_array[] = $single_field;
            }
            $data['draw'] = $draw;
            $data['recordsTotal'] = $result_count;
            $data['recordsFiltered'] = $result_count_rows;
            $data['data'] = $data_array;
        } else {
            $data['draw'] = $draw;
            $data['recordsTotal'] = 0;
            $data['recordsFiltered'] = 0;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    public function detected($test_id = 0)
    {
        $user = Auth::user();
        $result = Patient_test::where('status' , '0')->find($test_id);
        if(!empty($result)){
            $update = ['status'=>1,'updated_at'=>$this->date_time,'processed_by'=>$user->id];
        	Patient_test::where('id' , $test_id)->update($update);

            $invoice_id = $result->invoice_id;
            $this->invoice_update($invoice_id);
            
            if($result->type==2 && $result->api_cancelled == 0){
                $this->api_result_request($result->patient_id, "positive");
            }

            $msg = 'Test has been updated successfully.';
            $sms_sent = $this->send_sms($test_id);
            if($sms_sent==true){
                $msg .= 'Message has been sent to patient.';
            }
        	return redirect('lab/open-cases')->with('success_message' , $msg);
        }
        return redirect('lab/open-cases')->with('error_message' , 'Invalid request to update test.');
    }

    public function not_detected($test_id = 0)
    {
        $user = Auth::user();
        $result = Patient_test::where('status' , '0')->find($test_id);
        if(!empty($result)){
        	$update = ['status'=>2,'updated_at'=>$this->date_time,'processed_by'=>$user->id];
        	Patient_test::where('id' , $test_id)->update($update);

            $invoice_id = $result->invoice_id;
            $this->invoice_update($invoice_id);

            if($result->type==2 && $result->api_cancelled == 0){
                $this->api_result_request($result->patient_id, "negative");
            }

            $msg = 'Test has been updated successfully.';

            $sms_sent = $this->send_sms($test_id);
            if($sms_sent==true){
                $msg .= 'Message has been sent to patient.';
            }

        	return redirect('lab/open-cases')->with('success_message' , $msg);
        }
        return redirect('lab/open-cases')->with('error_message' , 'Invalid request to update test.');
    }

    public function revoke($id = 0)
    {
        $result = Patient_test::find($id);
        if(!empty($result)){
            $update = ['status'=>0];
            Patient_test::where('id' , $id)->update($update);
            
            $update = ['status' => 1];
            Invoice::where('id',$result->invoice_id)->update($update);

            return redirect('lab/reports')->with('success_message' , 'Test has been revoked successfully');
        }
        return redirect('lab/reports')->with('error_message' , 'Invalid request to update test.');
    }

    public function repeat_test($id = 0)
    {
        $user = Auth::user();
        $id = decodeBase64($id);
        $result = Patient_test::find($id);
        if(!empty($result)){
            $ptr = new Patient_tests_repeated;
            $update = ['status'=>0];
            $result = $ptr->where('patient_test_id' , $id)->first();
            if(!empty($result)){
                $result->user_id = $user->id;
                $result->no_of_repeat = $result->no_of_repeat+1;
                $result->save();
            }
            else{
                $ptr->user_id = $user->id;
                $ptr->no_of_repeat = 1;
                $ptr->patient_test_id = $id;
                $ptr->save();
            }
            return redirect('lab/open-cases')->with('success_message' , 'Test has been repeated successfully');
        }
        return redirect('lab/reports')->with('error_message' , 'Invalid request to repeat test.');
    }

    public function manual($id = 0)
    {
        $data = [];
        $user = Auth::user();
        $id = decodeBase64($id);
        $result = Patient_test::find($id);
        if(!empty($result)){
            $unique_id = $result->invoice->unique_id;
            $invoice = Invoice::where('unique_id',$unique_id)->first();
            if(!empty($invoice)){
                $data['result'] = $invoice;
            }
            $data['patient_test_id'] = $id;
            return view('lab.manual' , $data);
        }
        return redirect('lab/reports')->with('error_message' , 'Invalid request to repeat test.');
    }

    public function manualProcess(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        $rules = [];
        $rules['manual'] = 'required';
        $attributes = [];
        $attributes['manual'] = 'report';
        $messages = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            unset($formData['_token']);
            //dd($formData , true);
            $patient_test_id = $formData['patient_test_id'];
            $user = Auth::user();
            $result = Patient_test::where('status' , '0')->find($patient_test_id);
            if(!empty($result)){
                $update = ['status'=>3,'updated_at'=>$this->date_time,'processed_by'=>$user->id];
                Patient_test::where('id' , $patient_test_id)->update($update);

                $invoice_id = $result->invoice_id;
                $this->invoice_update($invoice_id);

                $msg = 'Test has been updated successfully.';
                $sms_sent = $this->send_sms($patient_test_id);
                if($sms_sent==true){
                    $msg .= 'Message has been sent to patient.';
                }
                
                Patient_test_result::where('patient_test_id',$patient_test_id)->delete(); 
                $formData['user_id'] = $user->id;
                Patient_test_result::insert($formData);
                $data['response'] = true;
            }
        }
        echo json_encode($data);
    }

    public function invoice_update($invoice_id = 0 , $invoice_updated_at = null)
    {
        $pt = Patient_test::where('invoice_id' , $invoice_id)->where('status' , 0)->get();
        if(empty($pt[0])){
            $invoice = Invoice::find($invoice_id);
            $status = 2;
            if($invoice->amount_remaining==0){
                $status = 3;
            }
            $update = ['status' => $status];
            if(!empty($invoice_updated_at)){
                $invoice_updated_at = str_replace("/","-",$invoice_updated_at);
                $update['updated_at'] = $invoice_updated_at.':00';
            }
            Invoice::where('id',$invoice_id)->update($update);
        }
        return false;
    }

    public function api_result_request($patient_id = 0 , $test_result)
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
            "pres" => $test_result, 
            "rept" => $this->date_time,
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
        //dd($response_decoded);
        if(!empty($response_decoded->code) && $response_decoded->code == 1){
            $patient_test = Patient_test::where('patient_id' , $patient_id)->where('type' , 2)->where('test_id' , 760)->orderBy('id' , 'DESC')->get();
            //dd($patient_test[0]->id);
            if(!empty($patient_test[0]->id)){
                $id = $patient_test[0]->id;
                $patient_test = Patient_test::where('id' , $id)->update(['api_sent'=>2]);
                return true;
            }
        }
        return false;
    }

    public function send_sms($test_id = 0)
    {
        $result = Patient_test::find($test_id);
        if(empty($result->patient->contact_no)){
            return false;
        }
        $contact_no = $result->patient->contact_no;
        $invoice_id = $result->invoice->unique_id;

        //$api = 'https://connect.jazzcmt.com/sendsms_url.html?Username=03081577883&Password=Jazz@123&From=RTPCRLabPsh&To='.$contact_no.'&Message=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D9%88%D8%B9%D9%84%DB%8C%DA%A9%D9%85%20%0A.%D8%A2%D9%BE%20%DA%A9%DB%92%20%D9%B9%DB%8C%D8%B3%D9%B9%20%DA%A9%DB%8C%20%D8%B1%D9%BE%D9%88%D8%B1%D9%B9%20%D8%AC%D8%A7%D8%B1%DB%8C%20%DA%A9%D8%B1%20%D8%AF%DB%8C%20%DA%AF%D8%A6%DB%8C%20%DB%81%DB%92%20%0A%0Ahttp%3A%2F%2Fpcr.realtimepcr.pk%2Ftrack%2Fcovid%2F'.$invoice_id;
        $api = 'https://connect.jazzcmt.com/sendsms_url.html?Username=03081577883&Password=Jazz@123&From=RTPCRLabPsh&To='.$contact_no.'&Message=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D9%88%D8%B9%D9%84%DB%8C%DA%A9%D9%85%20%0A.%D8%A2%D9%BE%20%DA%A9%DB%92%20%D9%B9%DB%8C%D8%B3%D9%B9%20%DA%A9%DB%8C%20%D8%B1%D9%BE%D9%88%D8%B1%D9%B9%20%D8%AC%D8%A7%D8%B1%DB%8C%20%DA%A9%D8%B1%20%D8%AF%DB%8C%20%DA%AF%D8%A6%DB%8C%20%DB%81%DB%92%20%0A%0Ahttp%3A%2F%2Fpcr.realtimepcr.pk%2Ftrack%2Fcovid%2F'.$invoice_id;
        $request = curl_init($api);
        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
        $res = (string)curl_exec($request);
        curl_close($request);
        return true;
    }

}
