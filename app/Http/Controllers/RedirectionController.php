<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;

class RedirectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        if($user->role==0){
            return redirect('/reception');
        }
        elseif($user->role==1){
            return redirect('admin/home');
        }
        elseif($user->role==7){
            return redirect('admin/home');
        }
        elseif($user->role==2){
            return redirect('doctor/home');
        }
        elseif($user->role==3){
            return redirect('embassy/reports');
        }
        elseif($user->role==4){
            return redirect('lab/dashboard');
        }
        elseif($user->role==5){
        	return redirect('patients');
        }
        elseif($user->role==6){
            return redirect('airlines/reports');
        }
        else{
            
        }
    }

}
