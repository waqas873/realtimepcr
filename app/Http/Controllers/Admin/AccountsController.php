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
use App\Lab;
use App\Doctor;
use App\Collection_point;
use App\Amount;
use App\System_invoice;
use App\Supplier;

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
            $is_recieved = 1;
            if($formData['action']=='transfer'){
                $transfer_to = $formData['id'];
                $transfer_from = $user->id;
                $is_recieved = 0;
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
                    $id = $amount->id;
                    $save = new System_invoice;
                    $save->user_id = $user->id;
                    $save->amount_id = $id;
                    $inv_uniq_id = '000000';
                    $uniqueness = false;
                    while($uniqueness == false){
                        $inv_uniq_id = rand(1,1000000);
                        $invRes = System_invoice::where('unique_id',$inv_uniq_id)->first();
                        if(empty($invRes)){
                            $uniqueness = true;
                        }
                    }
                    $save->unique_id = $inv_uniq_id;
                    $save->amount = $formData['amount'];
                    $save->is_recieved = $is_recieved;
                    $save->save();
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
        $data['suppliers'] = Supplier::all();
        $data['labs'] = Lab::all();
        if($action=='cp'){
            $data['cp_id'] = $id;
        }
        $data['doctors'] = Doctor::all();
        if($action=='doctor'){
            $data['doctor_id'] = $id;
        }
        $data['embassy_users'] = User::where('role',3)->get();
        $data['airline_users'] = User::where('role',6)->get();
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

    public function get_cash_payment(Request $request)
    {
        $like = array();
        $result_array = [];
        $post = $request->all();

        $orderByColumnIndex = $post['order'][0]['column'];
        $orderByColumn = $post['columns'][$orderByColumnIndex]['data'];
        $orderType = $post['order'][0]['dir'];
        $offset = $post['start'];
        $limit = $post['length'];
        $draw = $post['draw'];
        $search = $post['search']['value'];

        $auth = Auth::user();
        
        $result = new System_invoice;

        $result_count = count($result->get());

        if(!empty($search)){
            $result = $result->where('unique_id', 'like', '%' .$search. '%');
        }

        $result = $result->where('is_recieved',0)->where(function($query){
                $query->where('doctor_id','!=',null)->orWhere('embassy_user_id','!=',null)->orWhere('airline_user_id','!=',null)->orWhere('purchase_id','!=',null)->orWhere('amount_id','!=',null);
            }
        );

        //$result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'ASC')->skip($offset)->take($limit)->get();
        //dd($result_data);
        $result_count_rows = 0;
        if(isset($result_data)){
            foreach($result_data as $item){

                $description = (!empty($item->description))?$item->description:'---';
                $category = '---';
                if(!empty($item->amount_id)){
                    $rr = Amount::find($item->amount_id);
                    if($rr->is_accepted > 0 && $rr->is_accepted != 2){
                        continue;
                    }
                    if(!empty($rr->description)){
                        $description = $rr->description;
                    }
                    if(!empty($rr->account_category->name)){
                        $category = $rr->account_category->name;
                    }
                }

                $single_field['unique_id'] = '#'.$item->unique_id;
                $single_field['category'] = $category;
                $single_field['description'] = $description;
                $single_field['amount'] = 'Rs: '.$item->amount;
                $result_array[] = $single_field;
                $result_count_rows++;
            }
            $data['draw'] = $draw;
            $data['recordsTotal'] = $result_count;
            $data['recordsFiltered'] = $result_count_rows;
            $data['data'] = $result_array;
        } else {
            $data['draw'] = $draw;
            $data['recordsTotal'] = 0;
            $data['recordsFiltered'] = 0;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

}
