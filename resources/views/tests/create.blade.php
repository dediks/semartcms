@extends('layouts.app')

@section('title', 'Create Tests')

@include('tests.form', [
    'title' => 'Create New test',
    'action' => route('tests.store'),
    'button' => 'Create New'
])
