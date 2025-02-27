@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Keevee</h4>

                        <div class="page-title-right">
                            {{-- <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Saas</li>
                            </ol> --}}
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

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
                                                <p class="mb-2">Welcome to Keevee Ecom Dashboard</p>
                                                <h5 class="mb-1">{{Auth::user()->name}}</h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 align-self-center">
                                    <div class="text-lg-center mt-4 mt-lg-0">
                                        <div class="row">
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Projects</p>
                                                    <h5 class="mb-0">48</h5>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Projects</p>
                                                    <h5 class="mb-0">40</h5>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Clients</p>
                                                    <h5 class="mb-0">18</h5>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="clearfix mt-4 mt-lg-0">
                                        <div class="dropdown float-end">
                                            <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bxs-cog align-middle me-1"></i> Setting
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else</a>
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
            <!-- end row -->

            <div class="row">
                <div class="col-xl-4">
                    <div class="card bg-primary bg-soft">
                        <div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>Email Keevee Ecom Dashboard</p>

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
                <div class="col-xl-8 d-none">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bx-copy-alt"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Orders</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>1,452 <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                        <div class="d-flex">
                                            <span class="badge badge-soft-success font-size-12"> + 0.2% </span> <span class="ms-2 text-truncate">From previous period</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bx-archive-in"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Revenue</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>$ 28,452 <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                        <div class="d-flex">
                                            <span class="badge badge-soft-success font-size-12"> + 0.2% </span> <span class="ms-2 text-truncate">From previous period</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bx-purchase-tag-alt"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Average Price</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>$ 16.2 <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>

                                        <div class="d-flex">
                                            <span class="badge badge-soft-warning font-size-12"> 0% </span> <span class="ms-2 text-truncate">From previous period</span>
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

@endsection
