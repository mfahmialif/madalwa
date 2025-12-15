<div class="col-12">
    <div class="input-block local-forms">
        <label>Unit Sekolah <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('unit_sekolah_id') is-invalid @enderror" name="unit_sekolah_id" required>
            <option value="">Pilih Unit Sekolah</option>
            @foreach ($unitSekolah as $item)
            <option value="{{ $item->id }}" {{ (old('unit_sekolah_id') ?? ($kamar->unit_sekolah_id ?? '')) == $item->id ? 'selected' : '' }}>
                {{ $item->nama_unit }}
            </option>
            @endforeach
        </select>
        @error('unit_sekolah_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="input-block local-forms">
        <label>Tahun Pelajaran <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('tahun_pelajaran_id') is-invalid @enderror" name="tahun_pelajaran_id" required>
            <option value="">Pilih Tahun Pelajaran</option>
            @foreach ($tahunPelajaran as $item)
            <option value="{{ $item->id }}" {{ (old('tahun_pelajaran_id') ?? ($kamar->tahun_pelajaran_id ?? '')) == $item->id ? 'selected' : '' }}>
                {{ $item->nama }} {{ $item->semester }}
            </option>
            @endforeach
        </select>
        @error('tahun_pelajaran_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Nama Kamar <span class="login-danger">*</span></label>
        <input class="form-control @error('nama_kamar') is-invalid @enderror" name="nama_kamar" type="text" value="{{ old('nama_kamar') ?? ($kamar->nama_kamar ?? '') }}" placeholder="Contoh: Kamar Melati" required>
        @error('nama_kamar')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="input-block local-forms">
        <label>Kapasitas (Opsional)</label>
        <input class="form-control @error('kapasitas') is-invalid @enderror" name="kapasitas" type="number" min="1" value="{{ old('kapasitas') ?? ($kamar->kapasitas ?? '') }}" placeholder="Contoh: 20">
        <small class="text-muted">Kosongkan jika tidak ada batasan kapasitas</small>
        @error('kapasitas')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>


<div class="col-12">
    <div class="input-block local-forms">
        <label>Keterangan</label>
        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="4" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') ?? ($kamar->keterangan ?? '') }}</textarea>
        @error('keterangan')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <button onclick="location.href = '{{ route('admin.kamar.index') }}'" type="button" class="btn btn-primary cancel-form">Batalkan</button>
    </div>
</div>
