/*
Example:
var dataTable = initDataTables('table-1', 'loader-category', 'card-category', 'new-record-button', false,
    'News', "{{ route('admin.category.data') }}",
    [{
            data: "name",
            name: "name",
            className: "align-middle",
        },
        {
            data: "description",
            name: "description",
            className: "align-middle",
        },
        {
            data: "action",
            name: "action",
            className: "align-middle",
            searchable: false,
            orderable: false,
        },
    ]
);
*/

function initDataTables(
    tableId,
    title,
    url,
    columns,
    params = false,
    saveState = false,
    orderBy = 0
) {
    var initColumns = [];

    var datatable = $(tableId).DataTable({
        // responsive: true,
        dom: "rt<'d-flex justify-content-end m-3 align-items-center'l p><'d-flex justify-content-between m-3'iB>",
        autoWidth: false,
        processing: true,
        serverSide: true,
        order: [orderBy, "desc"],
        saveState: saveState,
        search: {
            return: true,
        },
        ajax: {
            url: url,
            data: function (d) {
                if (params) {
                    params.forEach((item) => {
                        Object.keys(item).forEach((key) => {
                            let selector = item[key];
                            d[key] = $(selector).val();
                        });
                    });
                }
            },
        },
        deferRender: true,
        buttons: [
            {
                extend: "copy",
                exportOptions: {
                    columns: [1, 2, 3, 4, 5], // Skip checkbox and action columns
                },
                action: function () {
                    exportAllDataTable("copy", tableId, title);
                },
            },
            {
                extend: "excel",
                title: title,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5],
                },
                action: function () {
                    exportAllDataTable("excel", tableId, title);
                },
            },
            {
                extend: "csv",
                title: title,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5],
                },
                action: function () {
                    exportAllDataTable("csv", tableId, title);
                },
            },
            {
                extend: "pdf",
                title: title,
                orientation: "landscape",
                exportOptions: {
                    columns: [1, 2, 3, 4, 5],
                },
                action: function () {
                    exportAllDataTable("pdf", tableId, title);
                },
            },
        ],
        columns: [...initColumns, ...columns],
    });
    return datatable;
}
