<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\User;
use App\Collection_point;
use App\Airline;
use App\Patient;

class Collection_pointController extends Controller
{
    public $date_time;

    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Karachi");
        $this->date_time = date('Y:m:d H:i:s');
    }

    public function index()
    {
        $data = [];
        $data['collection_points'] = Collection_point::where('status' , 1)->orderBy('id' , 'DESC')->get();
        return view('admin.collection_points.index',$data);
    }

    public function process_add(Request $request)
    {
        $data = [];
        $data['response'] = false;

    	$formData = $request->all();
        //dd($formData,true);
    	$rules = [
	        'name'=>'required|unique:collection_points|min:2',
	        'domain' => 'required|min:1',
	        'focal_person' => 'required|min:1',
	        'contact_no'=>'required|min:10|max:17',
	        'city' => 'required',
	        'address' => 'required|min:3'
	    ];
	    $messages = [];
	    $attributes = [];
        $attributes['focal_person'] = 'focal person';
        $attributes['contact_no'] = 'contact no';

    	$validator = Validator::make($formData,$rules,$messages,$attributes);
    	//$validator = Validator::make($inputs,$rules);
        if($validator->fails()){
            $errors = $validator->errors();
            $data['name'] = $errors->first('name');
            $data['contact_no'] = $errors->first('contact_no');
            $data['city'] = $errors->first('city');
            $data['domain'] = $errors->first('domain');
            $data['focal_person'] = $errors->first('focal_person');
            $data['address'] = $errors->first('address');
        }
        else{
            unset($formData['_token']);
            //dd($formData);
            $user = Auth::user();

            $save = new Collection_point;
            $save->user_id = $user->id;
            $save->name = $formData['name'];
            $save->city = $formData['city'];
            $save->domain = $formData['domain'];
            $save->focal_person = $formData['focal_person'];
            $save->contact_no = $formData['contact_no'];
            $save->address = $formData['address'];

            $save->created_at = $this->date_time;
            $save->updated_at = $this->date_time;
            if($save->save()){
                $data['response'] = true;
            }
        }
        echo json_encode($data);
    }

    public function delete($cp_id = '0')
    {
        $data  = [];
        $result = Collection_point::find($cp_id);
        if(empty($result)){
            return redirect('admin/collection-points')->with('error_message' , 'This collection point does not exist.');
        }
        $users = $result->users;
        foreach($users as $key => $value){
            $patients = Patient::where('user_id' , $value->id)->first();
            if(!empty($patients)){
                $update = ['status'=>'0'];
                User::where('id',$value->id)->update($update);
            }
            else{
                User::where('id',$value->id)->delete();
            }
        }
        $update = ['status'=>'0'];
        Collection_point::where('id',$cp_id)->update($update);
        return redirect('admin/collection-points')->with('success_message' , 'Collection point and its related inactive users have been deleted successfully.');
    }

}
