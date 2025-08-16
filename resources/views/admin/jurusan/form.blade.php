<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Kode Jurusan</label>
        <input class="form-control @error('kode_jurusan') is-invalid @enderror" name="kode_jurusan" type="text"
            value="{{ old('kode_jurusan') }}">
        @error('kode_jurusan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Nama Jurusan</label>
        <input class="form-control @error('nama_jurusan') is-invalid @enderror" name="nama_jurusan" type="text"
            value="{{ old('nama_jurusan') }}">
        @error('nama_jurusan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-12">
    <div class="input-block local-forms">
        <label>Kuota</label>
        <input class="form-control @error('kuota') is-invalid @enderror" name="kuota" type="number"
            value="{{ old('kuota') }}">
        @error('kuota')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-md-12">
    <div class="input-block local-forms">
        <label>Status<span class="login-danger">*</span></label>
        <select class="form-control select2 @error('status') is-invalid @enderror" name="status" required>
            <option value="">Pilih Status</option>
            <option value="aktif">Aktif</option>
            <option value="tidak aktif">Tidak Aktif</option>
        </select>
        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
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
