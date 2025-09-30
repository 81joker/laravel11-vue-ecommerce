@extends('admin.layouts.app')
@section('title', 'Brands')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.layouts.sidebar')
            <div class="col-md-9">
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h3 class="mt-2">Brands {{ $brands->count() }}</h3>
                            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i></a>
                        </div>
                        <hr>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->slug }}</td>
                                            <td>{{ $brand->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.brands.edit', $brand->slug) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" onclick="deleteItem({{ $brand->id }})"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <form id="{{ $brand->id }}"
                                                    action="{{ route('admin.brands.destroy', $brand->slug) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
