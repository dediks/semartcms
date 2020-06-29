@extends('layouts.app')

@section('title', 'Create Sdasas')

@include('sdasas.form', [
    'title' => 'Create New sdasas',
    'action' => route('sdasas.store'),
    'button' => 'Create New'
])
