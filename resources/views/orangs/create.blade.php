@extends('layouts.app')

@section('title', 'Create Orangs')

@include('orangs.form', [
    'title' => 'Create New orang',
    'action' => route('orangs.store'),
    'button' => 'Create New'
])
