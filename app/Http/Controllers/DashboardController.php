<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show dashboard page
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show profile page
     */
    public function profile()
    {
        return view('profile');
    }
}
