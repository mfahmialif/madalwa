<div class="col-12 col-md-12">
    <div class="input-block local-forms">
        <label>Unit Sekolah<span class="login-danger">*</span></label>
        <select class="form-control select2 filter-dt" name="unit_sekolah_id" required>
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
<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Kode Jurusan<span class="login-danger">*</span></label>
        <input class="form-control @error('kode_jurusan') is-invalid @enderror" name="kode_jurusan" type="text"
            value="{{ old('kode_jurusan') }}" required>
        @error('kode_jurusan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Nama Jurusan<span class="login-danger">*</span></label>
        <input class="form-control @error('nama_jurusan') is-invalid @enderror" name="nama_jurusan" type="text"
            value="{{ old('nama_jurusan') }}" required>
        @error('nama_jurusan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-12">
    <div class="input-block local-forms">
        <label>Kuota<span class="login-danger">*</span></label>
        <input class="form-control @error('kuota') is-invalid @enderror" name="kuota" type="number"
            value="{{ old('kuota') }}" required>
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
