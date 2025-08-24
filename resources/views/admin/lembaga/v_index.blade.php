@extends('layouts.admin.template')
@section('title', 'Role')
@section('content')
    <div class="card bg-white">
        <div class="card-header">
            <h5 class="card-title">Profile Lembaga</h5>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-bs-toggle="tab">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-bs-toggle="tab">Alamat Lembaga</a></li>
                <li class="nav-item"><a class="nav-link" href="#bottom-tab3" data-bs-toggle="tab">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="#bottom-tab4" data-bs-toggle="tab">Kepala Sekolah</a></li>
            </ul>
            <form class="mt-3" id="formLembaga">
                @csrf
                @if ($data)
                    @method('PUT')
                @endif
                <div class="tab-content">
                    <div class="tab-pane show active" id="bottom-tab1">
                        <input type="hidden" value="{{ $data->id }}" name="id" id="id">
                        <div class="row mb-3 p-3">
                            <label for="nsm" class="col-sm-1 col-form-label">NSM</label>
                            <div class="col-sm-11">
                                <input type="text" id="nsm" value="{{ $data->nsm }}" class="form-control"
                                    placeholder="Masukkan NSM">
                            </div>
                        </div>
                        <div class="row mb-3 p-3">
                            <label for="npsn" class="col-sm-1 col-form-label">NPSN</label>
                            <div class="col-sm-11">
                                <input type="text" id="npsn" value="{{ $data->npsn }}" class="form-control"
                                    placeholder="Masukkan NPSN">
                            </div>
                        </div>
                        <div class="row mb-3 p-3">
                            <label for="nama" class="col-sm-1 col-form-label">Nama Sekolah</label>
                            <div class="col-sm-11">
                                <input type="text" id="nama_sekolah" name="nama_sekolah" value="{{ $data->nama_sekolah }}" class="form-control"
                                    placeholder="Masukkan Nama Lembaga">
                            </div>
                        </div>
                        <div class="row mb-3 p-3">
                            <label for="jenjang" class="col-sm-1 col-form-label">Jenjang Sekolah</label>
                            <div class="col-sm-11">
                                <select id="jenjang" class="form-select">
                                    <option value="">Pilih Status</option>
                                    <option value="MA/SMA/SMK"
                                        {{ $data->jenjang_sekolah == 'MA/SMA/SMK' ? 'selected' : '' }}>MA/SMA/SMK</option>
                                    <option value="SMP/MTS" {{ $data->jenjang_sekolah == 'SMP/MTS' ? 'selected' : '' }}>
                                        SMP/MTS</option>
                                    <option value="SD/MI" {{ $data->jenjang_sekolah == 'SD/MI' ? 'selected' : '' }}>SD/MI
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 p-3">
                            <label for="status" class="col-sm-1 col-form-label">Status</label>
                            <div class="col-sm-11">
                                <select id="status" class="form-select">
                                    <option value="">Pilih Status</option>
                                    <option value="Negeri"{{ $data->status_sekolah == 'Negeri' ? 'selected' : '' }}>Negeri
                                    </option>
                                    <option value="Swasta" {{ $data->status_sekolah == 'Swasta' ? 'selected' : '' }}>Swasta
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="bottom-tab2">
                        <div class="row mb-3 p-3">
                            <label for="alamat_lengkap" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" id="alamat_lengkap" value="{{ $data->alamat_lengkap }}"
                                    class="form-control" placeholder="Masukkan Alamat Lengkap">
                            </div>
                        </div>
                        <div class="row mb-3 p-3">
                            <label for="provinsi" class="col-sm-2 col-form-label">Provinsi</label>
                            <div class="col-sm-10">
                                <input type="text" id="provinsi" value="{{ $data->provinsi }}" class="form-control"
                                    placeholder="Masukkan Provinsi">
                            </div>
                        </div>
                        <div class="row mb-3 p-3">
                            <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
                            <div class="col-sm-10">
                                <input type="text" id="kabupaten" value="{{ $data->kabupaten }}" class="form-control"
                                    placeholder="Masukkan Kabupaten">
                            </div>
                        </div>
                        <div class="row mb-3 p-3">
                            <label for="kecamatan" class="col-sm-2 col-form-label">Kecamatan</label>
                            <div class="col-sm-10">
                                <input type="text" id="kecamatan" value="{{ $data->kecamatan }}" name="kecamatan"
                                    class="form-control" placeholder="Masukkan Kecamatan">
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="bottom-tab3">
                        <div class="row mb-3 p-3">
                            <label for="nsm" class="col-sm-1 col-form-label">No Telp</label>
                            <div class="col-sm-11">
                                <input type="text" id="no_telp" value="{{ $data->no_telp }}" name="no_telp"
                                    class="form-control" placeholder="Masukkan No Telp">
                            </div>
                        </div>
                        <div class="row mb-3 p-3">
                            <label for="npsn" class="col-sm-1 col-form-label">Email</label>
                            <div class="col-sm-11">
                                <input type="text" id="email" name="email" value="{{ $data->email }}"
                                    class="form-control" placeholder="Masukkan Email">
                            </div>
                        </div>
                        <div class="row mb-3 p-3">
                            <label for="nama" class="col-sm-1 col-form-label">Website</label>
                            <div class="col-sm-11">
                                <input type="text" id="website" value="{{ $data->website }}" name="website"
                                    class="form-control" placeholder="Masukkan Nama Website">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="bottom-tab4">
                        <div class="row mb-3 p-3">
                            <label for="nsm" class="col-sm-1 col-form-label">Kepala Madrasah</label>
                            <div class="col-sm-11">
                                <input type="text" id="kpl_madrasah" value="{{ $data->kepala_madrasah }}"
                                    name="kpl_madrasah" class="form-control" placeholder="Masukkan No Telp">
                            </div>
                        </div>
                        <div class="row mb-3 p-3">
                            <label for="nip" class="col-sm-1 col-form-label">Nip</label>
                            <div class="col-sm-11">
                                <input type="text" id="nip" value="{{ $data->nip }}" name="nip"
                                    class="form-control" placeholder="Masukkan Email">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="submit" class="btn btn-primary"   id="btn-lembaga">Simpan</button>
                            <button type="reset" class="btn btn-secondary">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var table1 = dataTable('#table1');
        $('#search-table').focus();

        var searchTimeout = null;

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
            var url = "{{ route('admin.role.data') }}"
            var datatable = $(tableId).DataTable({
                // responsive: true,
                dom: "rt<'d-flex justify-content-end m-3 align-items-center'l p><'d-flex justify-content-between m-3'iB>",
                autoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                search: {
                    return: true,
                },
                ajax: {
                    url: url,
                    data: function(d) {
                        // d.search = $('#search-table').val();
                    },
                },
                deferRender: true,
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        className: "text-middle"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-end",
                        searchable: false,
                        orderable: false
                    },
                ],
            })
            return datatable;
        }

        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var nama = event.target.querySelector('input[name="nama"]').value;
            swal({
                title: "Apa kamu yakin?",
                text: "Data yang akan dihapus: " + nama + ". Data tidak dapat dikembalikan!",
                icon: "warning",
                buttons: {
                    confirm: {
                        text: "OK",
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: true
                    },
                    cancel: "Batalkan",
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var url = "{{ route('admin.role.destroy', ['role' => '_user']) }}";
                    url = url.replace('_user', id);
                    var fd = new FormData($(event.target)[0]);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            toastr.info('Loading...');
                        },
                        success: function(response) {
                            searchDataTable('#table1', true);
                            showToastr(response.status, response.message);
                        }
                    });
                }
            });
        }

        $(document).on('click',"#btn-lembaga", function () {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.lembaga.store') }}",
                data: $("#formLembaga").serialize(),
                dataType: "json",
                success: function (response) {
                    
                }
            });
        });
    </script>
@endpush
