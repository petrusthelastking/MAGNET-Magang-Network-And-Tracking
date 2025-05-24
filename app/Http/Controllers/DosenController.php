<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');          // Hanya user yang login
        $this->middleware('role:dosen');    // Hanya role dosen yang boleh masuk
    }

    /**
     * Display dosen dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = auth()->user();

        return view('dashboard', compact('user'));
    }
}
