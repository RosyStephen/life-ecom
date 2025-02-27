$(document).ready(function() {

    $('.permissionModal').click(function(e) {
        e.preventDefault();

        $('#open-permissionModal').modal('show');
    });

    $('#submit_form').click(function(e) {
        e.preventDefault();
        submitForm();
    });
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
          deleteForm(id);
      });
      $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');

        editForm(id);
    });

    loadpermissionList();
});

function submitForm() {
    var data = $('#permission_form').serialize();
    let url = '/user-permissions';
    if ($('#permissionId').val()) {
        url += '/' + $('#permissionId').val();
        data += '&_method=PUT';
    }
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) {

                $('#open-permissionModal').modal('hide');

                if (response.success) {
                    toastr.success(response.success);
                    loadpermissionList();
                } else {
                    toastr.error('An unexpected error occurred.');
                }

        },
        error: function(xhr) {
            if (xhr.status === 400) { // Custom error
                toastr.error(xhr.responseJSON.error); // Show the custom error message
            } else if (xhr.status === 422) { // Laravel validation error
                    let errors = xhr.responseJSON.errors;

                    // Clear previous errors
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    // Loop through errors and display them
                    for (let field in errors) {
                        let inputField = $(`[name="${field}"]`);
                        inputField.addClass('is-invalid'); // Highlight the field
                        inputField.after(
                            `<div class="invalid-feedback">${errors[field][0]}</div>` // Show error message
                        );
                    }
                }
        }
    });
}


function deleteForm(id) {


    let deleteUrl = `/user-permissions/${id}`;

    swal({
        title: "Are you sure?",
        text: "You won't be able to undo this action!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // Securely fetch CSRF token
                },
                success: function (response) {
                    toastr.success(response.success || 'Permissions deleted successfully!');
                    loadpermissionList();
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.error || 'An error occurred!');
                }
            });
        }
    });
}

$('#open-permissionModal').on('hidden.bs.modal', function () {
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();
     $('#permission_form')[0].reset(); // Reset the form
    $('#permissionTitle').text('Add Permission'); // Reset the modal title
    $('#permission_form').attr('action', '{{ url("user-permissions") }}'); // Reset the form action to "Add"
    $('#permission_form').attr('method', 'POST');
    $('#permissionId').val('');
    $('#submit_form').text('Save changes');
});

function editForm(id) {

    let editUrl = `/user-permissions/${id}/edit`;
// Fetch category data via AJAX
$.ajax({
    url: editUrl,
    type: 'GET',
    success: function(response) {
        let Permission = response.data;
        // Populate the modal with the fetched data
        $('#permissionTitle').text('Edit Permission');
        $('#permissionId').val(Permission.id);

        $('#name').val(Permission.name);


        // Change form action
        $('#permission_form').attr('action', `/user-permissions/${Permission.id}`);
        $('#permission_form').attr('method', 'POST');
        $('#submit_form').text('Update');

        // Show the modal
        $('#open-permissionModal').modal('show');
    },
    error: function(xhr) {
        console.log(xhr.responseText);
    }
});

}


function loadpermissionList() {

    if ($.fn.DataTable.isDataTable('#permission-table')) {
        $('#permission-table').DataTable().clear().destroy();
    }
    $('#permission-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/user-permissions', // Fetch data via AJAX


        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },

            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
}
