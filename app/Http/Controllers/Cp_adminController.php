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
        $data = [];
        $user = Auth::user();
        $user_id = $user->id;
    	return view('cp_admin.transactions',$data);
    }

}
