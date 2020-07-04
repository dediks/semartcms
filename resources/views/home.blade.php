@extends('layouts.start')

@section('content')

  <div class="row mb-3" style="margin-top: 200px">
    <div class="col">
      <h3>Your Projects</h3> 
    </div>
  </div>
  <div class="row">
    <div class="col-4">
      <div class=" h-100">
        <button type="button" class="btn btn-primary btn-large h-100 w-100" data-toggle="modal" data-target="#exampleModal">
          New Project
        </button>
      </div>
    </div>
    @forelse  ($projects as $project)
      <div class="col-4 mr-4 mt-5" >
          <div class="card" style="margin: 0">
              <div class="card-body">
              <h5 class="card-title">{{$project->name}}</h5>
              <p class="card-text">{{$project->description}}</p>
              <form action="{{ route('dashboard.go')}}" method="POST">
                @csrf
              <input type="hidden" name="project_id" value="{{ $project->id }}">
              <input type="hidden" name="project_name" value="{{ $project->name }}">
              <button type="submit" clasas="btn btn-primary">Go</button>
              </form>
              </div>
          </div>
      </div>     
    @empty
    <div class="col-12 mt-5 text-center"> 
        Anda belum memiliki project sama sekali   
    </div>
    @endforelse
  </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create a new project</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form>
        <div class="modal-body">
            <div class="form-group">
              <label for="title">Project Title</label>
              <input type="text" class="form-control" id="title" placeholder="ex: blog">
            </div>
            <div class="form-group">
              <label for="description">Project Description</label>
              <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="btn-create-project" class="btn btn-primary">Create</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  @push('scripts')
  <script type="text/javascript">
      $("#btn-create-project").click(function(event){
        let title = $("#title").val();
        let description = $("#description").val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
          url: "/projects",
          cache: false,
          type : "post",
          data : {
            _token: CSRF_TOKEN,
            name : title,
            description:description
          },
          success: function(e){
            console.log(e);
            if (e === "success"){
              window.location.reload()
            }
          }

        });

        // event.preventDefault();
      });
    </script>
  @endpush
@endsection
