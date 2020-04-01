@extends('layouts.app')

@section('title', 'Create User')

@include('users.form', [
    'title' => 'Create New User',
    'action' => route('users.store'),
    'button' => 'Create New',
    'breadcrumb' => [route('users.index') => 'Users', 'Create']
])
