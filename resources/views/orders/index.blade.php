@extends('layouts.app')

@section('title', 'Manage {display_name}')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Orders</h1>
    <div class="section-header-button">
        <a href="{{ route('orders.create')}}" class="btn btn-primary btn-icon icon-right">Create New <i class="fas fa-plus"></i></a>
    </div>
  </div>
  <div class="section-body">
    @alert
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Orders</h4>
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
                                    <th>No</th><th> Invoice Number</th>
<th> customers</th>
<th> books</th>

                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($orders as $order)
                                <tr>
                                    <td class="text-center align-middle"><input type="checkbox" class="form-check-input" id="checkbox_$orders" name="cb_$orders[]"></td>
                                    <td>{{ str_limit($order->invoice_number, $limit = 50, $end ="...") }}</td>
<td><button type="button" class="btn btn-info" id="btncustomers" data-relation ="customers" onclick="showRelation({{ $order->id }}, 'order','customers')">Show customers</button></td>
<td><button type="button" class="btn btn-info" id="btnbooks" data-relation ="books" onclick="showRelation({{ $order->id }}, 'order','books')">Show books</button></td>

                                    <td class="text-right">
                                        <a class="btn btn-primary" href="{{ route('orders.edit', $order->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @deletebutton([
                                            'id' => $order->id,
                                            'route' => route('orders.destroy', $order->id)
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
                    {{ $orders->links() }}
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
        
        $.ajax({
            url: '{{ route('content_model.load-related-model-data') }}',
            dataType: 'json',
            type: 'POST',
            data: {
                "target_name" : target_name,
                "cm_name" : cm_name,
                "record_id" : record_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {    
                console.log(res);
                // if(res != ""){
                //     // appendModal(res, target_model, name, modifier);
                // }else{
                //     $('#list-of-data').html("No data ");
                // }
            },
            error: function(x, e) {
                $('#list-of-data').html("No data ");
                console.log(x);
            }
       });

    }
</script>
@endpush
