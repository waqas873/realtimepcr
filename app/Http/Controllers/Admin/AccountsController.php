<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Karachi");
        $this->date_time = date('Y:m:d H:i:s');
    }

    public function cashbook()
    {
        $data = [];
        return view('admin.accounts.cashbook',$data);
    }

    public function vouchers()
    {
        $data = [];
        return view('admin.accounts.vouchers',$data);
    }

    public function ledgers()
    {
        $data = [];
        return view('admin.accounts.ledgers',$data);
    }

}
