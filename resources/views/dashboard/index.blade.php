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
              <a href="{{ route('content_model.layout') }}" class="list-group-item list-group-item-action p-4">
                  <i class="fas fa-cube" style="position: relative; font-size: 3em;"></i>
                  <span class="align-middle" style="margin-left : 15px">Create a Content Model</span>
              </a>
              <a href="#" class="list-group-item list-group-item-action p-4">
                  <i class="fas fa-table" style="position: relative; font-size: 3em;"></i>
                  <span class="align-middle" style="margin-left : 15px">Add some fields</span>
              </a>
              <a href="#" class="list-group-item list-group-item-action p-4">
                  <i class="fas fa-upload" style="position: relative; font-size: 3em;"></i>
                  <span class="align-middle" style="margin-left : 15px">Add Content</span>
              </a>
              <a href="#" class="list-group-item list-group-item-action p-4">
                  <i class="fas fa-sync" style="position: relative; font-size: 3em;"></i>
                  <span class="align-middle" style="margin-left : 15px">Make Your API Accessible</span>
              </a>
            </div>
          </div>
        </div>
      </div>
  </div>
</section>
@endsection
