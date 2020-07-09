@extends('layouts.app')

@section('title', 'Manage Permissions')

@section('content')
    @content([
        'title' => 'Manage Permissions',
        'card_title' => 'All Permissions',
        'btn_create' => ['route' => route_admin('permission.create')],
        'breadcrumb' => ['Permissions'],
    ])
        {!! $dataTable->table() !!}
    @endcontent
@endsection

@datatable