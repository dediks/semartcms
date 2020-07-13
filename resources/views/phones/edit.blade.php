@extends('layouts.app')

@section('title', 'Edit phone')

@include('phones.form', [
    'title' => 'Edit phone',
    'action' => 'phones.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
