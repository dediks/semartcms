@extends('layouts.app')

@section('title', 'Edit author')

@include('authors.form', [
    'title' => 'Edit author',
    'action' => 'authors.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
