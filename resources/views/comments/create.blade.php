@extends('layouts.app')

@section('title', 'Create Comments')

@include('comments.form', [
    'title' => 'Create New comment',
    'action' => route('comments.store'),
    'button' => 'Create New'
])
