@extends('layouts.app')

@section('title', 'Create Permission')

@include('permissions.form', [
    'title' => 'Create New Permission',
    'action' => route_admin('permission.store'),
    'button' => 'Create New',
    'breadcrumb' => [route('permission.index') => 'Permissions', 'Create']
])
