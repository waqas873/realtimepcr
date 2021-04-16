<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Invoice;
use App\Amount;
use App\Cash;

class CashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];
        $user = Auth::user();
        $data['total_income'] = Amount::where('user_id' , $user->id)->where('type', '=' ,'0')->sum('amount');
        $data['total_expense'] = Amount::where('user_id' , $user->id)->where('type', '=' ,2)->sum('amount');
        $data['listing'] = Amount::where('user_id' , $user->id)->orderBy('id' , 'DESC')->get();
    	return view('amounts.index',$data);
    }
    
}
