<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Nama Unit<span class="login-danger">*</span></label>
        <input class="form-control @error('nama_unit') is-invalid @enderror" name="nama_unit" type="text"
            value="{{ old('nama_unit') }}" required>
        @error('kode_jurusan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Alamat</label>
        <input class="form-control @error('alamat') is-invalid @enderror" name="alamat" type="text"
            value="{{ old('alamat') }}">
        @error('nama_jurusan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="input-block local-forms">
        <label>Keterangan</label>
        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
        @error('keterangan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <button onclick="location.href = '{{ route('admin.jurusan.index') }}'" type="button"
            class="btn btn-primary cancel-form">Batalkan</button>
    </div>
</div>
