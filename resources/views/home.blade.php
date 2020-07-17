@extends('layouts.start')

@section('content')
  <div class="row mb-3" style="margin-top: 200px">
    <div class="col">
      <div class="d-inline">
        <h3>Your Projects</h3> 
      </div>
        <div class="float-right">
          <button type="button" class="btn btn-primary btn-large h-100 w-100" data-toggle="modal" data-target="#exampleModal">
            New Project
          </button>
        </div>
    </div>
  </div>
  <div class="row">
    @forelse  ($projects as $project)
      <div class="col-md-4 mr-2 mt-3" style="min-height: 200px">
          <div class="card" style="margin: 0">
              <div class="card-body">                
                <div class="card-title d-inline">
                  <h5 class="d-inline">{{$project->name}}</h5>
                  @can('Manage Project')
                  <div class="btn-group float-right">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu">
                      <button class="btn btn-block btn-danger delete-project" data-id="{{ $project->id}}">Delete</button>  
                    </div>
                  </div>
                  @endcan()
                </div>
                <p class="card-text">{{$project->description}}</p>
                <form action="{{ route('project.go')}}" method="POST">
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
      You don't have a project yet
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript">
      function runAjax(url, data){
        $.ajax({
          url: url,
          cache: false,
          type : "post",
          data : data,
          success: function(e){
            console.log(e);
            if (e === true || e === "success" ){
              window.location.reload()
            }
          }
        });
      }

      $("#btn-create-project").click(function(event){
        let title = $("#title").val();
        let description = $("#description").val();
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        let data = {
            _token: CSRF_TOKEN,
            name : title,
            description:description
          };

        runAjax("/projects", data);
      });

      $('.delete-project').click(function(e){
          swal({
            title: "Are you sure?",
            text: "You will not be able to recover this project file!",
            icon: "warning",
            buttons: [
              'No!',
              'Yes, I am sure'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
              url = "/projects/delete";
              const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
              
              data = {
                _token: CSRF_TOKEN,
                id : $(e.target).data('id')
              },

              runAjax(url, data);
            }
        })
      });
  </script>
  @endpush
@endsection
