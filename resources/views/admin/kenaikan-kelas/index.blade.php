@extends('layouts.admin.template')
@section('title', 'Kenaikan Kelas')
@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home </a></li>
                <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                <li class="breadcrumb-item active">Kenaikan Kelas</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-sm-12">

        <div class="alert alert-primary mb-4" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Informasi Kenaikan Kelas:</strong><br>
            - Siswa akan dinaikkan ke kelas berikutnya (angka kelas + 1) di unit yang sama<br>
            - Jika kelas tujuan belum tersedia, silakan tambahkan kelas terlebih dahulu<br>
            - Anda dapat menaikkan siswa secara individual atau batch menggunakan checkbox
        </div>

        <div class="row">
            <div class="col-12 col-md-3">
                <div class="input-block local-forms">
                    <select class="form-control select2 filter-dt" id="filter_tahun_pelajaran_id">
                        <option value="">Semua Tahun Pelajaran</option>
                        @foreach ($tahunPelajaran as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama }} {{ $item->semester }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="input-block local-forms">
                    <select class="form-control select2 filter-dt" id="filter_unit_sekolah_id">
                        <option value="">Semua Unit Sekolah</option>
                        @foreach ($unitSekolah as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_unit }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="input-block local-forms">
                    <select class="form-control select2 filter-dt" id="filter_kelas_id">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelas as $item)
                        <option value="{{ $item->id }}">
                            Kelas {{ $item->angka }} - {{ $item->unitSekolah->nama_unit }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="input-block local-forms">
                    <select class="form-control select2 filter-dt" id="filter_jenis_kelamin">
                        <option value="">Semua Jenis Kelamin</option>
                        @foreach ($jenisKelamin as $item)
                        <option value="{{ $item }}">
                            {{ $item }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card card-table show-entire">
            <div class="card-body">
                <!-- Table Header -->
                <div class="page-table-header mb-2">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="doctor-table-blk">
                                <h3><i class="fas fa-graduation-cap me-2"></i>Data Siswa - Kenaikan Kelas</h3>
                                <div class="doctor-search-blk mt-3 mt-md-0">
                                    <div class="top-nav-search table-search-blk">
                                        <form onsubmit="event.preventDefault(); searchDataTable('#table1');">
                                            <input type="text" class="form-control" id="search-table" oninput="searchDataTable('#table1')" placeholder="Cari siswa...">
                                            <a class="btn"><img src="{{ asset('template') }}/assets/img/icons/search-normal.svg" alt=""></a>
                                        </form>
                                    </div>
                                    <div class="add-group">
                                        <a href="javascript:void(0);" onclick="searchDataTable('#table1', true)" class="btn btn-primary doctor-refresh ms-2">
                                            <img src="{{ asset('template') }}/assets/img/icons/re-fresh.svg" alt="">
                                        </a>
                                        <button class="btn btn-success ms-2" onclick="naikkanKelasBatch()">
                                            <i class="fas fa-arrow-up me-1"></i> Naikkan Batch
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end float-end ms-auto download-grp">
                            <a href="javascript:;" id="btn-pdf" class=" me-2"><img src="{{ asset('template') }}/assets/img/icons/pdf-icon-01.svg" alt=""></a>
                            <a href="javascript:;" id="btn-copy" class=" me-2"><img src="{{ asset('template') }}/assets/img/icons/pdf-icon-02.svg" alt=""></a>
                            <a href="javascript:;" id="btn-csv" class=" me-2"><img src="{{ asset('template') }}/assets/img/icons/pdf-icon-03.svg" alt=""></a>
                            <a href="javascript:;" id="btn-excel"><img src="{{ asset('template') }}/assets/img/icons/pdf-icon-04.svg" alt=""></a>
                        </div>
                    </div>
                </div>
                <!-- /Table Header -->
                <div class="table-responsive">
                    <table id="table1" class="table border-0 custom-table comman-table datatable mb-0 table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    <div class="form-check check-tables">
                                        <input class="form-check-input" id="check-all" type="checkbox">
                                    </div>
                                </th>
                                <th style="width: 5%">No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas Sekarang</th>
                                <th>Kelas Tujuan</th>
                                <th style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    let selectedIds = new Set();

    var table1 = dataTable('#table1');
    $('#search-table').focus();

    var searchTimeout = null;

    $('.filter-dt').change(function(e) {
        e.preventDefault();
        table1.ajax.reload();
    });

    $('#check-all').on('change', function() {
        $('.check-table').prop('checked', this.checked);
        $('.check-table').each(function() {
            saveSelectedId(this);
        });
    });

    $(document).on('change', '.check-table', function() {
        $('#check-all').prop('checked', $('.check-table:checked').length === $('.check-table').length);
        saveSelectedId(this);
    });

    $('#table1').on('draw.dt', function() {
        $('.check-table').each(function() {
            if (selectedIds.has($(this).val())) {
                $(this).prop('checked', true);
            }
        });
        $('#check-all').prop('checked', false);
    });

    function saveSelectedId(element) {
        let id = $(element).val();
        if (element.checked) {
            selectedIds.add(id);
        } else {
            selectedIds.delete(id);
        }
    }

    function searchDataTable(tableId, refresh = false) {
        var time = refresh ? 0 : 700;

        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(function() {
            $(tableId).DataTable().search(
                $('#search-table').val()
            ).draw();
        }, time);
    }

    function dataTable(tableId) {
        var url = "{{ route('admin.kenaikan-kelas.data') }}"
        var datatable = $(tableId).DataTable({
            dom: "rt<'d-flex justify-content-end m-3 align-items-center'l p><'d-flex justify-content-between m-3'iB>"
            , autoWidth: false
            , processing: true
            , serverSide: true
            , order: [
                [1, "desc"]
            ]
            , search: {
                return: false
            , }
            , ajax: {
                url: url
                , data: function(d) {
                    d.tahun_pelajaran_id = $('#filter_tahun_pelajaran_id').val();
                    d.unit_sekolah_id = $('#filter_unit_sekolah_id').val();
                    d.kelas_id = $('#filter_kelas_id').val();
                    d.jenis_kelamin = $('#filter_jenis_kelamin').val();
                }
            }
            , deferRender: true
            , columns: [{
                    data: 'id'
                    , render: function(data, type, row, meta) {
                        return `
                            <div class="form-check check-tables">
                                <input class="form-check-input check-table" type="checkbox" value="${data}">
                            </div>
                        `;
                    }
                    , className: "text-middle"
                    , orderable: false
                , }
                , {
                    data: 'id'
                    , render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }
                , {
                    data: 'nama_siswa'
                    , name: 'nama_siswa'
                    , className: "text-middle"
                }
                , {
                    data: 'kelas_sekarang'
                    , name: 'kelas_sekarang'
                    , className: "text-middle"
                    , orderable: false
                }
                , {
                    data: 'kelas_tujuan'
                    , name: 'kelas_tujuan'
                    , className: "text-middle"
                    , orderable: false
                }
                , {
                    data: 'action'
                    , name: 'action'
                    , className: "text-center"
                    , searchable: false
                    , orderable: false
                }
            ]
        , })
        return datatable;
    }

    function naikkanKelas(siswaId, namaSiswa) {
        swal({
            title: "Konfirmasi Kenaikan Kelas"
            , text: "Apakah Anda yakin ingin menaikkan " + namaSiswa + " ke kelas berikutnya?"
            , icon: "warning"
            , buttons: {
                confirm: {
                    text: "Ya, Naikkan"
                    , value: true
                    , visible: true
                    , className: "btn-success"
                    , closeModal: true
                }
                , cancel: "Batal"
            }
        , }).then((willPromote) => {
            if (willPromote) {
                $.ajax({
                    type: "POST"
                    , url: "{{ route('admin.kenaikan-kelas.naikkan') }}"
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , siswa_id: siswaId
                    }
                    , beforeSend: function() {
                        toastr.info('Memproses kenaikan kelas...');
                    }
                    , success: function(response) {
                        showToastr(response.status, response.message);
                        table1.ajax.reload();
                    }
                    , error: function(xhr) {
                        toastr.error(xhr.responseText);
                    }
                });
            }
        });
    }

    function naikkanKelasBatch() {
        let siswa_id = Array.from(selectedIds);

        if (siswa_id.length === 0) {
            swal('Peringatan!', 'Pilih setidaknya satu siswa terlebih dahulu.', 'warning');
            return;
        }

        swal({
            title: "Konfirmasi Kenaikan Kelas Batch"
            , text: "Apakah Anda yakin ingin menaikkan " + siswa_id.length + " siswa ke kelas berikutnya?"
            , icon: "warning"
            , buttons: {
                confirm: {
                    text: "Ya, Naikkan Semua"
                    , value: true
                    , visible: true
                    , className: "btn-success"
                    , closeModal: true
                }
                , cancel: "Batal"
            }
        , }).then((willPromote) => {
            if (willPromote) {
                $.ajax({
                    type: "POST"
                    , url: "{{ route('admin.kenaikan-kelas.naikkan-batch') }}"
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , siswa_id: siswa_id
                    }
                    , beforeSend: function() {
                        toastr.info('Memproses kenaikan kelas batch...');
                    }
                    , success: function(response) {
                        showToastr(response.status, response.message);
                        selectedIds.clear();
                        table1.ajax.reload();
                        $('#check-all').prop('checked', false);
                    }
                    , error: function(xhr) {
                        toastr.error(xhr.responseText);
                    }
                });
            }
        });
    }

</script>
@endpush
