@extends('layouts.app')

@section('title', 'Edit orang')

@include('orangs.form', [
    'title' => 'Edit orang',
    'action' => 'orangs.update',
    'method' => 'PUT',
    'edit' => true,
    'button' => 'Save Changes',
])
