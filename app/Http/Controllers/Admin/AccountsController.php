<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use App\Liability;
use App\Cash;
use App\Doctor;
use App\Collection_point;
use App\Amount;

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
        $user_id = Auth::user()->id;
        $result = new Cash;
        $users = new User;
        $data['my_cash'] = $result->where('user_id',$user_id)->sum('cash_in_hand');
        $roles = [1,0,7];
        $data['records'] = $users->whereIn('role', $roles)->where('id','!=',$user_id)->get();
        $users_cash = 0;
        foreach($data['records'] as $key => $value){
            if(empty($value->cash->cash_in_hand)){
                continue;
            }
            $users_cash = $users_cash+$value->cash->cash_in_hand;
        }
        $data['users_cash'] = $users_cash;
        return view('admin.accounts.cash_user_wallets',$data);
    }

    public function cashUserTransfer(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['insufficient'] = false;

        $formData = $request->all();
        $rules = [
            'id'=>'required',
            'action'=>'required',
            'amount'=>'required|min:1'
        ];
        //dd($formData);
        $messages = [];
        $attributes = [];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        if($formData['amount'] < 1){
            $validator->after(function ($validator) {
                $validator->errors()->add('amount', '');
            });
        }
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            $user = Auth::user();
            $transfer_to = $user->id;
            $transfer_from = $formData['id'];
            if($formData['action']=='transfer'){
                $transfer_to = $formData['id'];
                $transfer_from = $user->id;
            }
            $cash = $this->cash_in_hand($transfer_from);
            if($cash < $formData['amount']){
                $data['insufficient'] = true;
            }
            else{
                $this->cash_deduct($formData['amount'],$transfer_from);
                $this->cash_add($formData['amount'],$transfer_to);

                $amount = new Amount;
                $amount->user_id = $transfer_to;
                $amount->from_user = $transfer_from;
                $amount->amount = $formData['amount'];
                $amount->type = 1;
                $amount->is_accepted = 2;
                if($amount->save()){
                    $data['response'] = true;
                }
            }
        }
        echo json_encode($data);
    }

    public function ledgers($action = '',$id = 0)
    {
        $data = [];
        $data['collection_points'] = Collection_point::all();
        if($action=='cp'){
            $data['cp_id'] = $id;
        }
        $data['doctors'] = Doctor::all();
        if($action=='doctor'){
            $data['doctor_id'] = $id;
        }
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

    public function cash_in_hand($user_id = '')
    {
        $cash = 0;
        $user = Auth::user();
        if(!empty($user_id)){
            $id = $user_id;
        }
        else{
            $id = $user->id;
        }
        $result = Cash::where('user_id' , $id)->get();
        if(!empty($result[0])){
           $cash = $result[0]->cash_in_hand;
        }
        return $cash;
    }

    public function cash_deduct($cash='0',$user_id = '0')
    {
        $result = Cash::where('user_id',$user_id)->get();
        if(!empty($result[0])){
            $result = $result[0];
            $update = [];
            $update['cash_in_hand'] = $result->cash_in_hand - $cash;
            Cash::where('user_id' , $user_id)->update($update);
        }
        return true;
    }

    public function cash_add($cash='0',$user_id = '0')
    {
        $result = Cash::where('user_id',$user_id)->get();
        if(!empty($result[0])){
            $result = $result[0];
            $update = [];
            $update['cash_in_hand'] = $result->cash_in_hand+$cash;
            Cash::where('user_id' , $user_id)->update($update);
        }
        else{
            $save = [];
            $save['user_id'] = $user_id;
            $save['cash_in_hand'] = $cash;
            Cash::insert($save);
        }
        return true;
    }

}
