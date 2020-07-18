@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>

  <div class="section-body">
      <div class="col-md-6">
        <div class="card mt-5">
          <div class="card-header"> 
            <h5 class="card-title text-muted">Onboarding Checklist</h5>
          </div>
          <div class="card-body mt-n4">
            <div class="list-group">
              <div>
                <a href="{{ route('content_model.layout') }}" class="list-group-item list-group-item-action p-4">
                    <i class="fas fa-cube" style="position: relative; font-size: 3em;"></i>
                    <span class="align-middle" style="margin-left : 15px">Create a Content Model</span>
                </a>
              </div>
              <div>
                <a href="{{ route('content_model.index') }}" class="list-group-item list-group-item-action p-4">
                      <i class="fas fa-table" style="position: relative; font-size: 3em;"></i>
                      <span class="align-middle" style="margin-left : 15px">Manage your content model</span>
                  </a>
              </div>
              <div>
                <a class="list-group-item list-group-item-action p-4" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-upload" style="position: relative; font-size: 3em;"></i>
                    <span class="align-middle" style="margin-left : 15px">Add Content</span>
                </a>
                <div class="collapse" id="collapseExample">
                    @if(isset($menus))
                      @if (count($menus) > 0)
                        @foreach ($menus as $menu)
                            @php
                                $menu = str_replace('_', '-', $menu["table_name"]);
                            @endphp
                                <a class="list-group-item list-group-item-action" href="{{ route($menu.'.index') }}">
                                  <span>{{ucfirst(trans($menu))}}</span>
                                </a>
                        @endforeach                        
                      @else
                            <span class="p-3 mt-2 mb-2">You dont have any content model right now</span>
                      @endif
                    @endif
              </div>
              <div>
                <a href="/graphql-playground" class="list-group-item list-group-item-action p-4">
                    <i class="fas fa-sync" style="position: relative; font-size: 3em;"></i>
                    <span class="align-middle" style="margin-left : 15px">Test and Get Your GraphQL API</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</section>
@endsection
