$(document).ready(function () {
    var table = $('#versions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_BACKEND_URL + '/version',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'identifier', name: 'identifier' },
            { data: 'description', name: 'description' },
            { data: 'notes', name: 'notes' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Delete functionality
    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete this version?")) {
            $.ajax({
                type: "DELETE",
                url: APP_BACKEND_URL + "/version/" + id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    table.ajax.reload(); // Reload table after deletion
                    toastr.success(response.success);
                },
                error: function () {
                    toastr.error('Error deleting version');
                }
            });
        }
    });
});
