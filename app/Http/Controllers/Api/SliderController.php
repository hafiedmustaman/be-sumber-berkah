<?php

namespace App\Http\Controllers\Api;

use App\Models\Slider; // untuk menampilkan data slider dari table.
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() // untuk menampilkan data slider dalam format JSON.
    {
        $sliders = Slider::latest()->get();
        return response()->json([
            'success'   => true,
            'message'   => 'List Data Sliders',
            'sliders'   => $sliders
        ]);
    }
}
