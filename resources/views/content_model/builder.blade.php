@extends('layouts.app')

@section('title', 'Content Model Builder')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-3">
      <ul class="list-group">
        <li class="list-group-item">Cras justo odio</li>
        <li class="list-group-item">Dapibus ac facilisis in</li>
        <li class="list-group-item">Morbi leo risus</li>
        <li class="list-group-item">Porta ac consectetur ac</li>
        <li class="list-group-item">Vestibulum at eros</li>
      </ul>
    </div>
    <div class="col-7">
      <div id="fields-container" class="bg-white h-100 border border-1"></div>
    </div>
    <div class="col-2">
      <ul class="list-group">
        <li class="list-group-item field" data-toggle="modal" data-target="#setFieldModal" data-type="integer">
          Integer
        </li>
        <li class="list-group-item field" data-toggle="modal" data-target="#setFieldModal" data-type="float">
          Float
        </li>
        <li class="list-group-item field" data-toggle="modal" data-target="#setFieldModal" data-type="string">
          String
        </li>
        <li class="list-group-item field" data-toggle="modal" data-target="#setFieldModal" data-type="text">
          Text
        </li>
        <li class="list-group-item field" data-toggle="modal" data-target="#setFieldModal" data-type="date">
          Date
        </li>
        <li class="list-group-item field" data-toggle="modal" data-target="#setFieldModal" data-type="assets">
          Assets
        </li>
        <li class="list-group-item field" data-toggle="modal" data-target="#setFieldModal" data-type="enum">
          Enum
        </li>
        <li class="list-group-item field" data-toggle="modal" data-target="#setFieldModal" data-type="relation">
          Relation
        </li>
      </ul>
    </div>
  </div>
</div>

