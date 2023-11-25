<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //count invoice
        $pending = Invoice::where('status', 'pending')->count(); // <-- invoice dengan status 'pending'
        $success = Invoice::where('status', 'success')->count(); // <-- invoice dengan status 'success'
        $expired = Invoice::where('status', 'expired')->count(); // <-- invoice dengan status 'expired'
        $failed  = Invoice::where('status', 'failed')->count(); // <-- invoice dengan status 'failed'

        //year and month gunakan sebagai paramater untuk mendapatkan revenue/pendapatan.
        $year   = date('Y');
        $month  = date('m');
		
        //statistic revenue
        $revenueMonth = Invoice::where('status', 'success')->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->sum('grand_total');
        // $revenueMonth untuk menampilkan pendapatan di tahun dan bulan sekarang.
        $revenueYear  = Invoice::where('status', 'success')->whereYear('created_at', $year)->sum('grand_total');
        // $revenueYear untuk menampilkan pendapatan di tahun sekarang.
        $revenueAll   = Invoice::where('status', 'success')->sum('grand_total');
        // $revenueAll untuk menampilkan semua revenue/pendapatan.

        return view('admin.dashboard.index', compact('pending', 'success', 'expired', 'failed', 'revenueMonth', 'revenueYear', 'revenueAll'));
    }
}
