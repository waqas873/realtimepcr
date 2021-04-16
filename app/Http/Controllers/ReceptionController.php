<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Patient;
use App\User;
use App\Invoice;
use App\Amount;
use App\Cash;

use Carbon\Carbon;

use Session;

class ReceptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next){
            if(Session::get('role')!=0){
                return redirect('/redirected');
            }
            return $next($request);
        });
    }

    public function index()
    {
    	$data = [];
        $user = Auth::user();
        $data['patients'] = Patient::where('is_deleted' , '0')->where('user_id' , $user->id)->orderBy('id' , 'DESC')->get();
        $data['users'] = User::where('role' , '0')->where('id','!=', $user->id)->get();
        $data['reports_delivered'] = Invoice::where('status' , '4')->where('user_id','=', $user->id)->whereDate('created_at', Carbon::today())->count();
        $data['reports_pending'] = Invoice::where('status' ,'<=', '3')->where('user_id','=', $user->id)->whereDate('created_at', Carbon::today())->count();
        $data['total_expense'] = Amount::where('user_id' , $user->id)->where('type', '=' ,2)->sum('amount');
        $data['cash_in_hand'] = $this->cash_in_hand();
        $data['today_sale'] = Amount::where('user_id' , $user->id)->where('type', '=' ,'0')->whereDate('created_at', Carbon::today())->sum('amount');
    	return view('reception.index' , $data);
    }

    public function cash_in_hand()
    {
        $cash = 0;
        $user = Auth::user();
        $result = Cash::where('user_id' , $user->id)->get();
        if(!empty($result[0])){
           $cash = $result[0]->cash_in_hand;
        }
        return $cash;
    }

}
