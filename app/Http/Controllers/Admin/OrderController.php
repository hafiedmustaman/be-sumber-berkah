<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() // digunakan untuk menampilkan data invoice order yang dilakukan oleh customer.
    {
        $invoices = Invoice::latest()->when(request()->q, function($invoices) {
            $invoices = $invoices->where('invoice', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.order.index', compact('invoices'));
    }
    
    /**
     * show
     *
     * @param  mixed $invoice
     * @return void
     */
    public function show($id) // digunakan untuk menampilkan detail dari data invoice.
    {
        $invoice = Invoice::findOrFail($id);
        return view('admin.order.show', compact('invoice'));
    }
}
