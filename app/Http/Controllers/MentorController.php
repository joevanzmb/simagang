<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    // ================= ADMIN AREA =================
    public function index()
    {
        
        return view('mentor.index');
    }


    public function create()
    {
        return view('mentor.create');
    }
    
}
