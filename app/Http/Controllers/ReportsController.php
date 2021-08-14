<?php

namespace App\Http\Controllers;
use Session;

use Illuminate\Http\Request;
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
use App\Test;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];
        $data['tests'] = Test::all();
        $data['airlines'] = Airline::all();
        $data['users'] = User::where('role',0)->orderBy('id' , 'DESC')->get();
    	return view('reports.index',$data);
    }

    public function get_reports(Request $request)
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
        
        $status = $post['status_filter'];

        $test_type = $post['test_type'];
        $airline = $post['airline'];
        $test_id = $post['test_id'];
        $start_date = $post['start_date'];
        $end_date = $post['end_date'];
        $user_id = $post['user_id'];

        $auth = Auth::user();

        $result_count = Invoice::count();

        $result = new Invoice;

        if($status!='all'){
            $result = $result->where('status' , $status);
        }
        // else{
        // 	$result = $result->where('status' , 0)->orWhere('status' , 1)->orWhere('status' , 3)->orWhere('status' , 5);
        // }
        if(!empty($start_date) && !empty($end_date)){
            $result = $result->whereHas('patient', function($q) use($post){
                $q->whereBetween('created_at', [$post['start_date'], $post['end_date']]);
            });
        }
        if(!empty($test_id)){
            $result = $result->whereHas('patient_tests', function($q) use($test_id){
                $q->where([
                    ['test_id' , $test_id]
                ]);
            });
        }
        if(!empty($airline)){
            $result = $result->whereHas('passenger', function($q) use($airline){
                $q->where([
                    ['airline' , $airline]
                ]);
            });
        }

        if(!empty($test_type)){
            $result = $result->whereHas('patient_tests', function($q) use($test_type){
                $q->where('id','>',0)->whereHas('patient_test_results', function($q) use($test_type){
                    $q->where('type',$test_type);
                });
            });
        }

        if(!empty($user_id) && $user_id!="all"){
            $result = $result->where('user_id', $user_id);
        }

        if(!empty($search)){
            $result = $result->where('unique_id','like', '%'.$search.'%');
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();

        if(isset($result_data)){
            foreach($result_data as $item){
                $single_field['check'] = '<input type="checkbox" name="invoice_ids[]" class="eachBox" value="'.$item->id.'">';
                $single_field['unique_id'] = '#'.$item->unique_id;
                $single_field['name'] = (!empty($item->patient->name))?$item->patient->name:'unavailable';
                $single_field['tests'] = '---';
                if(!empty($item->patient_tests[0]->test->name)){
                    $tooltip = '';
                    $cc = count($item->patient_tests);
                    foreach($item->patient_tests as $key2 => $test){
                        $i = $key2+1;
                        $tooltip .= $test->test->name;
                        ($i<$cc)?$tooltip .= ' , ':'';
                    }
                    $single_field['tests'] = '<a href="javascript::" data-toggle="tooltip" title="'.$tooltip.'">'.$item->patient_tests[0]->test->name.'</a>';
                }
                $single_field['amount_paid'] = "Rs ".$item->amount_paid;
                $single_field['amount_remaining'] = "Rs ".$item->amount_remaining;
                $status = '---';
                if($item->status==3){
                    $status = '<a href="'.url('invoice-detail/'.$item->unique_id.'/HpD23hObScvX').'" class="btn btn-sm btn-info" target="_blank">Print</a>';
                }
                 if($item->status==2){
                    $status = '<a href="javascript::" class="warning">Pending Payment</a> | <a href="javascript::" rel="'.$item->id.'" class="pay_now">Pay Now</a>';
                }
                if($item->status=='0'){
                    $status = '<a href="javascript::">Reports in Queue</a>';
                }
                if($item->status==1){
                    $status = '<a href="javascript::" class="warning">Awaiting Results</a>';
                }
                if($item->status==5){
                    $status = '<a href="javascript::" class="info">Delivered</a>';
                }
                $single_field['status'] = $status;
                
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

}
