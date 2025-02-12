$(document).ready(function () {
    var table = $('#topics-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: TOPIC_URL,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'version', name: 'version' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        // Add dom option to customize layout
        dom: '<"row"<"col-sm-12"tr>>' +
        '<"row align-items-center justify-content-center"<"col-sm-4"l><"col-sm-4 text-center"i><"col-sm-4"p>>',
        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Define entries options
        pageLength: 10 // Default page size
    });

     // Search functionality
     $('#searchTableList').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Delete functionality
    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');
        var deleteUrl = DELETE_URL.replace(':id', id);

        if (confirm("Are you sure you want to delete this topic?")) {
            $.ajax({
                type: "DELETE",
                url: deleteUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    table.ajax.reload(); // Reload table after deletion
                    toastr.success(response.success);
                },
                error: function () {
                    toastr.error('Error deleting topic');
                }
            });
        }
    });
});
