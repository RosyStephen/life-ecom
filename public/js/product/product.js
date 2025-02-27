$(document).ready(function() {
    loadproductList();
    });


    function loadproductList() {

        if ($.fn.DataTable.isDataTable('#product-table')) {
            $('#product-table').DataTable().clear().destroy();
        }
        $('#product-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/product', // Fetch data via AJAX


            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'slug', name: 'slug' },
                { data: 'description', name: 'description' },
                { data: 'price', name: 'price' },
                { data: 'stock_quantity', name: 'stock_quantity' },
                { data: 'images', name: 'images' },
                { data: 'status', name: 'status' },


                { data: 'created_at', name: 'created_at' },

            ]
        });
    }