{{-- Modal for Field Start --}}
<div class="modal fade" id="setFieldModal" tabindex="-1" role="dialog" aria-labelledby="setFieldModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><div  id="modal-label"></div></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="title">Name</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="ex: blog" required>
            </div>
            <div class="form-group">
              <label for="title">Display Name</label>
              <input type="text" class="form-control" name="display-name" id="display-name" placeholder="ex: Blog" required>
            </div>
            <div class="form-group">
              <label for="description">API id</label>
              <input type="text" class="form-control" name="api-id" id="api-id" placeholder="" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <input type="text" class="form-control" name="description" id="description" placeholder="Brief description about this field" required>
            </div>
            <hr>
            <div id="additional-attribute" class="form-group ml-4">
              <div class="form-group">
                Ini data relations
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="btn-create-field" class="btn btn-primary" data-dismiss="modal" data-field="empty">Create</button>
        </div>
      </div>
    </div>
  </div>
  {{-- Modal for Field End --}}

  {{-- Modal on Start Page --}}
  <div id="checkfield" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
          <h4 class="modal-title"><i class="fas fa-heart-broken"></i> Recover Layout</h4>
        </div>
        <div class="modal-body">
          We have found your last work <code id="content-model-name"></code>, would you like to recover it?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="recover" data-dismiss="modal" data-confirmation="recover">Recover</button>
          <button type="button" class="btn btn-default" id="destroy" data-dismiss="modal" data-confirmation="destroy">Destroy</button>
        </div>
      </div>
  
    </div>
  </div>
  {{-- Modal Start Page End --}}

  @push('scripts')
  <script src="{{ asset('scripts/sweetalert/sweetalert.js') }}"></script>
  <script>
    let request_url = {
      components: '{{ route('fields.file', ['json', 'fields_list']) }}',
      intructions: '{{ route('fields.file', ['md', 'intructions']) }}',
      generate: '{{ route('content_model.generate') }}'
    };

    $(document).ready(function() 
    {
      let saved_fields = JSON.parse(localStorage.getItem("saved_fields"));
      
      if(saved_fields)
      {
        $('#checkfield').modal({backdrop: 'static', keyboard: false});
        // console.log(status);

        $('#checkfield .modal-footer button').on('click', function(event) {
          var confirm = $(event.target)[0].dataset.confirmation;

          if(confirm === "recover")
          {
            let field_element = '';

            saved_fields.forEach(field => {
              field_element += `
                <li class="list-group-item">
                    <div class="card-title"><h6>${ field.display_name }</h6></div>
                    <span class="badge badge-pill badge-light">${ field.db_type }</span>
                    <a href="#" class="btn-del-column badge badge-pill badge-danger" data-id="${ field.name }">Delete</a>
                    <a href="#" class="btn-edit badge badge-pill badge-info" data-attributes="${ field.name }" data-toggle="modal" data-target="#setFieldModal">Edit Field</a>
                </li>                 
              `;
            });

            $('#fields-container').append(field_element); 

          }else{
           localStorage.removeItem('saved_fields');
          }
        });
      };

      fields_load();
    });

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
               console.log("delete");
            })                
    });        

    //update a field

    $(document).on('click', '.btn-edit', function(e){
        let field_name = e.target.dataset.attributes;
        let selected_field = JSON.parse(localStorage.getItem("saved_fields"));

        // console.log(field_name);

        let field_will_edited;
        selected_field.forEach(field => {
          if(field.name == field_name)
          {
            field_will_edited = field;
          }
        });

        $('#setFieldModal #name').val(field_will_edited.name);
        $('#setFieldModal #display-name').val(field_will_edited.display_name);
        $('#setFieldModal #description').val(field_will_edited.description);
        $('#setFieldModal #api-id').val(field_will_edited.api_id);
        $('#setFieldModal').modal();
        console.log(field_will_edited);

        // saved_fields.forEach(field => {

        // });
        // console.log(selected_field);
    });
    
    let field;

    $('.field').click(function(e){
      field = $(this).data('type');
      // console.log($(this)[0].outerText);

      //set modal title      
      // $('#modal-label')[0].outerText = "New " + $(this)[0].outerText + " Field";
 
      field_selected = JSON.parse(localStorage.getItem('field_list'))[field];
      selected_field_additonal_attr = field_selected['additional_attribute'];

      console.log(selected_field_additonal_attr);

      if(field_selected != 'relation')
      {
        let validation_element = '';
        
        selected_field_additonal_attr.forEach(add_attr => {
          validation_element  +=`
            <div class="form-group w-100">              
              <label class="custom-control-label" for="${add_attr.name}">${add_attr.display_name}</label>
              <input type="${add_attr.input_type}" class="form-control" id="${add_attr.name}" value="${add_attr.value}">
            </div>
          `;
        });

        $('#additional-attribute').html(validation_element);
      };
  
      //drop selected field
      $('#btn-create-field').click(function(){         
        select_field(field);
      });
    });

    // load content fields
    function fields_load () {
			var result = null;

			$.ajax({
				url: request_url.components,
				dataType: 'json',
				beforeSend: function() {
					// toolbox.add('<li id="loading-component">Loading Components ...</li>');
				},
				complete: function() {
					// toolbox.remove("#loading-component");
				},
				success: function(data) {
          // console.log(data);
          localStorage.setItem('field_list', JSON.stringify(data.data[0].children));
				}
			}); 
		};


    // when user select a field
    let temp = [];

    function select_field(field)
    {
      let saved_fields = JSON.parse(localStorage.getItem("saved_fields"));
      let selected_field = JSON.parse(localStorage.getItem("field_list"))[field];

      let api_id = $('#api-id').val();
      let display_name = $('#display-name').val();
      let name = $('#name').val();
      let description = $('#description').val();

      if(field != "relation")
      {
        let required = $('#input-required').val();
        let unique = $('#input-unique').val();
        let maxLength = $('#input-maxLength').val();
        let minLength = $('#input-minLength').val();

        selected_field.additional_attribute.required = required;
        selected_field.additional_attribute.minLength = minLength;
        selected_field.additional_attribute.maxLength = maxLength;
        selected_field.additional_attribute.unique = unique;

      }

      selected_field.display_name = display_name;
      selected_field.name = name;
      selected_field.api_id = api_id;
      selected_field.description = description;
      
      if(saved_fields === null || saved_fields === undefined){
        temp.push(selected_field);
        localStorage.setItem("saved_fields", JSON.stringify(temp));
      }else{
        saved_fields.push(selected_field);
        localStorage.setItem("saved_fields", JSON.stringify(saved_fields));
      }
      
      field_element = `
          <li class="list-group-item">
              <div class="card-title">${ selected_field.display_name }</div>
              <span class="badge badge-pill badge-light">${ selected_field.db_type }</span>
              <a href="#" class="btn-del-column badge badge-pill badge-danger" data-id="${ selected_field.name }">Delete</a>
              <a href="#" class="btn-edit badge badge-pill badge-info" data-attributes="${ selected_field.name }" data-toggle="modal" data-target="#setFieldModal">Edit Field</a>
          </li>                 
        `;
      
      $('#fields-container').append(field_element); 
    }
  </script>
  @endpush
@endsection
