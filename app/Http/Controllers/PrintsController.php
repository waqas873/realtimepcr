<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
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

}
