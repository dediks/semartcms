@section('content')
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
            <a class="btn" href="{{ route('tests.index') }}"><i class="fas fa-chevron-left"></i></a>
        </div>
        <h1>{{$title}}</h1>
      </div>

      <div class="section-body">
        @alert

    	<div class="row">
    	    <div class="col-12">
    	        <div class="card card-primary">
    	            <div class="card-header">
    	                <h4>{{$title}}</h4>
    	            </div>
    	            <div class="card-body">
                        @isset($edit)
                        {{ Form::model($test, ['route' => [$action, $id], 'enctype' => 'multipart/form-data']) }}
                        @else
    	            	<form method="post" action="{{ $action }}" enctype="multipart/form-data">
                        @endisset
                            @csrf
                            {{ isset($method) ? method_field($method) : '' }}
                            @field([
                'label' => "Title",
                'name' => "title",
                'type' => "text",
                'validation'=>[
                    'required' => "",
                    'unique' => "",
                    'max' => "",
                    'min' => "",
                ]
            ])
@field([
                'label' => "Price",
                'name' => "price",
                'type' => "text",
                'validation'=>[
                    'required' => "",
                    'unique' => "",
                    'max' => "",
                    'min' => "",
                ]
            ])

    		                <div class="form-group row mb-4">
    		                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    		                    <div class="col-sm-12 col-md-7">
    		                        <button class="btn btn-primary">{{ $button }}</button>
    		                    </div>
    		                </div>
    		            </form>
    	            </div>
    	        </div>
    	    </div>
    	</div>
      </div>

					<!-- Modal -->
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
    data_to_send = [];

    function selectRelatedRelation(target_model, name, modifier)
    {
        $.ajax({
            url: '{{ route('content_model.load-related-model') }}',
            dataType: 'json',
            type: 'POST',
            data: {
                "target_model" : target_model,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {    
                console.log(res.responseText);
                if(res != ""){
                    appendModal(res, target_model, name, modifier);
                }else{
                    $('#list-of-data').html("No data ");
                }
            },
            error: function(x, e) {
                $('#list-of-data').html("No data ");
                // console.log(x);
            }
       });

    //    console.log(target_model);
        $('#relationModalLabel').html("Select " +target_model);                
        $('#relationModal').modal({"backdrop" : false});

        $('#btn-submit').click(function(){

            let data = [];
            data = $('input[name="selectedCheckbox[]"]:checked');

            if(data.length > 0){
                for (let i = 0; i < data.length; i++) {
                    data_to_send.push(data[i].value);
                }

                // console.log(data_to_send);
                // console.log("safhafhaf");

                $('#temp_data_selected').val(JSON.stringify(data_to_send));

                $("#view_selected_"+target_model+"").html("There are any "+ data.length + " " + target_model + " that you have selected !");
            }


            // console.log(JSON.stringify(data_to_send));

            // $.ajax({
            //     url: '{{ route('content_model.submit-related-model') }}',
            //     dataType: 'json',
            //     type: 'POST',
            //     data:{
            //         data : data_to_send,
            //         data_relation : {
            //             target_model : target_model,
            //             name : name,
            //             modifier : modifier
            //         }
            //     },
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     success: function(res) {
            //         console.log(res);
            //     },
            //     error: function(x, e) {
            //         console.log(x);
            //     }
			// });
        });

    }

    function appendModal(res, target_model, name, modifier){
        if(res != null && res != undefined && res.length > 0)
        {

            htmlnya = '';
            
            if(name == 'many-many' || (name == 'one-many' && modifier == 'hasMany') )
            {
                htmlnya += `<div class="form-group">
                    <table class="table">
                <thead>
                    <td>#</td>
                    `;
                
                countCol = 0;
                Object.keys(res[0])
                    .forEach(function eachKey(key) { 
                        if(countCol === 4){
                            return;
                        }

                        htmlnya += `
                            <td class="text-bold">
                                <b>${key}</b>  
                            </td>
                        `;

                        countCol++; 
                    });

                htmlnya += `</thead><tbody>`;
                res.forEach(function(record){
                    htmlnya += `                        
                    <tr>
                        <td> 
                            <input class="form-control" type="checkbox" id="cb_relation" value="${record.id}" name="selectedCheckbox[]">
                        </td>
                    `;
                    
                    count = 0;
                    Object.values(record).forEach(function(col){
                        if(count === 4){
                            return;
                        }
                        
                        htmlnya += `
                            <td>
                                ${col}
                            </td>
                        `;

                        count++;
                    });

                    htmlnya += `                        
                    </tr>
                    `;
                });

                htmlnya += `
                </tbody>
                        </table>
                        </div>
                `;

                $('#list-of-data').html(htmlnya);
            }else{
                
            }

        }else{
            $('#list-of-data').html("You dont have any " + target_model + " data");
            $('#relationModalLabel').html("Opps!");
        }
    }
</script>

@endpush