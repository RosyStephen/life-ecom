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
                <h4 class="mb-sm-0 font-size-18">Order</h4>



            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="card-title-desc">Orders</p>
                    <table id="Orders-table" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>

                                <th>User Name</th>
                                <th>User Email</th>
                                <th>Total Price</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>status</th>
                                <th>Created At</th>

                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>


                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
</div>

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

<script src="{{ asset('/js/order/order.js') }}"></script>
@endpush




