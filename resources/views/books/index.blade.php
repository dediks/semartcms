@extends('layouts.app')

@section('title', 'Manage {display_name}')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Books</h1>
    <div class="section-header-button">
        <a href="{{ route('books.create')}}" class="btn btn-primary btn-icon icon-right">Create New <i class="fas fa-plus"></i></a>
    </div>
  </div>
  <div class="section-body">
    @alert
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Books</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th> Judul</th>
<th> Harga</th>
<th> Deskripsi</th>

                                </tr>
                                @foreach($books as $book)
                                <tr>
                                    <td>{{ $book->judl }}</td>
<td>{{ $book->harga }}</td>
<td>{{ $book->deskripsi }}</td>

                                    <td class="text-right">
                                        <a class="btn btn-primary" href="{{ route('books.edit', $book->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @deletebutton([
                                            'id' => $book->id,
                                            'route' => route('books.destroy', $book->id)
                                        ])
                                            <i class="fa fa-trash"></i>
                                        @enddeletebutton
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
@endsection
