@extends('layouts.app')

@section('title', 'Update User')

@include('users.form', [
    'title' => 'Edit User',
    'action' => route_admin_name('users.update'),
    'method' => 'PUT',
    'edit' => true,
    'breadcrumb' => [route_admin('users.index') => 'Users', 'Edit'],
    'button' => 'Save Changes',
])
