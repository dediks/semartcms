@extends('layouts.app')

@section('title', 'Edit sdasas')

@include('sdasas.form', [
    'title' => 'Edit sdasas',
    'action' => 'sdasas.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
