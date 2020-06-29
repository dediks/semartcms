@extends('layouts.app')

@section('title', 'Create Customers')

@include('customers.form', [
    'title' => 'Create New customer',
    'action' => route('customers.store'),
    'button' => 'Create New'
])
