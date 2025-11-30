<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VpController extends Controller
{
    public function index()
    {
        return view('vp.dashboard');
    }
    public function approval()
    {
        return view('vp.approval');
    }
    public function profile()
    {
        return view('vp.profile');
    }
    public function history()
    {
        return view('vp.history');
    }
    public function statistik()
    {
        return view('vp.statistik');
    }
    
    //
}
