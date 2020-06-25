<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function go()
    {
        // dd(request()->project_id);
        request()->session()->put('project', request()->project_id);

        return view('dashboard.index');
    }
}
