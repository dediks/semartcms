@extends('layouts.app')

@section('title', 'Create Setting Item')

@include('setting_items.form', [
    'title' => 'Create New Setting Item',
    'action' => route('setting_items.store'),
    'button' => 'Create New',
    'breadcrumb' => [route('setting_items.list') => 'Setting Items', 'Create']
])
