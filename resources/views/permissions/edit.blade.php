
@extends('layouts.app')

@section('title', 'Edit Permission')

@include('permissions.form', [
    'title' => 'Edit Permission',
    'action' => route_admin_name('permissions.update'),
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
    'breadcrumb' => [route_admin('permission.index') => 'Permissions', 'Edit']
])
