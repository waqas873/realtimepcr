<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Patient;
use App\Passenger;
use App\Patient_test;
use App\Test;
use App\Test_profile;
use App\Amount;
use App\Invoice;

class ApiController extends Controller
{
    public function __construct()
    {

    }

    public function send_api_requests()
    {
        $data = [];
        $patient_tests = Patient_test::where('api_sent' , 3)->get();
        if(!empty($patient_tests[0])){
        	foreach($patient_tests as $key => $value){
                if($value->test->is_api==1){
                    $this->api_request($value->patient_id);
                }
        	}
        }
        echo "success";
        exit;
    }

    public function api_request($patient_id = 0)
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

    // public function resend_api_requests()
    // {
    //     $ids = ['1116317' , '1116310'];
    //     $test_result = "positive";
    //     foreach($ids as $patient_id){

    //         $curl = curl_init();
    //         $user_name = "rtladmin";
    //         $API_Secret_Key = "a19a0323fd1f94992bdb8b3822da41746qmqv0PzLnTKEY";
    //         $parameters = array(
    //             "pascode" => "pat-".$patient_id, 
    //             "labcode" => "RTL-192-8582"
    //         );
    //         $url = "https://app.arham.services/api/v1/canceltest?";
    //         foreach($parameters as $key=>$value){
    //             $url .= urlencode($key)."=".urlencode($value)."&";
    //         }
    //         $url = substr($url, 0, -1);
    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => $url,
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => "",
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 0,
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => "GET",
    //             CURLOPT_HTTPHEADER => array(
    //             "Authorization: Basic ".base64_encode($user_name.":".$API_Secret_Key)
    //             ),
    //         ));
    //         $response = curl_exec($curl);
    //         curl_close($curl);
    //         $response_decoded = json_decode($response);
    //         if(!empty($response_decoded->code) && $response_decoded->code == 1){
    //         }


    //         $patient = Patient::find($patient_id);
    //         if(empty($patient->id)){
    //             continue;
    //         }
    //         $curl = curl_init();
    //         $user_name = "rtladmin";
    //         $API_Secret_Key = "a19a0323fd1f94992bdb8b3822da41746qmqv0PzLnTKEY";
    //         $parameters = array(
    //             "pcode" => "pat-".$patient->id, 
    //             "pname" => $patient->name,
    //             "ppass" => $patient->passenger->passport_no,
    //             "pcnic" => $patient->cnic, 
    //             "sampt" => $patient->created_at,
    //             "pres" => $test_result, 
    //             "rept" => $patient->patient_tests[0]->updated_at,
    //             "tname" => "COVID"
    //         );
    //         $url = "https://app.arham.services/api/v1/pushdata?";
    //         foreach($parameters as $key=>$value){
    //             $url .= urlencode($key)."=".urlencode($value)."&";
    //         }
    //         $url = substr($url, 0, -1);
    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => $url,
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => "",
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 0,
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => "GET",
    //             CURLOPT_HTTPHEADER => array(
    //             "Authorization: Basic ".base64_encode($user_name.":".$API_Secret_Key)
    //             ),
    //         ));
    //         $response = curl_exec($curl);
    //         curl_close($curl);
    //         $response_decoded = json_decode($response);
    //         //dd($response_decoded);
    //         if(!empty($response_decoded->code) && $response_decoded->code == 1){
    //             echo "success<br/>";
    //         }
    //     } 
    // }

}
