<?php

namespace Services;

use App\User;
use Role;
use Hash;
use Auth;
use DataTables;
use App\DataTables\UserDataTable;
use App\Events\{
    UserCreated,
    UserUpdated,
    UserDeleted
};
use Image;

class UserService
{
    protected $userDataTable;

    public function __construct(UserDataTable $userDataTable)
    {
        $this->userDataTable = $userDataTable;
    }

    public function model()
    {
        return new User;
    }

    public function find($id)
    {
        return $this->model()->find($id);
    }

    public function dataTable(...$opts)
    {
        return $this->userDataTable->render($opts[0]);
    }

    public function paginate($num)
    {
        return $this->model()->sortable()->paginate($num);
    }

    public function create($request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($request->password);

        $user = $this->model()->create($input);

        $role = Role::find($request->role);

        // dd($role);

        if ($request->hasFile('avatar')) {
            $input['avatar'] = $this->avatar($request);
        }

        if ($role) {
            $user->assignRole($role);
        }

        if ($request->verify) {
            // $user->sendEmailVerificationNotification();
        }

        event(new UserCreated($user));

        return $user;
    }

    public function avatar($request)
    {
        $path = media_path() . '/' . config('starter.paths.images');

        $name = $request->avatar->getClientOriginalName();
        $request->avatar->storeAs($path, $name, 'public');

        $file = storage_path('app/public/' . $path . '/' . $name);
        $image = Image::make($file);
        $image->fit(100);
        $image->save(storage_path($file));

        return $name;
    }

    public function findAndUpdate($request, $id)
    {
        $user = $this->find($id);

        if ($request->password) {
            $user->update([
                'password' => bcrypt($request->password),
                'last_password_update' => date('Y-m-d H:i:s')
            ]);
        }

        if ($request->role && $request->user()->can('user-edit')) {

            $role = Role::find($request->role);

            if ($role) {
                $user->syncRoles([$role]);
            }
        }

        $input = $request->except(['password']);

        if ($request->hasFile('avatar')) {
            $input['avatar'] = $this->avatar($request);
        }

        $user->update($input);

        event(new UserUpdated($user));
    }

    public function delete($id)
    {
        $user = $this->find($id);

        $user->delete();

        event(new UserDeleted($user));

        return $user;
    }

    public function sendVerification()
    {
        $user = $this->find(Auth::id());

        return $user->sendEmailVerificationNotification();
    }
}
