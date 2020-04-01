@extends('layouts.app')

@section('title', 'Edit customer')

@include('customers.form', [
    'title' => 'Edit customer',
    'action' => 'customers.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
