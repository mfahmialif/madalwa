@extends('layouts.admin.template')
@section('title', 'Tambah Siswa ke Kamar')
@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.kamar.index') }}">Kamar </a></li>
                <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.kamar.siswa.index', $kamar) }}">Siswa Kamar</a></li>
                <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                <li class="breadcrumb-item active">Tambah Siswa</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->
<form action="{{ route('admin.kamar.siswa.store', $kamar) }}" onsubmit="submitFormThis(this)" method="POST">
    @csrf
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="feather-info"></i>
                <div>
                    <strong>Informasi:</strong> Anda sedang menambahkan siswa untuk
                    <strong>{{ $kamar->nama_kamar }}</strong> - {{ $kamar->unitSekolah->nama_unit }}
                </div>
            </div>
            <div class="alert alert-warning d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Penting:</strong> Siswa hanya bisa memiliki <strong>1 kamar per kelas</strong>.
                    <br>Siswa yang sudah memiliki kamar di kelas mereka saat ini tidak akan muncul dalam daftar.
                </div>
            </div>
            <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="feather-check"></i>
                <div>
                    Centang untuk memilih siswa yang akan dimasukkan ke kamar ini.
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-heading">
                                <h4>Form Tambah Siswa ke Kamar</h4>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-block local-forms">
                                <label>Tahun Pelajaran <span class="login-danger">*</span></label>
                                <select class="form-control select2 @error('tahun_pelajaran_id') is-invalid @enderror" name="tahun_pelajaran_id" required>
                                    <option value="">Pilih Tahun Pelajaran</option>
                                    @foreach ($tahunPelajaran as $item)
                                    <option value="{{ $item->id }}" {{ old('tahun_pelajaran_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }} {{ $item->semester }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('tahun_pelajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-block local-forms">
                                <label>Keterangan (Opsional)</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="3" placeholder="Keterangan tambahan">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <hr>
                            <h5 class="mb-3"><i class="fas fa-users me-2"></i>Pilih Siswa</h5>
                        </div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tableSiswa" class="table border-0 custom-table comman-table datatable mb-0 table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" id="check-all" type="checkbox">
                                                </div>
                                            </th>
                                            <th style="width: 5%">No</th>
                                            <th>Nama Siswa</th>
                                            <th>Jenis Kelamin</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="doctor-submit text-end">
                                <button type="submit" class="btn btn-primary submit-form me-2">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                                <button onclick="location.href = '{{ route('admin.kamar.siswa.index', $kamar) }}'" type="button" class="btn btn-secondary cancel-form">
                                    <i class="fas fa-times me-1"></i> Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('script')
<script>
    var tableSiswa = dataTable('#tableSiswa');

    $('#check-all').on('change', function() {
        $('.check-table').prop('checked', this.checked);
    });

    $(document).on('change', '.check-table', function() {
        $('#check-all').prop('checked', $('.check-table:checked').length === $('.check-table').length);
    });

    function dataTable(tableId) {
        var url = "{{ route('admin.kamar.siswa.data-siswa', $kamar) }}"
        var datatable = $(tableId).DataTable({
            dom: "rt<'d-flex justify-content-end m-3 align-items-center'l p><'d-flex justify-content-between m-3'iB>"
            , autoWidth: false
            , processing: true
            , serverSide: true
            , order: [
                [1, "asc"]
            ]
            , search: {
                return: true
            , }
            , ajax: {
                url: url
            }
            , lengthMenu: [
                [10, 20, 50, 100, -1]
                , [10, 20, 50, 100, 'All']
            ]
            , deferRender: true
            , columns: [{
                    data: 'id'
                    , render: function(data, type, row, meta) {
                        return `
                            <div class="form-check check-tables">
                                <input class="form-check-input check-table" type="checkbox" name="siswa_id[]" value="${data}">
                            </div>
                        `;
                    }
                    , className: "text-middle"
                    , orderable: false
                , }, {
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
                    data: 'jenis_kelamin'
                    , name: 'jenis_kelamin'
                    , className: "text-middle"
                }
            ]
        , })
        return datatable;
    }

    function submitFormThis(form) {
        event.preventDefault();

        const checkedBoxes = form.querySelectorAll('input[name="siswa_id[]"]:checked');
        if (checkedBoxes.length === 0) {
            swal('Peringatan!', 'Pilih setidaknya satu siswa terlebih dahulu.', 'warning');
            return false;
        }

        submitForm(form);
        form.submit();
    }

</script>
@endpush
