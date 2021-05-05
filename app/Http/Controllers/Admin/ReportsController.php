<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Patient;
use App\User;
use App\Lab;
use App\Collection_point;
use App\Invoice;

class ReportsController extends Controller
{
    public $date_time;

    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Karachi");
        $this->date_time = date('Y:m:d H:i:s');
    }

    public function index($date = '')
    {
        $permissions = permissions();
        if($permissions['role']==7 && (empty($permissions['labs_and_cp_reports_read']))){
            return redirect('admin/home');
        }
        $data = [];
        
        $patient = new Patient;
        $invoice = new Invoice;

        $result = $patient;
        if(!empty($date)){
            $data['date'] = $date;
            $result = $patient->where('is_deleted' , '0')->where("created_at",'like','%'.$date.'%');
        }
        $data['patients_registered'] = $result->count();
        $data['sample_collected'] = $result->count();

        $result = $invoice->where('status' , 1);
        if(!empty($date)){
            $result = $result->where("created_at",'like','%'.$date.'%');
        }
        $data['awaiting_results'] = $result->count();

        $result = $invoice->where('status' , 5);
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
        return view('admin.reports.index',$data);
    }

    public function progressReports()
    {
        $data = [];
        return view('admin.reports.progress_reports',$data);
    }

}
