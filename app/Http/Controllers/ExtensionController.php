<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function index()
    {
        // dd(request()->session()->all());
        return view('extensions.index');
    }
}
