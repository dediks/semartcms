@extends('layouts.app-index')

@section('title', 'Manage Categories')

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
                                    <th>No</th><th> Name</th>
<th> books</th>

                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($categories as $category)
                                <tr>
                                    <td class="text-center align-middle"><input type="checkbox" class="form-check-input" id="checkbox_$categories" name="cb_$categories[]"></td>
                                    <td>{{ str_limit($category->name, $limit = 50, $end ="...") }}</td>
<td><button type="button" class="btn btn-info" id="btnbooks" data-relation ="books" onclick="showRelation({{ $category->id }}, 'category','books','belongsToMany')">Show books</button></td>

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
                                @php
                                    $no++;
                                @endphp
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

