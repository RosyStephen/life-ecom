
$(document).ready(function() {
loadcategoryList();
});


function loadcategoryList() {

    if ($.fn.DataTable.isDataTable('#category-table')) {
        $('#category-table').DataTable().clear().destroy();
    }
    $('#category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/category', // Fetch data via AJAX


        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'status', name: 'status' },


            { data: 'created_at', name: 'created_at' },

        ]
    });
}
