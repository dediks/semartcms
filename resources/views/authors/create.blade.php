@extends('layouts.app')

@section('title', 'Create Authors')

@include('authors.form', [
    'title' => 'Create New author',
    'action' => route('authors.store'),
    'button' => 'Create New'
])
