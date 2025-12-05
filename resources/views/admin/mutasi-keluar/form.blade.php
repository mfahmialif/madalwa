{{-- DATA AKUN & TAHUN AJARAN --}}
<div class="col-12 hidden-edit">
    <div class="input-block local-forms input-group">
        <label>Pencarian Siswa <span class="login-danger">*</span></label>
        <input class="form-control @error('nama') is-invalid @enderror" id="search" name="search" type="text"
            placeholder="" value="{{ old('search') }}" tabindex="1" onfocus="this.select()">
        <input type="hidden" name="siswa_id" id="siswa_id" value="{{ old('siswa_id') }}">
        <button class="btn btn-danger" type="button" onclick="clearSearch()" data-bs-toggle="tooltip"
            data-bs-placement="top" data-bs-custom-class="custom-tooltip"
            data-bs-title="Bersihkan pencarian" aria-label="Bersihkan pencarian"><i class="fa fa-trash"></i></button>
        @error('search')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 hidden-edit">
    <div class="input-block local-forms">
        <label>Nama</label>
        <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" type="text"
            placeholder="dari pencarian..." value="{{ old('nama') }}">
        @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6 hidden-edit">
    <div class="input-block local-forms">
        <label>NIS</label>
        <input class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" type="text"
            placeholder="dari pencarian..." value="{{ old('nis') }}">
        @error('nis')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6 hidden-edit">
    <div class="input-block local-forms">
        <label>NIK</label>
        <input class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" type="text"
            placeholder="dari pencarian..." value="{{ old('nik') }}">
        @error('nik')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12 hidden-edit">
    <div class="input-block local-forms">
        <label>Jenis Kelamin</label>
        <input class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin"
            type="text" placeholder="dari pencarian..." value="{{ old('jenis_kelamin') }}">
        @error('jenis_kelamin')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Tanggal Mutasi <span class="login-danger">*</span></label>
        <input class="form-control @error('tgl_mutasi') is-invalid @enderror" name="tgl_mutasi" type="date" id="tgl_mutasi"
            value="{{ old('tgl_mutasi', $mutasi->tgl_mutasi ?? '') }}" required>
        @error('tgl_mutasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 ">
    <div class="input-block local-forms">
        <label>Sekolah Tujuan <span class="login-danger">*</span></label>
        <input class="form-control @error('sekolah_tujuan') is-invalid @enderror" name="sekolah_tujuan" type="text"
            value="{{ old('sekolah_tujuan', $mutasi->sekolah_tujuan ?? '') }}" required>
        @error('sekolah_tujuan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Alasan Mutasi <span class="login-danger">*</span></label>
        <textarea class="form-control @error('alasan_mutasi') is-invalid @enderror" required name="alasan_mutasi"
            rows="3">{{ old('alasan_mutasi', $mutasi->alasan_mutasi ?? '') }}</textarea>
        @error('alasan_mutasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>No Surat <span class="login-danger">*</span></label>
        <input type="text" class="form-control @error('no_surat') is-invalid @enderror" name="no_surat"
            value="{{ old('no_surat', $mutasi->no_surat ?? '') }}" required>
        @error('no_surat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 mt-5">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <a href="{{ route('admin.mutasi-keluar.index') }}" class="btn btn-secondary cancel-form">Batalkan</a>
    </div>
</div>

@push('script')
    <script>
        $('#search').autocomplete({
            source: function(request, response) {
                var url = "{{ route('admin.mutasi-keluar.autocomplete', ['query' => 'query']) }}";
                url = url.replace('query', request.term);

                $.ajax({
                    type: "get",
                    url: url,
                    success: function(data) {
                        response(data.map(item => ({
                            label: item.label,
                            value: item.value,
                            data: item
                        })));
                    }
                });
            },
            select: function(event, ui) {
                // Set the label in the user input
                $('#siswa_id').val(ui.item.value);
                let data = ui.item.data.data;
                $('#nama').val(data.nama_siswa);
                $('#nis').val(data.nis);
                $('#nik').val(data.nik);
                $('#jenis_kelamin').val(data.jenis_kelamin);

                $('#search').val(ui.item.label);
                // Store the value (user ID) in the hidden input
                // $(offcanvasID).find("input[name='user_id']").val(ui.item.value);
                $('#tgl_mutasi').focus();
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append(`<div style="padding: 5px; font-size: 14px;">${item.label}</div>`)
                .appendTo(ul);
        };

        function clearSearch() {
            $('#search').val('');
            $('#siswa_id').val('');
            $('#nama').val('');
            $('#nis').val('');
            $('#nik').val('');
            $('#jenis_kelamin').val('');
            $('#search').focus();
        }
    </script>
@endpush
