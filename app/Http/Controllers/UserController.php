<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    UserCreateRequest,
    UserUpdateRequest
};
use Services\UserService;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $user)
    {
        $this->userService = $user;
    }

    public function data()
    {
        return $this->userService->dataTables();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->userService->dataTable('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = $this->userService->create($request);

        flash(__('user.created'))->success();

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userService->find($id);

        return view('users.edit', compact('user', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userService->findAndUpdate($request, $id);

        flash(__('user.updated'))->success();

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == 1) {
            flash(__('user.deleted.denied'))->warning();

            return redirect()->back();
        }

        $this->userService->delete($id);

        flash(__('user.deleted'))->success();

        return redirect(route('users.index'));
    }

    public function resendVerification()
    {
        $user = $this->userService->sendVerification();

        flash(__('user.resent'))->success();

        return redirect()->back();
    }
}
