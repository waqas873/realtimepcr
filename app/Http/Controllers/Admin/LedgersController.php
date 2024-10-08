<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Patient;
use App\Test;
use App\User;
use App\Amount;
use App\Invoice;
use App\Purchase;
use App\Ledger;
use App\Collection_point;
use Session;

class LedgersController extends Controller
{
    public $date_time;

    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Karachi");
        $this->date_time = date('Y:m:d H:i:s');
    }

    public function cpLedger(Request $request)
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

        $from_date = $post['from_date'];
        $to_date = $post['to_date'];
        $collection_point_id = $post['collection_point_id'];

        $auth = Auth::user();

        $result_count = Ledger::where('collection_point_id',$collection_point_id)->count();

        $result = new Ledger;
        $result = $result->where('collection_point_id' , $collection_point_id);

        if(!empty($search)){
            if(ctype_digit($search)){
                $result = $result->whereHas('invoice', function($q) use($search){
                        $q->where('unique_id', 'like', '%' .$search. '%');
                    }
                );
            }
            else{
                $result = $result->where('name', 'like', '%' .$search. '%');
            }
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'ASC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
        	$total_balance = 0;
            foreach($result_data as $item){
                $single_field['unique_id'] = '#'.$item->unique_id;
                $date = explode(' ', $item->created_at);
                $single_field['created_at'] = $date[0];
                $single_field['description'] = (!empty($item->description))?$item->description:'---';
                $single_field['debit'] = (!empty($item->is_debit))?'Rs: '.$item->amount:'0';
                $single_field['credit'] = (!empty($item->is_credit))?'Rs: '.$item->amount:'0';
                if(!empty($item->is_debit)){
                	$total_balance = $total_balance+$item->amount;
                }
                if(!empty($item->is_credit)){
                	$total_balance = $total_balance-$item->amount;
                }
                $single_field['balance'] = 'Rs: '.$total_balance;
                $result_array[] = $single_field;
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

    public function labLedger(Request $request)
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

        $from_date = $post['from_date'];
        $to_date = $post['to_date'];
        $lab_id = $post['lab_id'];

        $auth = Auth::user();

        $result_count = Ledger::where('lab_id',$lab_id)->count();

        $result = new Ledger;
        $result = $result->where('lab_id' , $lab_id);

        if(!empty($search)){
            if(ctype_digit($search)){
                $result = $result->whereHas('invoice', function($q) use($search){
                        $q->where('unique_id', 'like', '%' .$search. '%');
                    }
                );
            }
            else{
                $result = $result->where('name', 'like', '%' .$search. '%');
            }
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'ASC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
            $total_balance = 0;
            foreach($result_data as $item){
                $single_field['unique_id'] = '#'.$item->unique_id;
                $date = explode(' ', $item->created_at);
                $single_field['created_at'] = $date[0];
                $single_field['description'] = (!empty($item->description))?$item->description:'---';
                $single_field['debit'] = (!empty($item->is_debit))?'Rs: '.$item->amount:'0';
                $single_field['credit'] = (!empty($item->is_credit))?'Rs: '.$item->amount:'0';
                if(!empty($item->is_credit)){
                    $total_balance = $total_balance+$item->amount;
                }
                if(!empty($item->is_debit)){
                    $total_balance = $total_balance-$item->amount;
                }
                $single_field['balance'] = 'Rs: '.$total_balance;
                $result_array[] = $single_field;
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

    public function supplierLedger(Request $request)
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

        $from_date = $post['from_date'];
        $to_date = $post['to_date'];
        $supplier_id = $post['supplier_id'];

        $auth = Auth::user();

        $result_count = 0;

        $result = new Ledger;
        //$result = $result->where('lab_id' , $lab_id);

        if(!empty($supplier_id) && $supplier_id!="all"){
            $pr = Purchase::where('supplier_id' , $supplier_id)->get();
            $staff = [0];
            if(!empty($pr[0])){
                foreach($pr as $key => $value){
                    array_push($staff, $value->id);
                }
            }
            $result = $result->whereIn('purchase_id' , $staff);
        }

        if(!empty($search)){
            if(ctype_digit($search)){
                $result = $result->whereHas('invoice', function($q) use($search){
                        $q->where('unique_id', 'like', '%' .$search. '%');
                    }
                );
            }
            else{
                $result = $result->where('name', 'like', '%' .$search. '%');
            }
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }

        $result_count = count($result->get());

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'ASC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
            $total_balance = 0;
            foreach($result_data as $item){
                $single_field['unique_id'] = '#'.$item->unique_id;
                $date = explode(' ', $item->created_at);
                $single_field['created_at'] = $date[0];
                $single_field['description'] = (!empty($item->description))?$item->description:'---';
                $single_field['debit'] = (!empty($item->is_debit))?'Rs: '.$item->amount:'0';
                $single_field['credit'] = (!empty($item->is_credit))?'Rs: '.$item->amount:'0';
                if(!empty($item->is_debit)){
                    $total_balance = $total_balance+$item->amount;
                }
                if(!empty($item->is_credit)){
                    $total_balance = $total_balance-$item->amount;
                }
                $single_field['balance'] = 'Rs: '.$total_balance;
                $result_array[] = $single_field;
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

    public function doctorLedger(Request $request)
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

        $from_date = $post['from_date'];
        $to_date = $post['to_date'];
        $doctor_id = $post['doctor_id'];

        $auth = Auth::user();

        $result_count = Ledger::where('doctor_id',$doctor_id)->count();

        $result = new Ledger;
        $result = $result->where('doctor_id' , $doctor_id);

        if(!empty($search)){
            if(ctype_digit($search)){
                $result = $result->whereHas('invoice', function($q) use($search){
                        $q->where('unique_id', 'like', '%' .$search. '%');
                    }
                );
            }
            else{
                $result = $result->where('name', 'like', '%' .$search. '%');
            }
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'ASC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
            $total_balance = 0;
            foreach($result_data as $item){
                $single_field['unique_id'] = '#'.$item->unique_id;
                $date = explode(' ', $item->created_at);
                $single_field['created_at'] = $date[0];
                $single_field['description'] = (!empty($item->description))?$item->description:'---';
                $single_field['debit'] = (!empty($item->is_debit))?'Rs: '.$item->amount:'0';
                $single_field['credit'] = (!empty($item->is_credit))?'Rs: '.$item->amount:'0';
                if(!empty($item->is_debit)){
                    $total_balance = $total_balance+$item->amount;
                }
                if(!empty($item->is_credit)){
                    $total_balance = $total_balance-$item->amount;
                }
                $single_field['balance'] = 'Rs: '.$total_balance;
                $result_array[] = $single_field;
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

    public function airlineUserLedger(Request $request)
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

        $from_date = $post['from_date'];
        $to_date = $post['to_date'];
        $airline_user_id = $post['airline_user_id'];

        $auth = Auth::user();

        $result_count = Ledger::where('airline_user_id',$airline_user_id)->count();

        $result = new Ledger;
        $result = $result->where('airline_user_id' , $airline_user_id);

        if(!empty($search)){
            if(ctype_digit($search)){
                $result = $result->whereHas('invoice', function($q) use($search){
                        $q->where('unique_id', 'like', '%' .$search. '%');
                    }
                );
            }
            else{
                $result = $result->where('name', 'like', '%' .$search. '%');
            }
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'ASC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
            $total_balance = 0;
            foreach($result_data as $item){
                $single_field['unique_id'] = '#'.$item->unique_id;
                $date = explode(' ', $item->created_at);
                $single_field['created_at'] = $date[0];
                $single_field['description'] = (!empty($item->description))?$item->description:'---';
                $single_field['debit'] = (!empty($item->is_debit))?'Rs: '.$item->amount:'0';
                $single_field['credit'] = (!empty($item->is_credit))?'Rs: '.$item->amount:'0';
                if(!empty($item->is_debit)){
                    $total_balance = $total_balance+$item->amount;
                }
                if(!empty($item->is_credit)){
                    $total_balance = $total_balance-$item->amount;
                }
                $single_field['balance'] = 'Rs: '.$total_balance;
                $result_array[] = $single_field;
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

    public function EmbassyUserLedger(Request $request)
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

        $from_date = $post['from_date'];
        $to_date = $post['to_date'];
        $embassy_user_id = $post['embassy_user_id'];

        $auth = Auth::user();

        $result_count = Ledger::where('embassy_user_id',$embassy_user_id)->count();

        $result = new Ledger;
        $result = $result->where('embassy_user_id' , $embassy_user_id);

        if(!empty($search)){
            if(ctype_digit($search)){
                $result = $result->whereHas('invoice', function($q) use($search){
                        $q->where('unique_id', 'like', '%' .$search. '%');
                    }
                );
            }
            else{
                $result = $result->where('name', 'like', '%' .$search. '%');
            }
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $result = $result->whereBetween('created_at', [$from_date.' 00-00-01', $to_date.' 23-59-59']);
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'ASC')->skip($offset)->take($limit)->get();
        //dd($result_data);

        if(isset($result_data)){
            $total_balance = 0;
            foreach($result_data as $item){
                $single_field['unique_id'] = '#'.$item->unique_id;
                $date = explode(' ', $item->created_at);
                $single_field['created_at'] = $date[0];
                $single_field['description'] = (!empty($item->description))?$item->description:'---';
                $single_field['debit'] = (!empty($item->is_debit))?'Rs: '.$item->amount:'0';
                $single_field['credit'] = (!empty($item->is_credit))?'Rs: '.$item->amount:'0';
                if(!empty($item->is_debit)){
                    $total_balance = $total_balance+$item->amount;
                }
                if(!empty($item->is_credit)){
                    $total_balance = $total_balance-$item->amount;
                }
                $single_field['balance'] = 'Rs: '.$total_balance;
                $result_array[] = $single_field;
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
