@extends('layouts.app')

@section('title', 'Content Model Manager')

@section('content')
    @content([
        'title' => 'Content Model Manager',
        'card_title' => 'All Setting',
        'btn_create' => ['route' => route('settings.create')],
        'breadcrumb' => ['Settings'],
    ])
        {!! $dataTable->table() !!}
    @endcontent
@endsection

@datatable
