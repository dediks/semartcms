@extends('layouts.app')

@section('title', 'Edit category')

@include('categories.form', [
    'title' => 'Edit category',
    'action' => 'categories.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
