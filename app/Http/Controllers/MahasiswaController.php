<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');              // Hanya user yang login
        $this->middleware('role:mahasiswa');    // Hanya role mahasiswa yang boleh masuk
    }

    /**
     * Display mahasiswa dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = auth()->user();

        return view('mahasiswa.dashboard', compact('user'));
    }
}
