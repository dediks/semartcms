@extends('layouts.app')

@section('title', 'Create Books')

@include('books.form', [
    'title' => 'Create New book',
    'action' => route('books.store'),
    'button' => 'Create New'
])
