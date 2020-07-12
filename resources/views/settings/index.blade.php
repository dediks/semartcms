@extends('layouts.app')

@section('title', 'Setting Page')

@section('content')
    @content([
        'title' => 'Setting',
        'breadcrumb' => ['Settings'],
        'card_default' => true,
    ])
    <div class="card">
        {{-- <h5 class="card-header">Invite People to this Project</h5> --}}
        <div class="card-body">
          <h6>Invite People to this Project</h6>
          <p class="card-text">You can invite someone to contribute into your project</p>
          <form class="form-inline">
            <div class="form-group mr-5">
              <label for="inputEmail" class="sr-only">email</label>
              <input type="email" class="form-control" id="inputEmail" placeholder="Input an email">
            </div>
            <div class="form-group mb-2 mr-4">
                <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Select Role
                </button>
                <div class="dropdown-menu" id="select-role">
                    <a class="dropdown-item" href="#">Action</a>
                </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary mb-2">Set now</button>
            </div>
          </form>
        </div>
      </div>

    @endcontent
@endsection
@push('scripts')
      
@endpush
