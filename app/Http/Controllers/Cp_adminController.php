<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Session;
use App\Invoice;
use App\Amount;
use App\Account_category;
use App\Cash;
use App\User;
use Carbon\Carbon;

class Cp_adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Karachi");
        $this->middleware(function ($request, $next){
            if(Session::get('role')!=0){
                //return redirect('/redirected');
            }
            return $next($request);
        });
    }

    public function transactions()
    {
    	if(empty(Session::get('cp-admin'))){
    		return redirect('patients');
    	}
        $data = [];
    	return view('cp_admin.transactions',$data);
    }

    public function processCpAdmin(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $formData = $request->all();
        $password = $formData['password'];
        if($password == "cp-023"){
        	Session::put('cp-admin', true);
            $data['response'] = true;
        }
        echo json_encode($data);
    }

}
