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
        request()->session()->put('project', ["id" => request()->project_id, "name" => request()->project_name]);

        return view('dashboard.index');
    }
}
