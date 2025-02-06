$(document).ready(function () {
    var table = $('#topic-blocks-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: TOPIC_BLOCK_URL,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'topic', name: 'topic' },
            { data: 'block_type', name: 'block_type' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: '<"row"<"col-sm-12"tr>>' +
            '<"row align-items-center justify-content-center"<"col-sm-4"l><"col-sm-4 text-center"i><"col-sm-4"p>>',
        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
        pageLength: 10
    });

    // Search functionality
    $('#searchTableList').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Delete functionality
    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');
        var deleteUrl = DELETE_URL.replace(':id', id);

        if (confirm("Are you sure you want to delete this topic block?")) {
            $.ajax({
                type: "DELETE",
                url: deleteUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    table.ajax.reload();
                    toastr.success(response.success);
                },
                error: function () {
                    toastr.error('Error deleting topic block');
                }
            });
        }
    });
});
