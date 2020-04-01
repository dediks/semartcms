@extends('layouts.app')

@section('title', 'Edit Setting Item')

@include('admin.setting_items.form', [
    'title' => 'Edit Setting Item',
    'action' => route_admin('setting_items.update', $id),
    'method' => 'PUT',
    'breadcrumb' => [route_admin('setting_items.list') => 'Setting Items', 'Edit'],
    'button' => 'Save Changes',
])
