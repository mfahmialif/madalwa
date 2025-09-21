<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-heading">
                    <h4>Kurikulum</h4>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="input-block local-forms">
                    <label>Unit Sekolah <span class="login-danger">*</span></label>
                    <select class="form-control select2 filter-dt" name="unit_sekolah_id" id="unit_sekolah_id" required>
                        @if (Auth::user()->role->nama == 'unit sekolah')
                            <option value="{{ Auth::user()->unitSekolah->unit_sekolah_id }}">
                                {{ Auth::user()->unitSekolah->unitSekolah->nama_unit }}
                            </option>
                        @else
                            <option value="">Pilih Unit Sekolah</option>
                            @foreach ($unitSekolah as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_unit }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="input-block local-forms">
                    <label>Nama Kurikulum <span class="login-danger">*</span></label>
                    <input class="form-control @error('nama') is-invalid @enderror" name="nama" type="text"
                        value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="input-block local-forms">
                    <label>Tahun Pelajaran <span class="login-danger">*</span></label>
                    <select class="form-control select2 filter-dt" id="tahun_pelajaran_id" name="tahun_pelajaran_id"
                        required>
                        <option value="">Pilih Tahun Pelajaran</option>
                        @foreach ($tahunPelajaran as $item)
                            <option value="{{ $item->id }}"
                                {{ old('tahun_pelajaran_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }} {{ $item->semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body" id="card-mata-pelajaran">
        <div class="page-table-header mb-2">
            <div class="row align-items-center">
                <div class="col">
                    <div class="doctor-table-blk">
                        <h3>Mata Pelajaran</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Table Header -->

    </div>
</div>


<div class="col-12 pb-4">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <a href="{{ route('admin.kurikulum.index') }}" class="btn btn-secondary cancel-form">Batalkan</a>
    </div>
</div>

@push('script')
    <script>
        //  var table1 = dataTable('#tableAdd');
        if (typeof kurikulum !== 'undefined') {
            setMataPelajaranKurikulum();
        }
        loadMataPelajaran();

        $('#unit_sekolah_id').change(function (e) {
            loadMataPelajaran();
        });
        $(document).on('change', '.check-table', function() {
            $('#check-all').prop('checked', $('.check-table:checked').length === $('.check-table').length);
        });


        function loadMataPelajaran() {
            $('#card-mata-pelajaran').loading('start');
            $.ajax({
                type: "GET",
                url: "{{ route('admin.kurikulum.dataMataPelajaran') }}",
                data: {
                    unit_sekolah_id: $('#unit_sekolah_id').val()
                },
                success: function(response) {
                    $('#card-mata-pelajaran').html(response);
                    $("#tableAdd").DataTable({
                        dom: "<'d-flex justify-content-end align-items-center m-3'f>rt<'d-flex justify-content-end m-3 align-items-center'l p><'d-flex justify-content-between m-3'iB>",
                        columnDefs: [{
                                targets: 0,
                                orderable: false
                            } // kolom ke-0 tidak bisa diurutkan
                        ],
                        paging: false,
                        info: false
                    });

                    $('#check-all').on('change', function() {
                        $('.check-table').not(':disabled').prop('checked', this.checked);
                    });

                    if (typeof kurikulum !== 'undefined') {
                        setMataPelajaranKurikulum();
                    }
                },
                complete: function() {
                    $('#card-mata-pelajaran').loading('stop');
                }
            });
        }
    </script>
@endpush
