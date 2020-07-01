@extends('layouts.app')

@section('title', 'Manage {display_name}')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Phones</h1>
    <div class="section-header-button">
        <a href="{{ route('phones.create')}}" class="btn btn-primary btn-icon icon-right">Create New <i class="fas fa-plus"></i></a>
    </div>
  </div>
  <div class="section-body">
    @alert
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Phones</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th> Nomor</th>

                                </tr>
                                @foreach($phones as $phone)
                                <tr>
                                    <td>{{ $phone->nomor }}</td>

                                    <td class="text-right">
                                        <a class="btn btn-primary" href="{{ route('phones.edit', $phone->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @deletebutton([
                                            'id' => $phone->id,
                                            'route' => route('phones.destroy', $phone->id)
                                        ])
                                            <i class="fa fa-trash"></i>
                                        @enddeletebutton
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $phones->links() }}
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
@endsection
