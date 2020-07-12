@extends('layouts.app')

@section('title', 'Create Posts')

@include('posts.form', [
    'title' => 'Create New post',
    'action' => route('posts.store'),
    'button' => 'Create New'
])
