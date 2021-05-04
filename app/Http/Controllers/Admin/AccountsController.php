<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use App\Liability;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Karachi");
        $this->date_time = date('Y:m:d H:i:s');
    }

    public function transfers()
    {
        $data = [];
        return view('admin.accounts.transfers',$data);
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

    public function cashUserWallets()
    {
        $data = [];
        return view('admin.accounts.cash_user_wallets',$data);
    }

    public function ledgers()
    {
        $data = [];
        return view('admin.accounts.ledgers',$data);
    }

    public function trial_balance()
    {
        $data = [];
        return view('admin.accounts.trial_balance',$data);
    }

    public function balance_sheet()
    {
        $data = [];
        return view('admin.accounts.balance_sheet',$data);
    }

    public function income_statment()
    {
        $data = [];
        return view('admin.accounts.income_statment',$data);
    }

}
