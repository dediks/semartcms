@extends('layouts.app')

@section('title', 'Manage {display_name}')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Comments</h1>
    <div class="section-header-button">
        <a href="{{ route('comments.create')}}" class="btn btn-primary btn-icon icon-right">Create New <i class="fas fa-plus"></i></a>
    </div>
  </div>
  <div class="section-body">
    @alert
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Comments</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th> Nomor</th>

                                </tr>
                                @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $comment->nomor }}</td>

                                    <td class="text-right">
                                        <a class="btn btn-primary" href="{{ route('comments.edit', $comment->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @deletebutton([
                                            'id' => $comment->id,
                                            'route' => route('comments.destroy', $comment->id)
                                        ])
                                            <i class="fa fa-trash"></i>
                                        @enddeletebutton
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
@endsection
