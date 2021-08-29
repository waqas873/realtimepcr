<?php

namespace App\Http\Controllers;

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
use App\Doctors_amount;
use App\Amount;
use App\Airline;
use App\Profile_test;
use App\Invoice;
use App\Ledger;
use App\Country;
use App\Cash;
use App\Deleted_patient;
use App\Log;
use App\Doctor;
use App\Collection_point_test;
use App\Collection_point_category;
use App\Doctor_test;
use App\Doctor_category;
use App\Commission_test;
use App\System_invoice;

use Carbon\Carbon;

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

    public function index($from_date='',$to_date='')
    {
        $data = [];
        $user = Auth::user();
        $result = new Patient;
        $result = $result->where('is_deleted' , '0')->where('user_id' , $user->id);
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }
        else{
            if($user->role==5){
                $result = $result->whereDate('created_at', Carbon::now()->subDays(7));
            }
            else{
                $result = $result->whereDate('created_at', Carbon::today());
            }
        }
        $data['patients'] = $result->orderBy('id' , 'DESC')->get();
        return view('patients.index',$data);
    }

    public function add()
    {
        $data = [];
        $data['tests'] = Test::all();
        $data['doctors'] = User::where('role' , 2)->orWhere('role' , 3)->get();
        $data['airlines'] = Airline::all();
        $data['countries'] = Country::all();
        $data['test_profiles'] = Test_profile::all();
    	return view('patients.add',$data);
    }

    public function process_add(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['redirect_to'] = false;
        $data['invoice_id'] = '';

    	$formData = $request->all();

    	$rules = [
	        'name'=>'required|min:3',
	        'contact_no'=>'required|unique:patients|min:10|max:17'
	    ];
        if(!empty($formData['email'])){
            $rules['email'] = 'email';
        }
        if(!empty($formData['cnic'])){
            $rules['cnic'] = 'required|unique:patients|min:13|max:13';
        }
        
        $covid = false;
        if(!empty($formData['tests'])){
            foreach($formData['tests'] as $test_id){
                $test = Test::where('id',$test_id)->get();
                if(!empty($test)){
                    $test = $test[0];
                    if($test->type==2){
                        $covid = true;
                    }
                }
            }
        }
        if($covid==true){
            $rules['passport_no'] = 'required|unique:passengers|min:1';
            $rules['airline'] = 'required|min:1';
            $rules['country_id'] = 'required';
            //$rules['collection_point'] = 'required|min:1';
            $rules['flight_date'] = 'required|min:1';
            $rules['flight_time'] = 'required|min:1';
        }

        //dd($rules);

	    $messages = [];
	    $attributes = [];

        if($covid==true){
            $attributes['passport_no'] = 'passport no';
            //$attributes['collection_point'] = 'collection point';
            $attributes['country_id'] = 'country';
            $attributes['flight_date'] = 'flight date';
            $attributes['flight_time'] = 'flight time';
        }

    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	//$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $errors = $validator->errors();

            $data['name'] = $errors->first('name');
            $data['contact_no'] = $errors->first('contact_no');
            if(strpos($data['contact_no'], 'already') !== false){
                $ppp = Patient::where('contact_no' , $formData['contact_no'])->first();
                $data['redirect_to'] = true;
                $data['redirect_url'] = url('patient-detail/'.$ppp->id);
            }

            $data['email'] = (!empty($formData['email']))?$errors->first('email'):'';
            $data['cnic'] = (!empty($formData['cnic']))?$errors->first('cnic'):'';

            $data['passport_no'] = ($covid==true)?$errors->first('passport_no'):'';
            $data['airline'] = ($covid==true)?$errors->first('airline'):'';
            $data['country_id'] = ($covid==true)?$errors->first('country_id'):'';
            //$data['collection_point'] = ($covid==true)?$errors->first('collection_point'):'';
            $data['flight_date'] = ($covid==true)?$errors->first('flight_date'):'';
            $data['flight_time'] = ($covid==true)?$errors->first('flight_time'):'';
        }
        else{
            unset($formData['_token']);
            
            $user = Auth::user();

            $tests = '';
            $test_profiles = '';
            if(!empty($formData['tests'])){
                $tests = $formData['tests'];
                unset($formData['tests']);
            }
            if(!empty($formData['test_profiles'])){
                $test_profiles = $formData['test_profiles'];
                unset($formData['test_profiles']);
            }

            $patient = new Patient;
            $patient->user_id = $user->id;
            $patient->name = $formData['name'];
            $patient->cnic = $formData['cnic'];
            $patient->dob = $formData['dob'];
            $patient->sex = $formData['sex'];
            $patient->contact_no = $formData['contact_no'];
            $patient->email = $formData['email'];
            $patient->reffered_by = $formData['reffered_by'];

            $date_time = date('Y:m:d H:i:s');
            
            $patient->sample_date = $date_time;
            $patient->created_at = $date_time;
            $patient->updated_at = $date_time;

            if(!empty($_FILES['avatar']['tmp_name'])){
                $file = $_FILES['avatar'];

                $imgData = base64_encode(file_get_contents($file['tmp_name']));
                //$src = 'data: '.mime_content_type($img_file).';base64,'.$imgData;

                $url = $_SERVER["DOCUMENT_ROOT"];
                $uid = time().uniqid(rand());
                $output = $url.'/assets/webcam/avatar/'.$uid.'_avatar.jpg';

                $contents = file_get_contents($file['tmp_name']);
                file_put_contents($output, $contents);

                $patient->image = $uid.'_avatar.jpg';
            }
            

            if($patient->save()){

                $patient_id = $patient->id;

                $api_request = false;

                if(!empty($tests) || !empty($test_profiles)){

                    $total_amount = $formData['total_amount'];
                    $discount_amount = $formData['discount_amount'];
                    $amount_paid = $formData['paid_amount'];
                    $total_discount = 0;
                    $amount_remaining = 0;
                    if($total_amount>0){
                        ($amount_paid>$total_amount)?$amount_paid=$total_amount:'';
                        $amount_remaining = $total_amount - $amount_paid;
                    }
                    if($discount_amount>0 && $discount_amount<=$total_amount && $total_amount>0){
                        $total_discount = $discount_amount;
                    }
                    if($total_discount>0){
                        ($total_discount>$amount_remaining)?$total_discount=$amount_remaining:'';
                        $amount_remaining = $amount_remaining - $total_discount;
                    }

                    $inv_uniq_id = '000000';
                    $uniqueness = false;
                    while($uniqueness == false){
                        $inv_uniq_id = rand(1,1000000);
                        $invRes = Invoice::where('unique_id',$inv_uniq_id)->get();
                        if(empty($invRes[0])){
                            $uniqueness = true;
                        }
                    }

                    $invoice = new Invoice;
                    $invoice->unique_id = $inv_uniq_id;
                    $invoice->user_id = $user->id;
                    $invoice->patient_id = $patient_id;
                    $invoice->total_amount = $total_amount;
                    //$invoice->discount_percentage = $discount_percentage;
                    $invoice->total_discount = $total_discount;
                    $invoice->amount_paid = $amount_paid;
                    $invoice->amount_remaining = $amount_remaining;
                    $invoice->delivery_time = $formData['reporting_hrs'];
                    if($covid==true){
                        $invoice->status = 1;
                    }

                    if(!empty($formData['invoice_date_time'])){
                        $invoice->created_at = $formData['invoice_date_time'];
                    }
                    else{
                        $invoice->created_at = $date_time;
                    }
                    $invoice->updated_at = $date_time;

                    $invoice->save();
                    $invoice_id = $invoice->id;
                    $data['invoice_id'] = $invoice->unique_id;

                    if(!empty($formData['reffered_by'])){
                        $doctor_id = $formData['reffered_by'];
                        $dctrAmnt = 0;
                        if($total_amount > 0){
                            $dctrAmnt = $total_amount;
                            if($total_discount > 0){
                                $dctrAmnt = $dctrAmnt - $total_discount;
                            }
                            $doctor = Doctor::where(['user_id'=>$doctor_id])->first();
                            if(!empty($doctor) && $doctor->affiliate_share > 0){
                                $percent = $doctor->affiliate_share;
                                $dcamnt = ($percent/100)*$dctrAmnt;
                                $this->cash_add($dcamnt , $doctor_id);
                                $dctrA = new Doctors_amount;
                                $dctrA->user_id = $doctor_id;
                                $dctrA->amount = $dcamnt;
                                $dctrA->invoice_id = $invoice_id;
                                $dctrA->save();
                            }
                        }
                    }

                    if($covid==true){
                        $passenger = new Passenger;
                        $passenger->user_id = $user->id;
                        $passenger->patient_id = $patient_id;
                        $passenger->invoice_id = $invoice_id;
                        $passenger->passport_no = $formData['passport_no'];
                        $passenger->airline = $formData['airline'];
                        $passenger->country_id = $formData['country_id'];
                        //$passenger->collection_point = $formData['collection_point'];
                        $passenger->flight_no = $formData['flight_no'];
                        $passenger->flight_date = $formData['flight_date'];
                        $passenger->flight_time = $formData['flight_time'];
                        $passenger->booking_ref_no = $formData['booking_ref_no'];
                        $passenger->ticket_no = $formData['ticket_no'];
                        if(!empty($formData['airport'])){
                            $passenger->airport = $formData['airport'];
                        }
                        $passenger->created_at = $date_time;
                        $passenger->updated_at = $date_time;
                        $passenger->save();
                    }

                    $amn = new Amount;
                    $amn->user_id = $user->id;
                    $amn->amount = $amount_paid;
                    $amn->description = 'Recieved from patient';
                    $amn->patient_id = $patient_id;
                    $amn->type = '0';
                    $amn->save();

                    $this->cash_add($amount_paid);

                    if(!empty($tests)){
                        foreach($tests as $test_id){
                            $save = [];
                            $save['user_id'] = $user->id;
                            $save['patient_id'] = $patient_id;
                            $save['test_id'] = $test_id;
                            $save['invoice_id'] = $invoice_id;

                            $test = Test::where('id',$test_id)->get();
                            if(!empty($test)){
                                $test = $test[0];
                                if($test->type==2){
                                    $save['type'] = 2;
                                    if($test->id == 760){
                                        $save['api_sent'] = 3;
                                    }
                                }
                            }

                            $save['created_at'] = $date_time;
                            $save['updated_at'] = $date_time;
                            
                            Patient_test::insert($save);
                        }
                    }

                    //dd($user);

                    if(!empty($user->collection_point_id) && empty($amount_remaining)){
                        $this->addCpLedger($tests,$invoice_id,$amount_paid);
                    }
                    if($user->role==0 && !empty($amount_paid)){
                        $this->addLabLedger($invoice_id,$amount_paid);
                    }
                    if(!empty($doctor->id) && empty($amount_remaining)){
                        $this->addDoctorLedger($tests,$invoice_id,$doctor->id,$amount_paid);
                    }

                    if(!empty($formData['reffered_by'])){
                        $embassy = User::where('role',3)->find($formData['reffered_by']);
                        if(!empty($embassy)){
                            $this->addEmbassyLedger($tests,$invoice_id,$formData['reffered_by']);
                        }
                    }
                    if(!empty($formData['airline'])){
                        $air = Airline::where('name',$formData['airline'])->first();
                        $userrs = User::where('role',6)->where('status',1)->where('airline_id',$air->id)->get();
                        if(!empty($userrs)){
                            foreach($userrs as $userr) 
                            {
                                $this->addAirlineLedger($tests,$invoice_id,$userr->id);
                            }
                        }
                    }

                    if(!empty($test_profiles)){
                        foreach($test_profiles as $profile_id){
                            $save = [];
                            $save['user_id'] = $user->id;
                            $save['patient_id'] = $patient_id;
                            $save['test_profile_id'] = $profile_id;
                            $save['invoice_id'] = $invoice_id;
                            $save['created_at'] = $date_time;
                            $save['updated_at'] = $date_time;
                            Patient_test::insert($save);
                        }
                    }
                }

                $data['response'] = true;
            }
            // Patient::insert($formData);
            // $patient_id = DB::getPdo()->lastInsertId();
        }
        
        echo json_encode($data);
    }

    public function addLabLedger($invoice_id = 0, $amount_paid = 0)
    {
        $user = Auth::user();
        $ledger = new Ledger;
        $ledger->user_id = $user->id;
        $ledger->invoice_id = $invoice_id;
        $ledger->lab_id = $user->lab_id;
        $uniq_id = '000000';
        $uniqueness = false;
        while($uniqueness == false){
            $uniq_id = rand(1,1000000);
            $invRes = Ledger::where('unique_id',$uniq_id)->first();
            if(empty($invRes)){
                $uniqueness = true;
            }
        }
        $ledger->unique_id = $uniq_id;
        $ledger->description = 'Amount received from patient';
        $ledger->amount = $amount_paid;
        $ledger->is_debit = 0;
        $ledger->is_credit = 1;
        
        //$result = Ledger::where('collection_point_id',$cp_id)->latest()->first();
        if($amount_paid > 0){
            $ledger->save();
        }

        $save = new System_invoice;
        $save->user_id = $user->id;
        $save->lab_id = $user->lab_id;
        $save->date = date('Y-m-d');
        $save->amount = $amount_paid;
        $save->description = 'Amount received from patient';
        $inv_uniq_id = '000000';
        $uniqueness = false;
        while($uniqueness == false){
            $inv_uniq_id = rand(1,1000000);
            $invRes = System_invoice::where('unique_id',$inv_uniq_id)->first();
            if(empty($invRes)){
                $uniqueness = true;
            }
        }
        $save->unique_id = $inv_uniq_id;
        $save->created_at = $this->date_time;
        $save->updated_at = $this->date_time;
        $save->save();
        return true;
    }

    public function addAirlineLedger($test_ids = [] , $invoice_id = 0 , $user_id = 0)
    {
        $amount = 0;
        $user = Auth::user();
        $ledger = new Ledger;
        $ledger->user_id = $user->id;
        $ledger->invoice_id = $invoice_id;
        if(empty($test_ids)){
            return false;
        }
        $ledger->airline_user_id = $user_id;
        foreach($test_ids as $test_id){
            $commission_test = Commission_test::where('to_user_id', $user_id)->where('test_id', $test_id)->first();
            $test = Test::find($test_id); 
            if(!empty($commission_test)){
                $amount = $amount + $commission_test->commission_price;
            }
        }
        $uniq_id = '000000';
        $uniqueness = false;
        while($uniqueness == false){
            $uniq_id = rand(1,1000000);
            $invRes = Ledger::where('unique_id',$uniq_id)->first();
            if(empty($invRes)){
                $uniqueness = true;
            }
        }
        $ledger->unique_id = $uniq_id;
        $ledger->description = 'Airline user commission';
        $ledger->amount = $amount;
        $ledger->is_debit = 1;
        if($amount > 0){
            $ledger->save();
        }
        return true;
    }

    public function addEmbassyLedger($test_ids = [] , $invoice_id = 0 , $user_id = 0)
    {
        $amount = 0;
        $user = Auth::user();
        $ledger = new Ledger;
        $ledger->user_id = $user->id;
        $ledger->invoice_id = $invoice_id;
        if(empty($test_ids)){
            return false;
        }
        $ledger->embassy_user_id = $user_id;
        foreach($test_ids as $test_id){
            $commission_test = Commission_test::where('to_user_id', $user_id)->where('test_id', $test_id)->first();
            $test = Test::find($test_id); 
            if(!empty($commission_test)){
                $amount = $amount + $commission_test->commission_price;
            }
        }
        $uniq_id = '000000';
        $uniqueness = false;
        while($uniqueness == false){
            $uniq_id = rand(1,1000000);
            $invRes = Ledger::where('unique_id',$uniq_id)->first();
            if(empty($invRes)){
                $uniqueness = true;
            }
        }
        $ledger->unique_id = $uniq_id;
        $ledger->description = 'Embassy Commission';
        $ledger->amount = $amount;
        $ledger->is_debit = 1;
        if($amount > 0){
            $ledger->save();
        }
        return true;
    }

    public function addDoctorLedger($test_ids = [] , $invoice_id = 0 , $doctor_id = 0 , $amount_paid = 0)
    {
        $amount = 0;
        $user = Auth::user();
        $ledger = new Ledger;
        $ledger->user_id = $user->id;
        $ledger->invoice_id = $invoice_id;
        if(empty($test_ids)){
            return false;
        }
        $ledger->doctor_id = $doctor_id;
        foreach($test_ids as $test_id){
            $doctor_test = Doctor_test::where('doctor_id', $doctor_id)->where('test_id', $test_id)->first();
            $test = Test::find($test_id);
            $test_category_id = $test->category_id;   
            $cpct = Doctor_category::where('doctor_id',$doctor_id)->where('category_id',$test_category_id)->where('discount_percentage','>',0)->where('custom_prizes',1)->first(); 
            if(!empty($doctor_test) && !empty($cpct)){
                $amount = $amount + $doctor_test->discounted_price;
            }
            else{
                $cpc = Doctor_category::where('doctor_id',$doctor_id)->where('category_id',$test_category_id)->where('discount_percentage','>',0)->first();
                if(!empty($cpc)){
                    $discnt = ($cpc->discount_percentage/100)*$test->price;
                    $amount = $amount + $discnt;
                }
            }
        }
        $uniq_id = '000000';
        $uniqueness = false;
        while($uniqueness == false){
            $uniq_id = rand(1,1000000);
            $invRes = Ledger::where('unique_id',$uniq_id)->first();
            if(empty($invRes)){
                $uniqueness = true;
            }
        }
        $ledger->unique_id = $uniq_id;
        $ledger->description = 'Doctors Commssion';
        $ledger->amount = $amount;
        $ledger->is_debit = 1;
        
        //$result = Ledger::where('collection_point_id',$cp_id)->latest()->first();

        if($amount > 0 && $amount_paid >= $amount){
            $ledger->save();
        }
        return true;
    }

    public function addCpLedger($test_ids = [] , $invoice_id = 0, $amount_paid = 0)
    {
        $amount = 0;
        $user = Auth::user();
        $ledger = new Ledger;
        $ledger->user_id = $user->id;
        $ledger->invoice_id = $invoice_id;
        if(empty($user->collection_point_id) || empty($test_ids)){
            return false;
        }
        $cp_id = $user->collection_point_id;
        $ledger->collection_point_id = $cp_id;
        foreach($test_ids as $test_id){
            $test = Test::find($test_id);
            $amount = $amount + $test->price;
        }
        foreach($test_ids as $test_id){
            $cp_test = Collection_point_test::where('collection_point_id', $cp_id)->where('test_id', $test_id)->first();
            $test = Test::find($test_id);
            $test_category_id = $test->category_id;
            $cpct = Collection_point_category::where('collection_point_id',$cp_id)->where('category_id',$test_category_id)->where('discount_percentage','>',0)->where('custom_prizes',1)->first();
            if(!empty($cp_test) && !empty($cpct)){
                if($amount >= $test->price){
                    $amount = $amount - $test->price;
                    $amount = $amount + $cp_test->discounted_price;
                }
            }
            else{
                $cpc = Collection_point_category::where('collection_point_id',$cp_id)->where('category_id',$test_category_id)->where('discount_percentage','>',0)->first();
                if(!empty($cpc)){
                    $discnt = ($cpc->discount_percentage/100)*$test->price;
                    $discntd_price = $test->price-$discnt;
                    if($amount >= $test->price){
                        $amount = $amount - $test->price;
                        $amount = $amount + $discntd_price;
                    }
                }
            }
        }
        $uniq_id = '000000';
        $uniqueness = false;
        while($uniqueness == false){
            $uniq_id = rand(1,1000000);
            $invRes = Ledger::where('unique_id',$uniq_id)->first();
            if(empty($invRes)){
                $uniqueness = true;
            }
        }
        $ledger->unique_id = $uniq_id;
        $ledger->description = 'Amount received from patient';
        $ledger->amount = $amount;
        $ledger->is_debit = 1;
        
        //$result = Ledger::where('collection_point_id',$cp_id)->latest()->first();
        if($amount > 0 && $amount_paid >= $amount){
            $ledger->save();
        }
        return true;
    }

    public function api_request($patient_id = 0 , $dateTime = '')
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
            "sampt" => $dateTime,
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

    public function invoice(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['covid'] = false;
        //$data['passenger_detail'] = false;
        $data['total'] = '';

        $formData = $request->all();

        // if(!empty($formData['patient_id'])){
        //     $patient_id = $formData['patient_id'];
        //     $passenger = Passenger::where('patient_id',$patient_id)->first();
        //     if(empty($passenger->id)){
        //         $data['passenger_detail'] = true;
        //     }
        // }

        $total = 0;
        $arr = [];

        if(!empty($formData['tests'])){
            $tests = $formData['tests'];
            foreach($tests as $test_id){
                $id = $test_id;
                $test = Test::where('id',$id)->get();
                if(!empty($test)){
                    $test = $test[0];
                    $total = $total+$test->price;
                    array_push($arr, $test->reporting_hrs);
                    if($test->type==2){
                        $data['covid'] = true;
                    }
                }
            }
        }

        if(!empty($formData['test_profiles'])){
            $test_profiles = $formData['test_profiles'];
            foreach($test_profiles as $test_profile_id){
                $id = $test_profile_id;
                $profile = Test_profile::where('id',$id)->get();
                if(!empty($profile)){
                    $profile = $profile[0];
                    $total = $total+$profile->price;
                    $profile_tests = Profile_test::where('test_profile_id',$id)->get();
                    if(!empty($profile_tests)){
                        foreach($profile_tests as $pt){
                            $test = Test::where('id',$pt->test_id)->get();
                            if(!empty($test)){
                                $test = $test[0];
                                array_push($arr, $test->reporting_hrs);
                            }
                        }
                    }
                }
            }
        }

        if(!empty($formData['tests']) || !empty($formData['test_profiles'])){
            $data['total'] = $total;
            $hours = max($arr);
            $days = $hours/24;
            if(is_float($days)){
                $days = explode('.', $days);
                $days = $days[0]+1;
            }
            $data['reporting_time'] = $days;
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function get_tests($id = '')
    {
        $data = [];
        $data['response'] = false;
        $test_id = '';
        $user = new User;
        if(!empty($id)){
            $user = $user->where('role',3)->find($id);
            if(!empty($user->test_id)){
                $test_id = $user->test_id;
            }
        }
        $tests = new Test;
        if(!empty($test_id)){
            $tests = $tests->where('id',$test_id);
        }
        if(empty($test_id)){
            $user = new User;
            $doctor = $user->where('role',2)->find($id);
        }
        if(!empty($doctor)){
            $tests = $tests->where('type',1);
        }
        $tests = $tests->get();
        $all_tests = '';
        if(!empty($tests)){
            foreach($tests as $test){
                $all_tests .= '<option value="'.$test->id.'">"'.$test->name.'" &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px !important;"> (Rs: "'.$test->price.'")</span></option>';
            }
        }
        $data['all_tests'] = $all_tests;
        $data['response'] = true;
        echo json_encode($data);
    }

    public function detail($patient_id = '0' , $search_by = '')
    {
        $data  = [];
        $user = Auth::user();
        if(!empty($search_by) && $search_by=='HbN'){
            $patient = Patient::where('id',$patient_id)->orWhere('cnic',$patient_id)->orWhere('contact_no',$patient_id)->get();
        }
        else{
            $patient = Patient::where('is_deleted' , '0')->where('id',$patient_id)->get();
        }

        if(empty($patient[0])){
            return redirect('patient-add');
        }

        $data['patient'] = $patient[0];
        $data['amount_paid'] = Invoice::where('patient_id' , $patient_id)->sum('amount_paid');
        $data['amount_remaining'] = Invoice::where('patient_id' , $patient_id)->sum('amount_remaining');

        $data['open_cases'] = Invoice::where('status','<=','3')->where('patient_id',$patient_id)->orderBy('id' , 'DESC')->get();
        $data['delivered_reports'] = Invoice::where('status','4')->where('patient_id',$patient_id)->orderBy('id' , 'DESC')->get();
        $data['invoices'] = Invoice::where('patient_id',$patient_id)->orderBy('id' , 'DESC')->get();

        $data['tests'] = Test::all();
        $data['test_profiles'] = Test_profile::all();

        $data['airlines'] = Airline::all();
        $data['countries'] = Country::all();

        return view('patients.detail',$data);
    }

    public function check_passenger(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['passenger'] = false;

        $formData = $request->all();
        $covid = false;
        if(isset($formData['pdf']) && $formData['pdf']=='pdf'){
            $covid = true;
            $data['passenger'] = true;
            $rules['passport_no'] = 'required|unique:passengers|min:1';
            $rules['airline'] = 'required|min:1';
            $rules['country_id'] = 'required';
            $rules['flight_date'] = 'required|min:1';
            $rules['flight_time'] = 'required|min:1';
        }

        $messages = [];
        $attributes = [];

        if($covid == true){
            $attributes['passport_no'] = 'passport no';
            $attributes['country_id'] = 'country';
            $attributes['flight_date'] = 'flight date';
            $attributes['flight_time'] = 'flight time';

            $validator = Validator::make($formData,$rules,$messages,$attributes);
            if($validator->fails()){
                $errors = $validator->errors();
                $data['passport_no'] = ($covid==true)?$errors->first('passport_no'):'';
                $data['airline'] = ($covid==true)?$errors->first('airline'):'';
                $data['country_id'] = ($covid==true)?$errors->first('country_id'):'';
                $data['flight_date'] = ($covid==true)?$errors->first('flight_date'):'';
                $data['flight_time'] = ($covid==true)?$errors->first('flight_time'):'';
            }
            else{
                $data['response'] = true;
            }
        }
        else{
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function process_add_tests(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        unset($formData['_token']);
            
        //dd($formData);
        $date_time = date('Y:m:d H:i:s');

        $tests = '';
        $test_profiles = '';
        if(!empty($formData['tests'])){
            $tests = $formData['tests'];
            unset($formData['tests']);
        }
        if(!empty($formData['test_profiles'])){
            $test_profiles = $formData['test_profiles'];
            unset($formData['test_profiles']);
        }

        $patient_id = $formData['patient_id'];

        if(!empty($tests) || !empty($test_profiles)){

            $total_amount = $formData['total_amount'];
            $discount_amount = $formData['discount_amount'];
            $amount_paid = $formData['paid_amount'];
            $total_discount = 0;
            $amount_remaining = 0;
            if($total_amount>0){
                ($amount_paid>$total_amount)?$amount_paid=$total_amount:'';
                $amount_remaining = $total_amount - $amount_paid;
            }
            if($discount_amount>0 && $discount_amount<=$total_amount && $total_amount>0){
                $total_discount = $discount_amount;
            }
            if($total_discount>0){
                ($total_discount>$amount_remaining)?$total_discount=$amount_remaining:'';
                $amount_remaining = $amount_remaining - $total_discount;
            }

            $user = Auth::user();

            $inv_uniq_id = '000000';
            $uniqueness = false;
            while($uniqueness == false){
                $inv_uniq_id = rand(1,1000000);
                $invRes = Invoice::where('unique_id',$inv_uniq_id)->get();
                if(empty($invRes[0])){
                    $uniqueness = true;
                }
            }

            $invoice = new Invoice;
            $invoice->unique_id = $inv_uniq_id;
            $invoice->user_id = $user->id;
            $invoice->patient_id = $patient_id;
            $invoice->total_amount = $total_amount;
            //$invoice->discount_percentage = $discount_percentage;
            $invoice->total_discount = $total_discount;
            $invoice->amount_paid = $amount_paid;
            $invoice->amount_remaining = $amount_remaining;
            $invoice->delivery_time = $formData['reporting_hrs'];

            $invoice->created_at = $date_time;
            $invoice->updated_at = $date_time;
            $invoice->save();
            $invoice_id = $invoice->id;

            if(!empty($formData['passport_no'])){
                $passenger = new Passenger;
                $passenger->where('patient_id' , $patient_id)->delete();
                $passenger->user_id = $user->id;
                $passenger->patient_id = $patient_id;
                $passenger->invoice_id = $invoice_id;
                $passenger->passport_no = $formData['passport_no'];
                $passenger->airline = $formData['airline'];
                $passenger->country_id = $formData['country_id'];
                $passenger->flight_no = $formData['flight_no'];
                $passenger->flight_date = $formData['flight_date'];
                $passenger->flight_time = $formData['flight_time'];
                $passenger->booking_ref_no = $formData['booking_ref_no'];
                $passenger->ticket_no = $formData['ticket_no'];
                $passenger->created_at = $date_time;
                $passenger->updated_at = $date_time;
                $passenger->save();
            }

            $amn = new Amount;
            $amn->user_id = $user->id;
            $amn->amount = $amount_paid;
            $amn->description = 'Recieved from patient';
            $amn->patient_id = $patient_id;
            $amn->type = '0';
            $amn->save();

            $this->cash_add($amount_paid);

            if(!empty($tests)){
                foreach($tests as $test_id){
                    $save = [];
                    $save['user_id'] = $user->id;
                    $save['patient_id'] = $patient_id;
                    $save['test_id'] = $test_id;
                    $save['invoice_id'] = $invoice_id;
                    $save['created_at'] = $date_time;
                    $save['updated_at'] = $date_time;
                    Patient_test::insert($save);
                }
            }

            if(!empty($test_profiles)){
                foreach($test_profiles as $profile_id){
                    $save = [];
                    $save['user_id'] = $user->id;
                    $save['patient_id'] = $patient_id;
                    $save['test_profile_id'] = $profile_id;
                    $save['invoice_id'] = $invoice_id;
                    $save['created_at'] = $date_time;
                    $save['updated_at'] = $date_time;
                    Patient_test::insert($save);
                }
            }

        }

        $data['response'] = true;
        
        echo json_encode($data);
    }

    public function pay_now($invoice_id = '0')
    {
        $data = [];
        $data['response'] = false;

        $result = Invoice::where('id',$invoice_id)->get();
        if(!empty($result)){
            $data['result'] = $result[0];
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function cash_add($cash = '0' , $user_id = '')
    {
        $user = Auth::user();
        $id = $user->id;
        if(!empty($user_id)){
            $id = $user_id;
        }
        $result = Cash::where('user_id',$id)->get();
        if(!empty($result[0]->user_id)){
            $result = $result[0];
            $update = [];
            $update['cash_in_hand'] = $result->cash_in_hand+$cash;
            Cash::where('user_id' , $id)->update($update);
        }
        else{
            $save = [];
            $save['user_id'] = $id;
            $save['cash_in_hand'] = $cash;
            Cash::insert($save);
        }
        return true;
    }

    public function contact_no_exist($contact_no = '')
    {
        $data = [];
        $data['response'] = false;
        $result = Patient::where('is_deleted' , '0')->where('contact_no',$contact_no)->get();
        if(!empty($result[0]['contact_no'])){
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function process_pay_invoice(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        //dd($formData);

        $invoice_id = $formData['invoice_id'];
        $result = Invoice::where('id',$invoice_id)->get();
        if(!empty($result)){
            $result = $result[0];
            $amount_remaining = $result->amount_remaining;
            $update = [];
            if(!empty($formData['discount'])){
                $discount = $amount_remaining;
                $pay = 0;
                if($formData['amount_pay'] > 0){
                    $pay = $formData['amount_pay'];
                    if($pay > $amount_remaining){
                        $pay = $amount_remaining;
                    }
                    $discount = $amount_remaining - $pay;
                }
                $update['total_discount'] = $result->total_discount+$discount;
                $update['amount_paid'] = $result->amount_paid+$pay;
                $update['amount_remaining'] = 0;
                $update['status'] = 2;
            }
            else{
                $pay = 0;
                if($formData['amount_pay'] > 0){
                    $pay = $formData['amount_pay'];
                    if($pay > $amount_remaining){
                        $pay = $amount_remaining;
                    }
                    $remaining = $amount_remaining - $pay;
                    $update['amount_paid'] = $result->amount_paid+$pay;
                    $update['amount_remaining'] = $remaining;
                    if($remaining<1){
                        $update['status'] = 2;
                    }
                }
            }
            if(!empty($update)){
                Invoice::where('id',$invoice_id)->update($update);
                $data['response'] = true;
            }
        }
        echo json_encode($data);
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

    public function delete($patient_id = '0')
    {
        $data  = [];
        $patient = Patient::where('id',$patient_id)->first();
        if(empty($patient)){
            return redirect('patients')->with('error_message' , 'This patient does not exist.');
        }

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
        $id = $deleted->save();

        $this->api_delete_request($patient_id);
        
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

        return redirect('patients')->with('success_message' , 'Patient has been deleted successfully.');
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


}
