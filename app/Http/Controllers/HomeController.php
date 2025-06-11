<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function cekSaldo()
    {
        $user = Auth::user(); // Ambil user yang sedang login
        return view('saldo', compact('user'));
    }
}
