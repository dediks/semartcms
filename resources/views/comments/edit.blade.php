@extends('layouts.app')

@section('title', 'Edit comment')

@include('comments.form', [
    'title' => 'Edit comment',
    'action' => 'comments.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
