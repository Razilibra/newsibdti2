<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $role = session('role');
        $title = "dashboard ".$role;
        
        return view('admin.a_dashboard.dashboard', compact('role', 'title'));
    }
}
