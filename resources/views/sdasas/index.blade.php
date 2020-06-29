@extends('layouts.app')

@section('title', 'Manage {display_name}')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Sdasas</h1>
    <div class="section-header-button">
        <a href="{{ route('sdasas.create')}}" class="btn btn-primary btn-icon icon-right">Create New <i class="fas fa-plus"></i></a>
    </div>
  </div>
  <div class="section-body">
    @alert
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Sdasas</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th> Field Name</th>
<th> Field Name</th>

                                </tr>
                                @foreach($sdasas as $sdasas)
                                <tr>
                                    <td>{{ $sdasas->field_name }}</td>
<td>{{ $sdasas->field_name }}</td>

                                    <td class="text-right">
                                        <a class="btn btn-primary" href="{{ route('sdasas.edit', $sdasas->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @deletebutton([
                                            'id' => $sdasas->id,
                                            'route' => route('sdasas.destroy', $sdasas->id)
                                        ])
                                            <i class="fa fa-trash"></i>
                                        @enddeletebutton
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $sdasas->links() }}
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
@endsection
