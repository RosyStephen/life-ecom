$(document).ready(function() {

    $('.roleModal').click(function(e) {
        e.preventDefault();

        $('#open-roleModal').offcanvas('show');
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

    loadroleList();
});

function submitForm() {
    var data = $('#role_form').serialize();
    let url = '/user-roles';
    if ($('#roleId').val()) {
        url += '/' + $('#roleId').val();
        data += '&_method=PUT';
    }
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) {

                $('#open-roleModal').offcanvas('hide');

                if (response.success) {
                    toastr.success(response.success);
                    loadroleList();
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


    let deleteUrl = `/user-roles/${id}`;

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
                    toastr.success(response.success || 'Role deleted successfully!');
                    loadroleList();
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.error || 'An error occurred!');
                }
            });
        }
    });
}

$('#open-roleModal').on('hidden.bs.offcanvas', function () {
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();
     $('#role_form')[0].reset(); // Reset the form
    $('#modalTitle').text('Add Role'); // Reset the modal title
    $('#role_form').attr('action', '{{ url("user-roles") }}'); // Reset the form action to "Add"
    $('#role_form').attr('method', 'POST');
    $('#roleId').val('');
    $('#submit_form').text('Save changes');
});

function editForm(id) {

    let editUrl = `/user-roles/${id}/edit`;
// Fetch category data via AJAX
$.ajax({
    url: editUrl,
    type: 'GET',
    success: function(response) {
        let role = response.data;
        let hasPermissions = response.hasPermissions;

        // Populate the modal with the fetched data
        $('#modalTitle').text('Edit Role');
        $('#roleId').val(role.id);

        $('#name').val(role.name);



        // Change form action
        $('#role_form').attr('action', `/user-roles/${role.id}`);
        $('#role_form').attr('method', 'POST');
        $('#submit_form').text('Update');

        // Check permissions
        if (hasPermissions && Array.isArray(hasPermissions)) {

            $('.permission-checkbox').each(function () {
                let permissionId = $(this).val(); // Get checkbox value (permission ID)

                if (hasPermissions.includes(parseInt(permissionId))) {

                    $(this).prop('checked', true); // Check if assigned
                } else {
                    $(this).prop('checked', false); // Ensure unchecked if not assigned
                }
            });
        }
        // Show the modal
        $('#open-roleModal').offcanvas('show');
    },
    error: function(xhr) {
        console.log(xhr.responseText);
    }
});

}

function loadroleList() {
    if ($.fn.DataTable.isDataTable('#role-table')) {
        $('#role-table').DataTable().clear().destroy();
    }

    $('#role-table').DataTable({
        processing: true,
        serverSide: true,

        ajax: '/user-roles',

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'permissions', name: 'permissions', width: '200px' },  // ✅ Sets fixed width
            { data: 'created_at', name: 'created_at', width: '150px' },
            { data: 'action', name: 'action', orderable: false, searchable: false, width: '150px' }
        ],

        columnDefs: [
            { targets: 2, render: function (data) {
                return data.length > 50 ? data.substring(0, 50) + '...' : data; // ✅ Limits long text
            }}
        ]
    });
}
