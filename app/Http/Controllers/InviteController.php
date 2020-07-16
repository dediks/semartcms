<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Requests\InviteCreateRequest;
use Services\InviteService;

class InviteController extends Controller
{
    protected $inviteService;

    public function __construct(InviteService $inviteService)
    {
        $this->inviteService = $inviteService;
    }

    public function store(InviteCreateRequest $inviteRequest)
    {
        $project_id = session('project')["id"];
        $user =  User::where('email', '=', $inviteRequest->email)->first();

        if (!$user) {
            return response()->json('email not exists');
        }


        if ($user->projects->contains($project_id)) {
            return response()->json($inviteRequest->email . " already memmbers on this project");
        }

        $user->projects()->attach($project_id);

        return response()->json($inviteRequest->email . " invited successfully");
    }
}
