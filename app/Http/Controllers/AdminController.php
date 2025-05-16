<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * Middleware auth dan role:admin
     */
    public function __construct()
    {
        $this->middleware('auth');          // Hanya user yang login
        $this->middleware('role:admin');    // Hanya role admin yang boleh masuk
    }

    /**
     * Tampilkan halaman dashboard admin.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
