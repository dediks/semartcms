@extends('layouts.app')

@section('title', 'Edit post')

@include('posts.form', [
    'title' => 'Edit post',
    'action' => 'posts.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
