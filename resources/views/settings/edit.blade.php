@extends('layouts.app')

@section('title', 'Edit Setting Group')

@include('admin.settings.form', [
    'title' => 'Edit New Setting Group',
    'action' => route_admin('settings.update', $id),
    'method' => 'PUT',
    'button' => 'Save Changes',
    'breadcrumb' => [route_admin('settings.list') => 'Settings', 'Edit']
])
