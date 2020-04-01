@extends('layouts.app')

@section('title', 'Manage Roles')

@section('content')
    @content([
        'title' => 'Manage Roles',
        'card_title' => 'All Roles',
        'btn_create' => ['route' => route_admin('roles.create')],
        'breadcrumb' => ['Roles'],
    ])
        {!! $dataTable->table() !!}
    @endcontent
@endsection

@datatable