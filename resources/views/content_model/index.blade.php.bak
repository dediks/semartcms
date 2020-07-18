@extends('layouts.app')

@section('title', 'Content Model Manager')

@section('content')
    @content([
        'title' => 'Content Model Manager',
        'breadcrumb' => ['Content Model'],
        'card_default' => false,
        'section_title' => $cm->table_display_name,
        'section_description' => $cm->table_description
    ])
        @alert
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Choose Content Model</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            @foreach($cm_list as $cm_entity)
                              <li class="nav-item"><a class="nav-link{{($cm_entity->table_name == $cm->table_name ? ' active' : '')}}" href="{{ route('content_model.index', $cm_entity->table_name) }}">{{ $cm_entity->table_display_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @if($cm->table_name != null)
                    <div class="card card-primary">
                        <div class="card-header d-inline">
                            <h4 class="card-title d-inline">{!! $cm->table_display_name !!}</h4>
                            <a href="{{ route('content_model.layout') }}" class="btn btn-primary float-right"> Add New Content Model</a>
                        </div>
                        <div class="ml-4">
                            @deletebutton([
                                    'id' => $cm->table_name,
                                    'route' => route('content_model.destroy', $cm->table_name),
                                    'size' => 'btn-sm',
                                    'kind' => 'Content Model'
                                ])
                                <i class="fa fa-trash">Delete Model</i> 
                            @enddeletebutton
                            <a href="#" class="btn-edit-model btn btn-sm btn-info" data-toggle="modal" data-target="#edit-model-modal" data-table-name="{{ $cm->table_name }}">
                                <i class="fa fa-edit"> Edit Model </i>
                            </a>
                        </div>
                        <div class="card-body" id="content-field">
                            {{-- list column --}}
                        </div>
                    </div>
                @else
                    <div class="card card-primary">
                        <div class="card-header d-inline">
                            <a href="{{ route('content_model.layout') }}" class="btn btn-primary float-right"> Add New Content Model</a>
                        </div>
                        <div class="card-body d-flex justify-content-center" id="content-field" style="min-height: 300px ">
                            <span class="align-self-center">Choose the content Model on the left</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>                   
    @endcontent   
    <div class="modal fade" id="edit-model-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="edit-modal-title">Edit Content Model</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="model-modal-body">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-save-edit-model" data-table-name="{{ $cm->table_name }}">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    <div class="modal fade" id="edit-field-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="edit-modal-title">Edit Field</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
@stop
@isset($cm->table_name)
    @push('scripts')
    <script src="{{ asset('scripts/sweetalert/sweetalert.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            let a;
            let attributes;

            loadData();

            function loadData(){
                $.ajax({
                    url: '/content-model/{{ $cm->table_name }}/json',
                    dataType: 'json',
                    success: function(data) {
                        result = data;
                        a = JSON.parse(JSON.stringify(result));                
                        attributes = a["attributes"];
                        let field_in_html = '';

                        if(attributes == null){
                            field_in_html += ` 
                                    <li class="list-group-item text-center">
                                        <a>No Field</a>
                                    </li>`
                        }else{
                            for(var i in attributes){
                                field_in_html += ` 
                                    <li class="list-group-item">
                                        <div class="card-title">${ attributes[i].display_name }</div>
                                        <span class="badge badge-pill badge-light">${ attributes[i].db_type }</span>
                                        ${ attributes[i].required ? `
                                        <span class="badge badge-pill badge-warning">${ attributes[i].required }</span>` : ''}
                                        ${ attributes[i].max ? `
                                        <span class="badge badge-pill badge-warning">${ attributes[i].max }</span>` : ''}
                                        ${ attributes[i].min ? `
                                        <span class="badge badge-pill badge-secondary">${ attributes[i].min }</span>` : ''}
                                        ${ attributes[i].max_filesize ? `
                                        <span class="badge badge-pill badge-secondary">${ attributes[i].max_filesize }</span>` : ''}
                                        <a href="#" class="btn-del-column badge badge-pill badge-danger" data-id="${ attributes[i].name }">Delete</a>
                                        <a href="#" class="btn-edit badge badge-pill badge-info" data-attributes="${ attributes[i].name }" data-toggle="modal" data-target="#edit-field-modal">Edit Field</a>
                                    </li>                               
                                `;
                            }

                            field_in_html += ` <div class="card-footer bg-whitesmoke text-right">
                                                    <button class="btn btn-dark">Save Changes</button>
                                                </div>`;
                        }                    

                        $('#content-field').html(field_in_html);               
                    }
                });
            }

            $(document).on('click', '.btn-del-column', function(e) {
                let field_name = e.target.dataset.id;
                var token = $("meta[name='csrf-token']").attr("content");

                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Are you sure will delete this field ? ",
                    icon: "warning",
                    buttons: [
                        'Cancel',
                        'Yes'
                    ],
                    dangerMode: true,
                    }).then(function(isConfirm) {
                        if (isConfirm) {
                            delete a["attributes"][field_name];
                            $.ajax({
                                url: '/content-model/{{ $cm->table_name }}/delete-field',
                                method : 'post',
                                dataType: 'json',
                                data : { 
                                    _token: token,
                                    table_name : `{{ $cm->table_name }}`,
                                    field_name : field_name,
                                    model : a 
                                },
                                success: () => {
                                    console.log("berhasil hapus");
                                    loadData();
                                },
                                error : () => {
                                    console.log("error");
                                    loadData();
                                }
                            });
                        } 
                    })                
            });        

            $(document).on('click', '.btn-edit', function(e){
                let attributes = e.target.dataset.attributes;
                console.log(e);

                // console.log(attributes.name);
                // $('#edit-modal-title').append(attributes.display_name);
            })

            $('.btn-edit-model').on('click', function(e){
                $.ajax({
                    url : '/content-model/edit/' + $(this).data('tableName'),
                    success : e => {
                        
                        const edit_model_body = `  
                            <hr>
                                            <div class="container ml-2 mt-2">
                                                <div class="form-group">
                                                    <label for="display-name">Display Name</label>
                                                    <input type="text" class="form-control" id="model-display-name" value="${ e.table_display_name }">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="descriptiom" id="model-description" class="form-control" cols="30" rows="10">${ e.table_description }</textarea>
                                                </div>
                                            </div>
                                            `;

                            $('.model-modal-body').html(edit_model_body);

                            $('.btn-save-edit-model').on('click', function(e){
                                let model_dis_name = $('#model-display-name').val();
                                let model_desc = $('#model-description').val().trim();
                                var token = $("meta[name='csrf-token']").attr("content");
                                
                                // Update json file
                                a["info"]["display_name"] = model_dis_name;
                                a["info"]["description"] = model_desc;

                                $.ajax({
                                    url : `/content-model/update/`+ $(this).data('tableName'),
                                    method : "POST",
                                    data : {
                                        _token: token,
                                        model_table_name : $(this).data('tableName'),
                                        model_dis_name : model_dis_name,
                                        model_desc : model_desc,
                                        info_model : a
                                    },
                                    success : (res) => {
                                        $("#status").html(res.message)

                                        swal({
                                            title: 'Success',
                                            text: 'Content Model Info Updated Successfully',
                                            icon: 'success'
                                        }).then(function() {				
                                            window.location = '{{ route('content_model.index') }}';
                                        });
                                    }
                                })
                            });
                    }
                });
            });
        });
    </script>
    @endpush
@endisset
