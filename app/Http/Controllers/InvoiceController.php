<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Invoice;
use App\Cash;
use App\Amount;
use App\Patient_test;
use Session;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Karachi");
    }

    public function index()
    {
        if(Session::get('role')!=0){
            return redirect('/redirected');
        }
            
        $data = [];
        $user = Auth::user();
        $data['invoices'] = Invoice::where('status' , '<' ,5)->orderBy('id' , 'DESC')->get();
        $data['closed'] = Invoice::where('status' , 5)->whereDate('updated_at', Carbon::today())->orderBy('id' , 'DESC')->get();
    	return view('invoices.index',$data);
    }

    public function detail($invoice_id = '0')
    {
        $data = [];
    	$data['response'] = false;
        $user = Auth::user();
    	$result = Invoice::where('user_id' , $user->id)->where('id',$invoice_id)->get();
    	if(!empty($result)){
    		$result = $result[0];
    		$data['inv_id'] = '#'.$result->id;
    		$data['patient_name'] = '<h5>'.$result->patient->name.'</h5>';
    		$date = explode(' ', $result->created_at);
    		$data['date'] = $date[0];
    		$tests = '';
    		if(!empty($result->patient_tests)){
                foreach($result->patient_tests as $key2 => $test){
                	$tests .= '<tr>
                        <td>#'.$test->test->id.'</td>
                        <td>'.$test->test->name.'</td>
                        <td style="text-align: right;color: #5D7BFF;">Rs: '.$test->test->price.'</td>
                    </tr>';
                }
    		}
    		$data['tests'] = $tests;
    		$data['total_details'] = '<div class="row">
                <div class="col-sm-6 amp1">
                    Total Amount
                </div>
                <div class="col-sm-6 amp2">
                    Rs: '.$result->total_amount.'
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 amp1">
                    Discount
                </div>
                <div class="col-sm-6 amp2">
                    Rs: '.$result->total_discount.'
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 amp1">
                    Advance
                </div>
                <div class="col-sm-6 amp2">
                    Rs: '.$result->amount_paid.'
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 amp1">
                    Balance
                </div>
                <div class="col-sm-6 amp2">
                    Rs: '.$result->amount_remaining.'
                </div>
            </div>';
    		$data['response'] = true;
    	}
    	echo json_encode($data);
    }

    public function invoice_detail($unique_id = '0' , $code = '')
    {
        $data = [];
        $user = Auth::user();
        $result = Invoice::where('unique_id',$unique_id)->get();
        if(!empty($result[0])){
            if(!empty($code) && $code=='HpD23hObScvX'){
                Invoice::where('unique_id',$unique_id)->update(['status'=>5]);
            }
            $data['printed_by'] = $user->name;
            $data['result'] = $result[0];
            return view('prints.invoice',$data);
        }
    }

    public function pay_invoice(Request $request)
    {
        $data = [];
        $data['response'] = false;

        $formData = $request->all();
        unset($formData['_token']);

        $invoice_id = $formData['invoice_id'];
        $amount_remaining = $formData['amount_remaining'];
        $invoice = new Invoice;
        $result = $invoice->find($invoice_id);
        if(!empty($result)){
            if(($amount_remaining==$result->amount_remaining || $amount_remaining > $result->amount_remaining) || !empty($formData['discount']))
            {
                $update = [];
                if(!empty($formData['discount'])){
                    $update['total_discount'] = $result->total_discount+$result->amount_remaining;
                }
                else{
                    $update['amount_paid'] = $amount_remaining+$result->amount_paid;
                }
                $update['amount_remaining'] = 0;
                $invoice->where('id',$invoice_id)->update($update);

                $this->invoice_update($invoice_id);
                if(empty($formData['discount'])){
                    $user = Auth::user();
                    $amn = new Amount;
                    $amn->user_id = $user->id;
                    $amn->amount = $result->amount_remaining;
                    $amn->description = 'Recieved from patient pending invoice';
                    $amn->patient_id = $result->patient_id;
                    $amn->type = '0';
                    $amn->save();
                    $this->cash_add($result->amount_remaining);
                }
                $data['response'] = true;
            }
        }
        echo json_encode($data);
    }

    public function invoice_update($invoice_id = 0)
    {
        $pt = Patient_test::where('invoice_id' , $invoice_id)->where('status' , 0)->get();
        if(empty($pt[0])){
            $update = ['status' => 3];
            Invoice::where('id',$invoice_id)->update($update);
        }
        return false;
    }

    public function cash_add($cash = '0')
    {
        $user = Auth::user();
        $result = Cash::where('user_id',$user->id)->get();
        if(!empty($result[0]->user_id)){
            $result = $result[0];
            $update = [];
            $update['cash_in_hand'] = $result->cash_in_hand+$cash;
            Cash::where('user_id' , $user->id)->update($update);
        }
        else{
            $save = [];
            $save['user_id'] = $user->id;
            $save['cash_in_hand'] = $cash;
            Cash::insert($save);
        }
        return true;
    }

    public function get_invoices(Request $request)
    {
        $like = [];
        $result_array = [];
        $post = $request->all();

        $orderByColumnIndex = $post['order'][0]['column'];
        $orderByColumn = $post['columns'][$orderByColumnIndex]['data'];
        $orderType = $post['order'][0]['dir'];
        $offset = $post['start'];
        $limit = $post['length'];
        $draw = $post['draw'];
        $search = $post['search']['value'];
        
        //$status = $post['status_filter'];

        $auth = Auth::user();

        $result_count = Invoice::where('status' , '<' ,5)->count();

        $result = new Invoice;
        $result = $result->where('status' , '<' ,5);

        // if($status!='all'){
        //     $result = $result->where('status' , $status);
        // }
        // else{
        //  $result = $result->where('status' , 0)->orWhere('status' , 1)->orWhere('status' , 3)->orWhere('status' , 5);
        // }

        if(!empty($search)){
            $result = $result->where('unique_id','like', '%'.$search.'%');
        }

        $result_count_rows = count($result->get());

        $result_data = $result->orderBy('id' , 'DESC')->skip($offset)->take($limit)->get();

        if(isset($result_data)){
            foreach($result_data as $item){
                $single_field['unique_id'] = '#'.$item->unique_id;
                $date = explode(' ', $item->created_at);
                $single_field['created_at'] = $date[0];
                $single_field['name'] = (!empty($item->patient->name))?$item->patient->name:'unavailable';
                $single_field['tests'] = '---';
                if(!empty($item->patient_tests[0]->test->name)){
                    $tooltip = '';
                    $cc = count($item->patient_tests);
                    foreach($item->patient_tests as $key2 => $test){
                        $i = $key2+1;
                        $tooltip .= $test->test->name;
                        ($i<$cc)?$tooltip .= ' , ':'';
                    }
                    $single_field['tests'] = '<a href="javascript::" data-toggle="tooltip" title="'.$tooltip.'">'.$item->patient_tests[0]->test->name.'</a>';
                }
                $single_field['total_amount'] = "Rs ".$item->total_amount;
                $single_field['amount_paid'] = "Rs ".$item->amount_paid;
                $single_field['amount_remaining'] = "Rs ".$item->amount_remaining;
                
                $single_field['action'] = '<a href="'.url('/invoice-detail/'.$item->unique_id).'" target="_blank">View</a>';
                if($item->amount_remaining > 0){
                    $single_field['action'] .= '| <a href="javascript::" rel="'.$item->id.'" class="pay_now">Pay Now</a>';
                }
                
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
