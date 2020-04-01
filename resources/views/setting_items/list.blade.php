@extends('layouts.app')

@section('title', 'Manage Setting Item')

@section('content')
    @content([
        'title' => 'Manage Setting Item',
        'card_title' => 'All Setting Item',
        'btn_create' => ['route' => route_admin('setting_items.create')],
        'breadcrumb' => ['Settings'],
    ])
        {!! $dataTable->table() !!}
    @endcontent
@endsection

@datatable
