{{-- DATA AKUN & TAHUN AJARAN --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Informasi Mutasi Siswa</span></h5>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Kelas <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('siswa_id') is-invalid @enderror" name="siswa_id" required>
            <option value="">Pilih Siswa</option>
            @foreach ($siswa as $item)
                <option value="{{ $item->id }}" {{ old('siswa_id',$mutasi->siswa_id ?? '') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_siswa }}
                </option>
            @endforeach
        </select>
        @error('siswa_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 ">
    <div class="input-block local-forms">
        <label>Tanggal Mutasi</label>
        <input class="form-control @error('tgl_mutasi') is-invalid @enderror" name="tgl_mutasi" type="date"
            value="{{ old('tgl_mutasi',$mutasi->tgl_mutasi ?? '')}}">
        @error('tgl_mutasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 ">
    <div class="input-block local-forms">
        <label>Sekolah Tujuan</label>
        <input class="form-control @error('sekolah_tujuan') is-invalid @enderror" name="sekolah_tujuan" type="text"
            value="{{ old('sekolah_tujuan',$mutasi->sekolah_tujuan ?? '')}}">
        @error('sekolah_tujuan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Alasan Mutasi</label>
        <textarea class="form-control @error('alasan_mutasi') is-invalid @enderror" 
                  name="alasan_mutasi" rows="3">{{ old('alasan_mutasi', $mutasi->alasan_mutasi ?? '')}}</textarea>
        @error('alasan_mutasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>No Surat</label>
        <input type="text" 
               class="form-control @error('no_surat') is-invalid @enderror"
               name="no_surat"
               value="{{ old('no_surat', $mutasi->no_surat ?? '') }}">
        @error('no_surat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 mt-5">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <a href="{{ route('admin.mutasi-masuk.index') }}"
            class="btn btn-secondary cancel-form">Batalkan</a>
    </div>
</div>

@push('script')
    <script>
        function handleFileUpload(input, fileInfoId, uploadLabelId) {
            const fileInfo = document.getElementById(fileInfoId);
            const uploadLabel = document.getElementById(uploadLabelId);
            const file = input.files[0];

            if (file) {
                const isImage = file.type.startsWith("image/");
                if (!isImage) {
                    fileInfo.innerText = "Belum ada file";
                    uploadLabel.innerText = "Pilih File";
                    return;
                }

                fileInfo.innerText = file.name;
                uploadLabel.innerText = "Ganti File";
            } else {
                fileInfo.innerText = "Belum ada file";
                uploadLabel.innerText = "Pilih File";
            }
        }
    </script>
@endpush
@push('css')
    <style>
        .form-title {
            margin-bottom: 24px;
        }
    </style>
@endpush
