<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Doctors_amount;
use App\Cash;
use App\Doctors_withdraw;
use App\Doctor;
use App\User;
use Carbon\Carbon;

use Session;

class DoctorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next){
            if(Session::get('role')!=2){
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
        $data['cash_in_hand'] = $this->cash_in_hand();
        $data['amounts_recieved'] = Doctors_amount::where('user_id' , $user_id)->orderBy('id' , 'DESC')->get();
        $data['withdraws'] = Doctors_withdraw::where('user_id' , $user_id)->orderBy('id' , 'DESC')->get();
        $data['amount_withdrawn'] = Doctors_withdraw::where(['user_id'=>$user_id],['status'=>1])->sum('amount');
        return view('doctor.index',$data);
    }

    public function withdrawRequest(Request $request)
    {
        $data = [];
        $data['response'] = false;
        $data['insufficient'] = false;
        $data['withdraw_exist'] = false;

        $formData = $request->all();
        $rules = [
            'withdraw_amount'=>'required|regex:/^[0-9]+$/|min:1|'
        ];
        //dd($formData);
        $messages = [];
        $attributes = [
            'withdraw_amount'=>'amount'
        ];
        $validator = Validator::make($formData,$rules,$messages,$attributes);
        if($validator->fails()){
            $data['errors'] = $validator->errors();
        }
        else{
            $cash = $this->cash_in_hand();
            if($cash < $formData['withdraw_amount']){
                $data['insufficient'] = true;
            }
            else{
                $user = Auth::user();
                
                $save = new Doctors_withdraw;
                $result = $save->where([['user_id',$user->id],['status',0]])->first();
                if(empty($result)){
                    $save->user_id = $user->id;
                    $save->amount = $formData['withdraw_amount'];
                    if($save->save()){
                        $data['response'] = true;
                    }
                }
                else{
                    $data['withdraw_exist'] = true;
                }
            }
        }
        echo json_encode($data);
    }

    public function withdrawCancel($id = 0)
    {
        $user = Auth::user();
        $object = new Doctors_withdraw;
        $result = $object->find($id);
        if(empty($result)){
            return redirect('doctor/home')->with('error_message' , 'Invalid request to cancel withdraw.');
        }
        $object->find($id)->delete();
        return redirect('doctor/home')->with('success_message' , 'Withdraw has been cancelled successfully.');
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

}
