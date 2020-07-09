@extends('layouts.app')

@section('title', 'Edit test')

@include('tests.form', [
    'title' => 'Edit test',
    'action' => 'tests.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
