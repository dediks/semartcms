@extends('layouts.app')

@section('title')
Extension List
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Extensions List</h1>
  </div>

  <div class="section-body">
    <div class="card-group">
      <div class="col">
        <div class="card">
          {{-- <img class="card-img-top" src=".." alt="Card image cap" width="100"> --}}
          <div class="card-body">
            <h5 class="card-title">Assets Manager</h5>
            <p class="card-text">Extension ini digunakan untuk keperluan pengelolaan assets</p>
            <button class="float-right btn btn-primary">Not Installed</button>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          {{-- <img class="card-img-top" src="" alt="Card image cap" width="100"> --}}
          <div class="card-body">
            <h5 class="card-title">Content Model Generator</h5>
            <p class="card-text">Plugin untuk melalukan generate content model secara mudah dan otomatis.</p>
            <button class="float-right btn btn-primary">Install</button>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          {{-- <img class="card-img-top" src="" alt="Card image cap" width="100"> --}}
          <div class="card-body">
            <h5 class="card-title">Block Manager</h5>
            <p class="card-text">Plugin untuk melalukan generate content model secara mudah dan otomatis.</p>
            <button class="float-right btn btn-primary">Install</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
