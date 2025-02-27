@extends('layouts.app')

@push('styles')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endpush
@section('content')

<div class="page-content">
    <div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Permission</h4>

                <div class="page-title-right">
                    <button type="button" class="btn btn-primary waves-effect waves-light permissionModal">
                        <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Permission
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="card-title-desc">User Permission</p>

                    @include('users.permissions.list')

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
</div>
@include('users.permissions.form')
@endsection
@push('scripts')
 <!-- Required datatable js -->
 <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

 <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
 <!-- Buttons examples -->
 <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
 <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
 <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
 <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
 <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
 <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>


 <!-- Datatable init js -->
 <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

<script src="{{ asset('/js/permission/permission.js') }}"></script>
@endpush


