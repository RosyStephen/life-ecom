@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Life-Ecom</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->
            @if(auth()->check() && auth()->user()->hasRole('admin'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <img src="{{ asset('assets/images/users/default-user.webp') }}" alt="" class="avatar-md rounded-circle img-thumbnail">
                                        </div>
                                        <div class="flex-grow-1 align-self-center">
                                            <div class="text-muted">
                                                <p class="mb-2">Welcome to  Life-Ecom</p>
                                                @if(auth()->check())
                                                <h5 class="mb-1">{{auth()->user()->name}}</h5>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 align-self-center">
                                    <div class="text-lg-center mt-4 mt-lg-0">
                                        <div class="row">
                                            <div class="col-4">
                                                <div>
                                                    @if($productsCount > 0)
                                                        <p class="text-muted text-truncate mb-2">Total Products</p>
                                                        <h5 class="mb-0">{{$productsCount}}</h5>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div>
                                                    @if($ordersCount > 0)
                                                        <p class="text-muted text-truncate mb-2">Total Orders</p>
                                                        <h5 class="mb-0">{{$ordersCount}}</h5>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div>
                                                    @if($usersCount > 0)
                                                        <p class="text-muted text-truncate mb-2">Customers</p>
                                                        <h5 class="mb-0">{{$usersCount}}</h5>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-xl-4">
                <div class="card bg-primary bg-soft">
                    <div>
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>Life-Ecom Customer Dashboard</p>

                                    <ul class="ps-3 mb-0">
                                        <li class="py-1">7 + Layouts</li>
                                        <li class="py-1">Multiple apps</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('assets/images/users/default-user.webp') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- end row -->


        </div>
</div>

@endsection
