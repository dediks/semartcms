<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Support\Str;
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

        $data["identifier"] = Str::random(10);

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

    public function destroy()
    {
        return Project::find(request('id'))->entities()->get();
    }

    public function go()
    {
        $data = [
            "id" => request('project_id'),
            "name" => request('project_name')
        ];

        // save selected project data into session
        session(['project' => $data]);

        return view('dashboard.index');
    }
}
