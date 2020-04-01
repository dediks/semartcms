@extends('layouts.app')

@section('title', 'Create Setting Group')

@include('settings.form', [
    'title' => 'Create New Setting Group',
    'action' => route('settings.store'),
    'button' => 'Create New',
    'breadcrumb' => [route('settings.list') => 'Settings', 'Create']
])
