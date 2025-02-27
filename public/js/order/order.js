$(document).ready(function() {
    loadorderList();
    });


    function loadorderList() {

        if ($.fn.DataTable.isDataTable('#order-table')) {
            $('#order-table').DataTable().clear().destroy();
        }
        $('#order-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/order', // Fetch data via AJAX


            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'customer_email', name: 'customer_email' },
                { data: 'total_items', name: 'total_items' },
                { data: 'total_price', name: 'total_price' },
                { data: 'payment_method', name: 'payment_method' },
                { data: 'payment_status', name: 'payment_status' },
                { data: 'status', name: 'status' },
                { data: 'shipping_address', name: 'shipping_address' },
                { data: 'created_at', name: 'created_at' },

            ]
        });
    }
