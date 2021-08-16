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
        if(!empty($post['invoice_ids'])){
            $result = new Invoice;
            $results = $result->whereIn('id', $post['invoice_ids'])->orderBy('id' , 'ASC')->get();
            if(!empty($results)){
                $data['results'] = $results;
                foreach($results as $key => $value){
                    if($value->status==3){
                        $update = ['status'=>5];
                        Invoice::where('id' , $value->id)->update($update);
                    }
                }
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
