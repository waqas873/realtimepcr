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

class AmountsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Karachi");
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
        $user_id = $user->id;
        $data['total_income'] = Amount::where('user_id' , $user->id)->where('type', '=' ,'0')->whereMonth('created_at', Carbon::now()->month)->sum('amount');
        $data['total_expense'] = Amount::where('user_id' , $user->id)->where('type', '=' ,2)->whereMonth('created_at', Carbon::now()->month)->sum('amount');
        $data['cash_in_hand'] = $this->cash_in_hand();
        $data['cash_recieved'] = Amount::where('user_id' , $user->id)->where('type', '=' ,1)->where('from_user', '>' ,0)->whereMonth('created_at', Carbon::now()->month)->sum('amount');
        $data['users'] = User::where(function($query){
                $query->where('role' , '0')->orWhere('role' , 1)->orWhere('role' , 4)->orWhere('role' , 7);
            })->where('id','!=', $user->id)->get();
        $data['listing'] = Amount::where(function($query) use($user_id){
                $query->where('user_id' , $user_id)->orWhere('from_user' , $user_id);
            })->whereMonth('created_at', Carbon::now()->month)->orderBy('id' , 'DESC')->get();
        $data['expense_categories'] = Account_category::where('type' , 1)->where('status', '=' ,1)->get();
        $data['login_user_id'] = $user->id;
    	return view('amounts.index',$data);
    }

    public function process_expense(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['insufficient'] = false;

        $formData = $request->all();
        $rules = [
            'account_category_id'=>'required',
            'amount'=>'required|min:1'
        ];
        //dd($formData);
        $messages = [];
        $attributes = [
            'account_category_id' => 'expense category'
        ];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $errors = $validator->errors();
            $data['errors'] = $errors;
        }
        else{
            $cash = $this->cash_in_hand();
            if($cash < $formData['amount']){
                $data['insufficient'] = true;
            }
            else{
                $user = Auth::user();
                $this->cash_deduct($formData['amount'],$user->id);

                $amount = new Amount;
                $amount->user_id = $user->id;
                $amount->account_category_id = $formData['account_category_id'];
                $amount->amount = $formData['amount'];
                $amount->description = $formData['description'];
                $amount->type = 2;
                if($amount->save()){
                    $data['response'] = true;
                }
            }
        }
        echo json_encode($data);
    }

    public function amount_transfer(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['insufficient'] = false;

        $formData = $request->all();
        $rules = [
            'user_id'=>'required',
            'amount_transfer'=>'required|min:1'
        ];
        //dd($formData);
        $messages = [];
        $attributes = [
            'user_id'=>'submit to user',
            'amount_transfer'=>'amount'
        ];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $errors = $validator->errors();
            $data['user_id'] = $errors->first('user_id');
            $data['amount_transfer'] = $errors->first('amount_transfer');
        }
        else{
            $cash = $this->cash_in_hand();
            if($cash < $formData['amount_transfer']){
                $data['insufficient'] = true;
            }
            else{
                $user = Auth::user();
                //$this->cash_deduct($formData['amount_transfer'],$user->id);
                //$this->cash_add($formData['amount_transfer'],$formData['user_id']);
                
                $amount = new Amount;
                $amount->user_id = $formData['user_id'];
                $amount->from_user = $user->id;
                $amount->amount = $formData['amount_transfer'];
                $amount->description = $formData['description'];
                $amount->type = 1;
                $amount->is_accepted = 1;
                if($amount->save()){
                    $data['response'] = true;
                }
            }
        }
        echo json_encode($data);
    }

    public function cancel_transfer($id = 0)
    {
        $user = Auth::user();
        $amount = new Amount;
        $result = $amount->where('is_accepted' , 1)->where('from_user' , $user->id)->find($id);
        if(empty($result)){
            return redirect('/amounts')->with('error_message' , 'Invalid request to cancel transfer.');
        }
        $amount->find($id)->delete();
        return redirect('/amounts')->with('success_message' , 'Transfer has been cancelled successfully.');
    }

    public function accept_transfer($id = 0)
    {
        $user = Auth::user();
        $amount = new Amount;
        $result = $amount->where('is_accepted' , 1)->where('user_id' , $user->id)->find($id);
        if(empty($result)){
            return redirect('/amounts')->with('error_message' , 'Invalid request to accept transfer.');
        }
        $accept_amount = $result->amount;
        $sender_cash = $this->cash_in_hand($result->from_user);
        if($sender_cash < $accept_amount){
            return redirect('/amounts')->with('error_message' , 'Sender has less amount in his account.');
        }
        $this->cash_deduct($accept_amount,$result->from_user);
        $this->cash_add($accept_amount,$user->id);
        $amount->where('id',$id)->update(['is_accepted'=>2]);
        return redirect('/amounts')->with('success_message' , 'Transfer has been accepted successfully.');
    }

    public function reject_transfer($id = 0)
    {
        $user = Auth::user();
        $amount = new Amount;
        $result = $amount->where('is_accepted' , 1)->where('user_id' , $user->id)->find($id);
        if(empty($result)){
            return redirect('/amounts')->with('error_message' , 'Invalid request to reject transfer.');
        }
        $amount->where('id',$id)->update(['is_accepted'=>3]);
        return redirect('/amounts')->with('success_message' , 'Transfer has been rejected successfully.');
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
