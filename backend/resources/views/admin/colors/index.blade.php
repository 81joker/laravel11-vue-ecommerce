@extends('admin.layouts.app')
@section('title', 'Colors')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.layouts.sidebar')
            <div class="col-md-9">
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h3 class="mt-2">Colors {{ $colors->count() }}</h3>
                            <a href="{{ route('admin.colors.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i></a>
                        </div>
                        <hr>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($colors as $color)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="d-flex align-items-center">
                                                <span
                                                    style="display:inline-block; width:30px; height:30px; 
                                                     border-radius:5px; background-color: {{ $color->name }}; margin-right:10px;">
                                                </span>
                                               <strong> {{ $color->name }}</strong>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.colors.edit', $color->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" onclick="deleteItem({{ $color->id }})"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <form id="{{ $color->id }}"
                                                    action="{{ route('admin.colors.destroy', $color->id) }}" method="post">
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
