<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index(Request $request) : View {
        $invoices = Invoice::all();
        return View('invoices.index',compact('invoices'));
    }
}
