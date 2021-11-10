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
use Carbon\Carbon;

class EmbassyController extends Controller
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
                $q->where('type' , 2)->where('api_sent',2)->where('api_cancelled' , 0)->where('test_id' , $auth->test_id)->where('status' ,'<=', 3)->whereDate('created_at', '>', Carbon::now()->subDays(30));
            })->orderBy('id' , 'DESC')->get();

        $data['completed'] = Patient_test::where('api_sent', 2)->whereBetween('status', [1, 2])->where([
            ['type',2],['api_cancelled',0],['test_id',$auth->test_id]
        ])->whereDate('created_at', '>', Carbon::now()->subDays(30))->count();
        $data['positive'] = Patient_test::where('api_sent',2)->where([
            ['type',2],['api_cancelled',0],['status',1],['test_id',$auth->test_id]
        ])->whereDate('created_at', '>', Carbon::now()->subDays(30))->count();
        $data['negative'] = Patient_test::where('api_sent',2)->where([
            ['type',2],['api_cancelled',0],['status',2],['test_id',$auth->test_id]
        ])->whereDate('created_at', '>', Carbon::now()->subDays(30))->count();

        $data['airlines'] = Airline::all();
        $data['collection_points'] = Collection_point::all();
    	return view('embassy.reports',$data);
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
        
        $airline = $post['airline'];
        $collection_point_id = $post['collection_point_id'];
        $test_status = $post['test_status'];
        $from_date = $post['from_date'];
        $to_date = $post['to_date'];

        $auth = Auth::user();

        $patients_count = Patient::where('is_deleted' , '0')->whereHas('patient_tests', function($q) use($auth){
                $q->where('type' , 2)->where('api_sent',2)->where('api_cancelled' , 0)->where('status' ,'<=', 3)->where('test_id' , $auth->test_id);
            })->count();
        //dd($patients_count);
        $pt_arr = [];
        $pt_arr['test_id'] = $auth->test_id;
        $pt_arr['status'] = ['status' ,'<=', 3];
        if((!empty($test_status) || $test_status=='0') && $test_status!='all'){
            $pt_arr['status'] = ['status' ,'=', $test_status];
        }

        $result = new Patient;

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

        if(empty($from_date) && empty($to_date)){
            $pt_arr['monthly'] = true;
        }

        $result = $result->where('is_deleted' , '0')->whereHas('patient_tests', function($q) use($pt_arr){
                if(!empty($pt_arr['monthly'])){
                    $q->where([
                         ['type' , 2],['api_cancelled' , 0],['test_id',$pt_arr['test_id']],$pt_arr['status']
                    ])->where('api_sent',2)->whereDate('created_at', '>', Carbon::now()->subDays(30));
                }
                else{
                    $q->where([
                        ['type' , 2],['api_cancelled' , 0],['test_id',$pt_arr['test_id']],$pt_arr['status']
                    ])->whereBetween('api_sent', [1, 2]);
                }
            });

        if($auth->role==6){
            $auth_airline = $auth->airline->name;
            $result = $result->whereHas('passenger', function($q) use($auth_airline){
                $q->where([
                    ['airline' , $auth_airline]
                ]);
            });
        }

        if($auth->role==3){
            $country_id = $auth->country_id;
            $result = $result->whereHas('passenger', function($q) use($country_id){
                $q->where([
                    ['country_id' , $country_id]
                ]);
            });
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

    public function all_reports($date = '')
    {
        $data = [];
        
        $patient = new Patient;
        $invoice = new Invoice;

        $result = $patient->whereHas('patient_tests', function($q){
                $q->where('test_id' , 760)->where('api_cancelled' , 0)->where('api_sent',2);
        });

        if(!empty($date)){
            $data['date'] = $date;
            $result = $result->where('is_deleted' , '0')->where("created_at",'like','%'.$date.'%');
        }
        $data['patients_registered'] = $result->count();
        $data['sample_collected'] = $result->count();

        $result = $invoice->where('status' , 1);
        $result = $result->whereHas('patient_tests', function($q){
                $q->where('test_id' , 760)->where('api_cancelled' , 0)->where('api_sent', 2);
        });
        if(!empty($date)){
            $result = $result->where("created_at",'like','%'.$date.'%');
        }
        $data['awaiting_results'] = $result->count();
        

        $result = $invoice->where('status' , 3)->orWhere('status' , 5);
        $result = $result->whereHas('patient_tests', function($q){
                $q->where('test_id' , 760)->where('api_cancelled' , 0)->where('api_sent', 2);
        });
        if(!empty($date)){
            $result = $result->where("created_at",'like','%'.$date.'%');
        }
        $data['reports_delivered'] = $result->count();
        
        $cp = new Collection_point;
        $lab = new Lab;

        $collection_point = $cp->orderBy('id' , 'DESC');
        // if(!empty($date)){
        //     $collection_point = $collection_point->whereHas('users', function($q) use($date){
        //         $q->whereHas('patients', function($q2) use($date){
        //             $q2->where("created_at",'like','%'.$date.'%');
        //         });
        //     });
        // }
        $data['collection_points'] = $collection_point->get();
        $data['labs'] = $lab->orderBy('id' , 'DESC')->get();
        return view('embassy.all_reports',$data);
    }

}
