@extends('layouts.app')

@section('title', 'Manage {display_name}')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Posts</h1>
    <div class="section-header-button">
        <a href="{{ route('posts.create')}}" class="btn btn-primary btn-icon icon-right">Create New <i class="fas fa-plus"></i></a>
    </div>
  </div>
  <div class="section-body">
    @alert
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Posts</h4>
                </div>
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between p-3">
                        <div>
                            <button class="btn btn-secondary">Delete Selected</button>
                        </div>
                            <div class="md-form ml-3 flex-grow-1 mr-3 mb-3">
                                <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                            </div>
                        <div>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Sort by
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="dropdown-item" href="#">Asc</a>
                                  <a class="dropdown-item" href="#">Desc</a>
                                </div>
                              </div>
                        </div>
                    </div>
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>#</th><th> Title</th>
                                    <th> Body</th>
                                    <th> comments</th>
                                    <th> Author</th>
                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($posts as $post)
                                <tr>
                                <td class="text-center align-middle"><input type="checkbox" class="form-check-input" id="checkbox_${var_plural}" name="cb_${var_plural}[]"></td>
                                    <td>{{ str_limit($post->title, $limit = 50, $end ="...") }}</td>
                                    <td>{{ str_limit($post->body, $limit = 50, $end ="...") }}</td>
<td><button type="button" class="btn btn-info" id="btncomments" data-relation ="comments" onclick="showRelation({{ $post->id }}, 'post','comments')">Show comments</button></td>
<td><button type="button" class="btn btn-info" id="btnAuthor" data-relation ="Author" onclick="showRelation({{ $post->id }}, 'post','Author')">Show Author</button></td>

                                    <td class="text-right">
                                        <a class="btn btn-primary" href="{{ route('posts.edit', $post->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @deletebutton([
                                            'id' => $post->id,
                                            'route' => route('posts.destroy', $post->id)
                                        ])
                                            <i class="fa fa-trash"></i>
                                        @enddeletebutton
                                    </td>
                                </tr>
                                @php
                                    $no++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
<div class="modal fade mt-5" id="relationModal" tabindex="-1" role="dialog" aria-labelledby="relationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="relationModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="list-of-data"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-submit">Submit</button>
        </div>
      </div>
    </div>
  </div>
    </section>
@endsection

@push('scripts')
<script>
    function showRelation(record_id, cm_name, target_name){
        $('#relationModal').modal({"backdrop" : false});
    }
</script>
@endpush
