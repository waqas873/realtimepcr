<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Invoice;
use App\Amount;
use App\Cash;
use App\Airline;
use App\Patient_test;
use App\Patient;
use App\Collection_point;
use App\Lab;
use App\User;

class AirlineController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function reports()
    {
        $data = [];

        $auth = Auth::user();

        $data['patients'] = Patient::where('is_deleted' , '0')->whereHas('patient_tests', function($q) use($auth){
                $q->where('type' , 2)->where('status' ,'<=', 3);
            })->orderBy('id' , 'DESC')->get();

        $data['pending'] = Patient_test::where([
            ['type',2],['status','0']
        ])->count();
        $data['completed'] = Patient_test::where([
            ['type',2],['status',1]
        ])->orWhere('status' , 2)->count();
        $data['positive'] = Patient_test::where([
            ['type',2],['status',1]
        ])->count();
        $data['negative'] = Patient_test::where([
            ['type',2],['status',2]
        ])->count();

    	return view('airlines.reports',$data);
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
        
        $test_status = $post['test_status'];
        $from_date = $post['from_date'];
        $to_date = $post['to_date'];

        $auth = Auth::user();

        $patients_count = Patient::where('is_deleted' , '0')->whereHas('patient_tests', function($q) use($auth){
                $q->where('type' , 2)->where('status' ,'<=', 3);
            })->count();
        //dd($patients_count);
        $pt_arr = [];
        $pt_arr['status'] = ['status' ,'<=', 3];
        if((!empty($test_status) || $test_status=='0') && $test_status!='all'){
            $pt_arr['status'] = ['status' ,'=', $test_status];
        }

        $result = new Patient;

        $result = $result->where('is_deleted' , '0')->whereHas('patient_tests', function($q) use($pt_arr){
                $q->where([
                    ['type' , 2],$pt_arr['status']
                ]);
            });

        $auth_airline = $auth->airline->name;
        $result = $result->whereHas('passenger', function($q) use($auth_airline){
            $q->where([
                ['airline' , $auth_airline]
            ]);
        });

        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }
        $patients_count_rows = count($result->get());

        $patients_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();

        //dd($patients_data);

        if(isset($patients_data)){
            foreach($patients_data as $item){
                $single_field['unique_id'] = '#'.$item->patient_tests[0]->invoice->unique_id;

                $date = date_create($item['created_at']);
                $date = date_format($date,'Y-m-d H:i:s');

                $single_field['created_at'] = $date;
                $single_field['name'] = $item->name;
                $single_field['airline'] = (!empty($item->passenger->airline))?$item->passenger->airline:'';
                $single_field['cp_city'] = (!empty($item->users->collection_point->city))?$item->users->collection_point->city:'';
                $test_result = '<span style="color:#FF9800;">Awaiting Result</span>';
                if($item->patient_tests[0]->status==1){
                    $test_result = '<span style="color:#DC4D41;">Detected</span>';
                }
                if($item->patient_tests[0]->status==2){
                    $test_result = '<span style="color:#7AB744;">Not Detected</span>';
                }
                $single_field['result'] = $test_result;
                $view_report = url('/').'/track/'.$item->patient_tests[0]->invoice->unique_id;
                $single_field['view_report'] = '<a href="'.$view_report.'" target="_blank">View Report</a>';
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

}
