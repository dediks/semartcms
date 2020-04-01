@extends('layouts.app')

@section('title', 'Content Model Manager')

@section('content')
    @content([
        'title' => 'Content Model Manager',
        'breadcrumb' => ['Settings'],
        'card_default' => false,
        'section_title' => $setting->display_name,
        'section_description' => $setting->description
    ])
        @push('section-button')
            @if(auth()->user()->can('setting-item-list') || auth()->user()->can('setting-group-list'))
            <div class="section-header-button dropdown">
                <a class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" href="#">Manage</a>
                <ul class="dropdown-menu">
                    @can('setting-group-list')
                    <li><a class="dropdown-item" href="@routeAdmin('settings.list')">Manage Group</a></li>
                    @endcan
                    @can('setting-item-list')
                    <li><a class="dropdown-item" href="@routeAdmin('setting_items.list')">Manage Items</a></li>
                    @endcan
                </ul>
            </div>
            @endif
        @endpush

        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Choose Content Model</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            @foreach(Setting::getGroup() as $group)
                            <li class="nav-item"><a class="nav-link{{($setting->name == $group->name ? ' active' : '')}}" href="@routeAdmin('settings.index', $group->name)">{!! $group->display_name !!}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <form action="@routeAdmin('settings.save', $setting->name)" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>{!! $setting->display_name !!}</h4>
                        </div>
                        <div class="card-body">
                            @if(count($setting->items))
                                @foreach($setting->items as $item)
                                    {!! 
                                        field(FieldHelper::get($item->type), [
                                            'name' => $item->id, 
                                            'label' => $item->display_name,
                                            'value' => setting($item->id),
                                            'options' => FieldHelper::options($item->type)
                                        ]) 
                                    !!}
                                @endforeach
                            @else
                            <div class="text-center">
                                <i>No Setting</i>
                            </div>
                            @endif
                        </div>
                        @if(count($setting->items))
                        <div class="card-footer bg-whitesmoke text-right">
                            <button class="btn btn-primary">Save Changes</button>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    @endcontent
@stop
