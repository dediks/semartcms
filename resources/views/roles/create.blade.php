@extends('layouts.app')

@section('title', 'Create Role')

@include('roles.form', [
    'title' => 'Create New Role',
    'action' => route_admin('roles.store'),
    'button' => 'Create New',
    'breadcrumb' => [route('roles.index') => 'Roles', 'Create']
])
