
@extends('layouts.app')

@section('title', 'Edit Role')

@include('admin.roles.form', [
    'title' => 'Edit Role',
    'action' => route_admin_name('roles.update'),
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
    'breadcrumb' => [route_admin('roles.index') => 'Roles', 'Edit']
])
