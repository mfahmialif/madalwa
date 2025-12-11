// Function to export all data from server-side DataTable
function exportAllDataTable(method = "excel", tableId, title) {
    const dt = $("#" + tableId).DataTable();
    const pageSize = 500;
    let start = 0;
    let allData = [];

    // Show loading indicator
    toastr.info("Mengambil semua data untuk export... Mohon tunggu.", {
        timeOut: 0,
        extendedTimeOut: 0,
    });

    function fetchDataPart() {
        return $.ajax({
            url: dt.ajax.url(),
            type: "GET",
            data: $.extend({}, dt.ajax.params(), {
                start: start,
                length: pageSize,
            }),
        });
    }

    function loopFetch() {
        fetchDataPart()
            .done(function (json) {
                if (!json || !json.data || json.data.length === 0) {
                    return finishExport();
                }

                allData = allData.concat(json.data);
                start += pageSize;

                // Update loading message
                toastr.clear();
                toastr.info(
                    "Mengambil data... (" + allData.length + " records)",
                    {
                        timeOut: 0,
                        extendedTimeOut: 0,
                    }
                );

                // Continue fetching next batch
                if (json.data.length === pageSize) {
                    loopFetch();
                } else {
                    finishExport();
                }
            })
            .fail(function () {
                toastr.clear();
                toastr.error("Gagal mengambil data untuk export");
            });
    }

    function finishExport() {
        toastr.clear();
        toastr.info("Memproses export...", {
            timeOut: 0,
            extendedTimeOut: 0,
        });

        const excludeColumn = ["", "no", "id", "action", "aksi"];

        // Create temporary table
        let $tempTable = $("<table>");
        let thead = $("<thead>").appendTo($tempTable);
        let tr = $("<tr>").appendTo(thead);
        dt.columns(":visible").every(function () {
            let textHeader = this.header().innerText;
            if (excludeColumn.includes(textHeader.toLowerCase())) return;
            $("<th>").text(this.header().innerText).appendTo(tr);
        });

        let tbody = $("<tbody>").appendTo($tempTable);

        for (let row of allData) {
            let $row = $("<tr>").appendTo(tbody);

            dt.columns(":visible").every(function () {
                const colKey = this.dataSrc(); // ambil key field
                if (excludeColumn.includes(colKey)) return;

                const raw = row[colKey] ?? "";

                // Optional: hilangkan tag/avatar kalau perlu
                const tempDiv = $("<div>").html(raw);
                $row.append($("<td>").text(tempDiv.text()));
            });
        }

        $tempTable.appendTo("body");

        // Initialize DataTable on temporary table for export
        $tempTable.DataTable({
            dom: "Bfrtip",
            buttons: [
                {
                    extend: method,
                    title: title,
                    exportOptions: {
                        columns: ":visible",
                    },
                    customize:
                        method === "pdf"
                            ? function (doc) {
                                  const colCount =
                                      doc.content[1].table.body[0].length;
                                  doc.content[1].table.widths =
                                      Array(colCount).fill("*");

                                  doc.content[1].layout = {
                                      hLineWidth: function () {
                                          return 0.5;
                                      },
                                      vLineWidth: function () {
                                          return 0.5;
                                      },
                                      hLineColor: function () {
                                          return "#000";
                                      },
                                      vLineColor: function () {
                                          return "#000";
                                      },
                                  };
                              }
                            : undefined,
                },
            ],
            paging: false,
            ordering: false,
            searching: false,
            destroy: true,
            initComplete: function () {
                const api = this.api();
                api.buttons(0, 0).trigger();

                setTimeout(() => {
                    api.destroy();
                    $tempTable.remove();
                    toastr.clear();
                    toastr.success(
                        "Export berhasil! Total: " + allData.length + " records"
                    );
                }, 1000);
            },
        });
    }

    // Start the fetching process
    loopFetch();
}

if ($("#table1").length > 0) {
    // Connect custom buttons to DataTable buttons
    let pageTitle = $(".doctor-table-blk h3").text().trim();
    $("#btn-copy").on("click", function () {
        exportAllDataTable("copy", "table1", pageTitle);
    });

    $("#btn-excel").on("click", function () {
        exportAllDataTable("excel", "table1", pageTitle);
    });

    $("#btn-csv").on("click", function () {
        exportAllDataTable("csv", "table1", pageTitle);
    });

    $("#btn-pdf").on("click", function () {
        exportAllDataTable("pdf", "table1", pageTitle);
    });
} else {
    let pageTitle = $(".doctor-table-blk h3").text().trim();
    let tableIdDatatable = $(".table-responsive").find("table").attr("id");
    $("#btn-copy").on("click", function () {
        exportAllDataTable("copy", tableIdDatatable, pageTitle);
    });

    $("#btn-excel").on("click", function () {
        exportAllDataTable("excel", tableIdDatatable, pageTitle);
    });

    $("#btn-csv").on("click", function () {
        exportAllDataTable("csv", tableIdDatatable, pageTitle);
    });

    $("#btn-pdf").on("click", function () {
        exportAllDataTable("pdf", tableIdDatatable, pageTitle);
    });
}
