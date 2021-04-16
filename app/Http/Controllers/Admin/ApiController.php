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

    public function cancel_request($id = 0)
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['api_read_write']))){
            return redirect('admin/home');
        }
        $tests = new Patient_test;
        $result = $tests->where('type' , 2)->where('api_sent' , 3)->find($id);
        //dd($result);
        if(empty($result)){
            return redirect('/admin/api')->with('error_message' , 'Invalid request to cancel request.');
        }
        $tests->where('id',$id)->update(['api_sent'=>0,'api_cancelled'=>1]);
        return redirect('/admin/api')->with('success_message' , 'Api request has been cancelled successfully.');
    }

}
