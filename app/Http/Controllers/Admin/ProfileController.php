<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() // digunakan untuk menampilkan halaman view untuk profile user.
    {
        return view('admin.profile.index');
    }
}
