<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Log;
use Session;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['logs_read']))){
            return redirect('admin/home');
        }
        $data = [];
        return view('admin.logs.index',$data);
    }

    public function get_logs(Request $request)
    {
        $like = array();
        $logs_array = [];
        $post = $request->all();

        $orderByColumnIndex = $post['order'][0]['column'];
        $orderByColumn = $post['columns'][$orderByColumnIndex]['data'];
        $orderType = $post['order'][0]['dir'];
        $offset = $post['start'];
        $limit = $post['length'];
        $draw = $post['draw'];
        $search = $post['search']['value'];

        $logs_count = Log::count();
        //dd($logs_count);

        $log = new Log;

        $result = $log->where('log_of' , '=' , 'patient');

        $logs_count_rows = count($result->get());

        $logs_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();

        //dd($logs_data);

        if(isset($logs_data)){
            foreach($logs_data as $item){
                $single_field['user_name'] = $item->user->name;
                $single_field['activity'] = ucwords($item->activity);
                $single_field['reason'] = ucwords($item->reason);
                $single_field['patient_name'] = $item->patient->name;
                $date = date_create($item['created_at']);
                $date = date_format($date,'Y-m-d H:i:s');
                $single_field['created_at'] = $date;

                $logs_array[] = $single_field;
            }
            $data['draw'] = $draw;
            $data['recordsTotal'] = $logs_count;
            $data['recordsFiltered'] = $logs_count_rows;
            $data['data'] = $logs_array;
        } else {
            $data['draw'] = $draw;
            $data['recordsTotal'] = 0;
            $data['recordsFiltered'] = 0;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

}
