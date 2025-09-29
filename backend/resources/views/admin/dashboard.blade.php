@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('content')
    {{-- <div class="container-fluid"> --}}
        <div class="row">
           @include('admin.layouts.sidebar')
            <div class="col-md-9">
              <div class="row mt-2">
                <div class="card-header bg-white">
                    <h3 class="mt-2">Dashboard</h3>
                    <hr>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="badge bg-dark text-white p-2 rounded">
                                            {{-- <i class="fa-solid fa-tag fa-1x"></i> --}}
                                            Today Oreder
                                        </strong>
                                        <span class="badge bg-dark text-white p-2 rounded">
                                            {{ $todayOrders->count() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-white">
                                    <strong class="badge bg-dark text-white p-2 rounded">
                                        ${{ $todayOrders->sum('total') }} 
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="badge bg-primary text-white p-2 rounded">
                                            {{-- <i class="fa-solid fa-tag fa-1x"></i> --}}
                                            Yesterday Oreder
                                        </strong>
                                        <span class="badge bg-primary text-white p-2 rounded">
                                            {{ $yesterdayOrders->count() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-white">
                                    <strong class="badge bg-primary text-white p-2 rounded">
                                        ${{ $yesterdayOrders->sum('total') }} 
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="badge bg-danger text-white p-2 rounded">
                                            {{-- <i class="fa-solid fa-tag fa-1x"></i> --}}
                                            This Month Oreder
                                        </strong>
                                        <span class="badge bg-danger text-white p-2 rounded">
                                            {{ $monthOrders->count() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-white">
                                    <strong class="badge bg-danger text-white p-2 rounded">
                                        ${{ $monthOrders->sum('total') }} 
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="badge bg-success text-white p-2 rounded">
                                            <i class="fa-solid fa-tag fa-1x"></i>
                                            This Year Order
                                        </strong>
                                        <span class="badge bg-success text-white p-2 rounded">
                                            {{ $yearOrders->count() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-white">
                                    <strong class="badge bg-success text-white p-2 rounded">
                                        ${{ $yearOrders->sum('total') }} 
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    {{-- </div> --}}
@endsection