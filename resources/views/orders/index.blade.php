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
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th> Total Price</th>
<th> Invoice Number</th>
<th> Status</th>

                                </tr>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->total_price }}</td>
<td>{{ $order->invoice_number }}</td>
<td>{{ $order->status }}</td>

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
@endsection
