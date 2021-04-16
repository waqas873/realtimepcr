<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Invoice;
use Session;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function invoice_detail($unique_id = '0')
    {
        $data = [];
        $result = Invoice::where('unique_id',$unique_id)->get();
        if(!empty($result[0])){
            $data['result'] = $result[0];
            return view('prints.invoice',$data);
        }
    }
}
