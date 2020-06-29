@extends('layouts.app')

@section('title', 'Manage {display_name}')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Categories</h1>
    <div class="section-header-button">
        <a href="{{ route('categories.create')}}" class="btn btn-primary btn-icon icon-right">Create New <i class="fas fa-plus"></i></a>
    </div>
  </div>
  <div class="section-body">
    @alert
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Categories</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th> Name</th>
<th> Slug</th>

                                </tr>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
<td>{{ $category->slug }}</td>

                                    <td class="text-right">
                                        <a class="btn btn-primary" href="{{ route('categories.edit', $category->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @deletebutton([
                                            'id' => $category->id,
                                            'route' => route('categories.destroy', $category->id)
                                        ])
                                            <i class="fa fa-trash"></i>
                                        @enddeletebutton
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
@endsection
