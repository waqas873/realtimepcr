<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Patient;
use App\Patient_test_result;
use Illuminate\Support\Facades\Auth;

class PrintsController extends Controller
{
    public function __construct()
    {

    }

    public function covid_passenger($unique_id = 0)
    {
        $data = [];
        $result = Invoice::where('unique_id',$unique_id)->get();
        if(!empty($result[0])){
            $data['result'] = $result[0];
            $data['logged_user'] = Auth::user();
            return view('prints.passenger',$data);
        }
        else{
        	return view('prints.not_found',$data);
        }
    }

    public function trackForm(Request $request)
    {
        $data = [];
        $post = $request->all();
        //dd($post);
        $result = new Invoice;
        $patient = new Patient;

        if(!empty($post['start_date']) && !empty($post['end_date'])){
            if(!empty($post['airline'])){
                $patient = $patient->whereHas('passenger', function($q) use($post){
                    $q->where([
                        ['airline' , $post['airline']]
                    ]);
                });
            }
            if(!empty($post['test_id'])){
                $patient = $patient->whereHas('patient_tests', function($q) use($post){
                    $q->where([
                        ['test_id' , $post['test_id']]
                    ]);
                });
            }
            $patient = $patient->whereBetween('created_at', [$post['start_date'], $post['end_date']]);

            $patients = $patient->orderBy('id' , 'ASC')->get();
            $ids = [];
            if(!empty($patients)){
                foreach ($patients as $key => $value) {
                    foreach ($value->patient_tests as $vp) {
                        array_push($ids, $vp->id);
                    }
                }
            }
            //dd($ids);
        }
        
        if(!empty($ids)){
            $result = Patient_test_result::whereIn('patient_test_id', $ids)->where('type',$post['test_type'])->orderBy('id' , 'ASC')->get();
            if(!empty($result)){
                $pt_ids = [];
                foreach ($result as $vp) {
                    array_push($pt_ids, $vp->patient_test_id);
                }
            }
        }

        if(!empty($pt_ids)){
            $result = new Invoice;
            $result = $result->whereHas('patient_tests', function($q) use($pt_ids){
                $q->whereIn('id', $pt_ids);
            });
            $results = $result->orderBy('id' , 'ASC')->get();
            if(!empty($result)){
                $data['results'] = $results;
                return view('prints.multi_passengers',$data);
            }
            else{
                return view('prints.not_found',$data);
            }
        }
        else{
            return view('prints.not_found',$data);
        }

    }

}
