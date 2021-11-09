<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Patient_test;
use App\Patient;

class ApiController extends Controller
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
        if($permissions['role']==7 && (empty($permissions['api_read']))){
            return redirect('admin/home');
        }
        $data = [];
        $data['sent'] = Patient_test::where('api_sent' , 1)->orderBy('id' , 'DESC')->get();
        $data['pending'] = Patient_test::where('api_sent' , 3)->orderBy('id' , 'DESC')->get();
        $data['results_sent'] = Patient_test::where('api_sent' , 2)->orderBy('id' , 'DESC')->get();
        $data['total'] = Patient_test::where('api_sent' , 1)->orWhere('api_sent' , 2)->orderBy('id' , 'DESC')->get();
        //dd(count($data['sent']));
        // $data['cancelled'] = Patient::where('is_deleted' , 1)->whereHas('patient_tests', function($q){
        //         $q->where('type' , 2)->where('status' ,'<=', 3);
        //     })->orderBy('id' , 'DESC')->get();
        return view('admin.api.index',$data);
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
        //$lab_id = $post['lab_id'];

        $auth = Auth::user();

        $result_count = Patient_test::where('api_sent',3)->orWhere('api_cancelled',1)->count();

        $result = new Patient_test;
        $result = $result->where('api_sent',3)->orWhere('api_cancelled',1);

        if(!empty($search)){
            if(ctype_digit($search)){
                $result = $result->whereHas('invoice', function($q) use($search){
                        $q->where('unique_id', 'like', '%' .$search. '%');
                    }
                );
            }
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }
        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        $permissions = permissions();

        if(isset($result_data)){
            foreach($result_data as $item){
                //$single_field['id'] = '#'.$item->id;
                $single_field['created_at'] = $item->patient->created_at;
                $single_field['id'] = $item->patient->id;
                $single_field['invoice_id'] = (!empty($item->invoice->unique_id))?'#'.$item->invoice->unique_id:'---';
                $single_field['name'] = ucwords($item->patient->name);
                $action = '----';
                if($permissions['role']==1 || (!empty($permissions['api_read_write']))){
                    $action = '<a href="'.url('admin/cancel-api-request/'.$item->id).'" class="btn btn-danger cancel_api_request">Dont Send</a>';
                    if($item->api_cancelled==1 && empty($item->patient_test_results)){
                        $action = '<a href="'.url('admin/send-api-request/'.$item->id).'" class="btn btn-success send_api_request">Send to Api</a>';
                    }
                }
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

    public function cancel_request($id = 0)
    {
        $data = [];
        $data['response'] = false;
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['api_read_write']))){
            exit;
        }
        $tests = new Patient_test;
        $result = $tests->where('type' , 2)->where('api_sent' , 3)->find($id);
        //dd($result);
        if(!empty($result)){
            $tests->where('id',$id)->update(['api_sent'=>0,'api_cancelled'=>1]);
            $data['response'] = true;
        }
        echo json_encode($data);
    }

    public function send_request($id = 0)
    {
        $data = [];
        $data['response'] = false;
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['api_read_write']))){
            exit;
        }
        $tests = new Patient_test;
        $result = $tests->where('type' , 2)->find($id);
        if(!empty($result)){
            $tests->where('id',$id)->update(['api_sent'=>3,'api_cancelled'=>0]);
            $data['response'] = true;
        }
        echo json_encode($data);
    }

}
