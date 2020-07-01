@extends('layouts.app')

@section('title', 'Create Phones')

@include('phones.form', [
    'title' => 'Create New phone',
    'action' => route('phones.store'),
    'button' => 'Create New'
])
