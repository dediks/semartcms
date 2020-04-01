@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    @content([
        'title' => 'Manage Users',
        'card_title' => 'All Users',
        'btn_create' => ['route' => route('users.create')],
        'breadcrumb' => ['Users'],
    ])
        {!! $dataTable->table() !!}
    @endcontent
@endsection

@datatable