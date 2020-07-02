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
                                    <th> Username</th>
<th> Remember Token</th>
<th> Email</th>
<th> Password</th>
<th> Name</th>
<th> Address</th>
<th> Phone</th>
<th> Avatar</th>

                                </tr>
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $customer->username }}</td>
<td>{{ $customer->remember_token }}</td>
<td>{{ $customer->email }}</td>
<td>{{ $customer->password }}</td>
<td>{{ $customer->name }}</td>
<td>{{ $customer->address }}</td>
<td>{{ $customer->phone }}</td>
<td>{{ $customer->avatar }}</td>

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
@endsection
