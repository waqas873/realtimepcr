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

        $auth = Auth::user();

        $result_count = Invoice::count();

        $result = new Invoice;

        if($status!='all'){
            $result = $result->where('status' , $status);
        }
        // else{
        // 	$result = $result->where('status' , 0)->orWhere('status' , 1)->orWhere('status' , 3)->orWhere('status' , 5);
        // }

        if(!empty($search)){
            $result = $result->where('unique_id','like', '%'.$search.'%');
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();

        if(isset($result_data)){
            foreach($result_data as $item){
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
