$(document).ready(function() {

    $('.userModal').click(function(e) {
        e.preventDefault();

        $('#open-userModal').offcanvas('show');
    });

    $(document).on('click', '.pwd-btn', function (e) {
        e.preventDefault();
        let id = $(this).data('id');

        $('#open-passwordModal').offcanvas('show');
        $('#password_change_form').attr('data-id', id); // Store ID in the form
    });

    $('#passsword_submit_form').click(function (e) {
        e.preventDefault();
        passwordSubmitForm();
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

    loaduserList();
});

function submitForm() {
    var data = $('#user_form').serialize();
    let url = '/users';
    if ($('#userId').val()) {
        url += '/' + $('#userId').val();
        data += '&_method=PUT';
    }
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) {

                $('#open-userModal').offcanvas('hide');

                if (response.success) {
                    toastr.success(response.success);
                    loaduserList();
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


    let deleteUrl = `/users/${id}`;

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
                    toastr.success(response.success);
                    loaduserList();
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.error || 'An error occurred!');
                }
            });
        }
    });
}

$('#open-userModal').on('hidden.bs.offcanvas', function () {
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();
     $('#user_form')[0].reset(); // Reset the form
    $('#modalTitle').text('Add User'); // Reset the modal title
    $('#user_form').attr('action', '{{ url("users") }}'); // Reset the form action to "Add"
    $('#user_form').attr('method', 'POST');
    $('#userId').val('');
    $('#submit_form').text('Save changes');
    $('#password').closest('.form-group').show(); // Show the password field



});

function editForm(id) {

    let editUrl = `/users/${id}/edit`;
// Fetch category data via AJAX
$.ajax({
    url: editUrl,
    type: 'GET',
    success: function(response) {
        let user = response.data;
        let hasRoles = response.hasRoles;


        // Populate the modal with the fetched data
        $('#modalTitle').text('Edit User');
        $('#userId').val(user.id);
           $('#name').val(user.name);
           $('#email').val(user.email);

           if ($('#userId').val()) {
          $('#password').closest('.form-group').hide(); // Hide the password field
        }

        // Change form action
        $('#user_form').attr('action', `/users/${user.id}`);
        $('#user_form').attr('method', 'POST');
        $('#submit_form').text('Update');

        if (hasRoles && Array.isArray(hasRoles)) {
            $('.role-select').each(function () {
            let roleId = $(this).val(); // Get select option value (role ID)
            if (hasRoles.includes(parseInt(roleId))) {
                $(this).prop('selected', true); // Select if assigned
            } else {
                $(this).prop('selected', false); // Ensure unselected if not assigned
            }
            });
        }
        // Show the modal
        $('#open-userModal').offcanvas('show');
    },
    error: function(xhr) {
        console.log(xhr.responseText);
    }
});

}

function passwordSubmitForm() {
    let id = $('#password_change_form').attr('data-id'); // Get ID from form
    let url = `/change-password/${id}`;
    let data = $('#password_change_form').serialize();

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (response) {
            $('#open-passwordModal').modal('hide');

            if (response.success) {
                toastr.success(response.success);
                loaduserList();
            } else {
                toastr.error('An unexpected error occurred.');
            }
        },
        error: function (xhr) {
            if (xhr.status === 400) {
                toastr.error(xhr.responseJSON.error);
            } else if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                for (let field in errors) {
                    let inputField = $(`[name="${field}"]`);
                    inputField.addClass('is-invalid');
                    inputField.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                }
            }
        }
    });
}

$('#open-passwordModal').on('hidden.bs.modal', function () {
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();
     $('#password_change_form')[0].reset(); // Reset the form

    $('#password_change_form').attr('action', '{{ url(`/change-password/${id}`) }}'); // Reset the form action to "Add"
    $('#password_change_form').attr('method', 'POST');
    $('#password_change_form').attr('data-id', ''); // Reset the form action to "Add"
    $('#passsword_submit_form').text('Confirm');




});

function loaduserList() {
    if ($.fn.DataTable.isDataTable('#user-table')) {
        $('#user-table').DataTable().clear().destroy();
    }

    $('#user-table').DataTable({
        processing: true,
        serverSide: true,

        ajax: '/users',

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },

            { data: 'roles', name: 'roles' },
            { data: 'created_at', name: 'created_at', width: '150px' },

            { data: 'action', name: 'action', orderable: false, searchable: false, width: '150px' }
        ],


    });
}
