<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects()->get();

        return view('home', ['projects' => $projects]);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $project = Auth::user()->projects()->create($data);

        if ($project) {

            return "success";
        } else {

            return "fail";
        }
    }

    public function save()
    {
        $data = [
            'name' => 'required',
            'description' => 'required',
        ];

        $project = Auth::user()->projects()->create($data);

        dd($project);
    }
}
