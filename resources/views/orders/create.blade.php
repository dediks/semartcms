@extends('layouts.app')

@section('title', 'Create Orders')

@include('orders.form', [
    'title' => 'Create New order',
    'action' => route('orders.store'),
    'button' => 'Create New'
])
