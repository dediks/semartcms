@extends('layouts.app')

@section('title', 'Manage {display_name}')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Customers</h1>
    <div class="section-header-button">
        <a href="{{ route('customers.create')}}" class="btn btn-primary btn-icon icon-right">Create New <i class="fas fa-plus"></i></a>
    </div>
  </div>
  <div class="section-body">
    @alert
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Customers</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>No</th><th> Name</th>
<th> Username</th>
<th> Remember Token</th>
<th> Email</th>
<th> Roles</th>
<th> Address</th>
<th> Phone</th>
<th> Avatar</th>
<th> Status</th>
<th> orders</th>

                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ str_limit($customer->name, $limit = 50, $end ="...") }}</td>
<td>{{ str_limit($customer->username, $limit = 50, $end ="...") }}</td>
<td>{{ str_limit($customer->remember_token, $limit = 50, $end ="...") }}</td>
<td>{{ str_limit($customer->email, $limit = 50, $end ="...") }}</td>
<td>{{ str_limit($customer->roles, $limit = 50, $end ="...") }}</td>
<td>{{ str_limit($customer->address, $limit = 50, $end ="...") }}</td>
<td>{{ str_limit($customer->phone, $limit = 50, $end ="...") }}</td>

                <td>
                    <img src="{{ asset($customer->avatar ) }}" alt="" width="50" height="50">
                </td>
<td>{{ str_limit($customer->status, $limit = 50, $end ="...") }}</td>
<td><button type="button" class="btn btn-info" id="btnorders" data-relation ="orders" onclick="showRelation({{ $customer->id }}, 'customer','orders')">Show orders</button></td>

                                    <td class="text-right">
                                        <a class="btn btn-primary" href="{{ route('customers.edit', $customer->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @deletebutton([
                                            'id' => $customer->id,
                                            'route' => route('customers.destroy', $customer->id)
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
                    {{ $customers->links() }}
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
