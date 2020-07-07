@extends('layouts.app')

@section('title', 'Edit order')

@include('orders.form', [
    'title' => 'Edit order',
    'action' => 'orders.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
