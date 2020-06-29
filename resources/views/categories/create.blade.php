@extends('layouts.app')

@section('title', 'Create Categories')

@include('categories.form', [
    'title' => 'Create New category',
    'action' => route('categories.store'),
    'button' => 'Create New'
])
