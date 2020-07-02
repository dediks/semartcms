@extends('layouts.app')

@section('title', 'Edit book')

@include('books.form', [
    'title' => 'Edit book',
    'action' => 'books.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
