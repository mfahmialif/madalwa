{{-- DATA AKUN & TAHUN AJARAN --}}
<div class="col-12">
    <h5 class="form-title"><span>Data Akun & Akademik</span></h5>
</div>
<div class="col-12 col-md-12">
    <div class="input-block local-forms">
        <label>Kelas <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('kelas_id') is-invalid @enderror" name="kelas_id" required>
            <option value="">Pilih Kelas</option>
            @foreach ($kelas as $item)
                <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->angka }} ({{ $item->unitSekolah->nama_unit }})
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
        <label>Email</label>
        <input class="form-control @error('email') is-invalid @enderror" name="email" type="text"
            value="{{ old('email') }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr>


{{-- ===================== INFORMASI PRIBADI SISWA ===================== --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Informasi Pribadi Siswa</span></h5>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Nama Lengkap Siswa <span class="login-danger">*</span></label>
        <input class="form-control @error('nama_siswa') is-invalid @enderror" name="nama_siswa" type="text"
            value="{{ old('nama_siswa') }}" required>
        @error('nama_siswa')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Kewarganegaraan <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('kewarganegaraan') is-invalid @enderror" name="kewarganegaraan"
            required>
            @foreach (\Helper::getEnumValues('siswa', 'kewarganegaraan') as $opt)
                <option value="{{ $opt }}" {{ old('kewarganegaraan', 'WNI') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('kewarganegaraan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Jenis Kelamin <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required>
            @foreach (\Helper::getEnumValues('siswa', 'jenis_kelamin') as $opt)
                <option value="{{ $opt }}" {{ old('jenis_kelamin') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('jenis_kelamin')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- jurusan_id --}}
<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Program/Jurusan <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('jurusan_id') is-invalid @enderror" name="jurusan_id" required>
            <option value="">Pilih Jurusan</option>
            @foreach ($jurusan as $j)
                <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                    {{ $j->nama_jurusan }} ({{ $j->unitSekolah->nama_unit }})
                </option>
            @endforeach
        </select>
        @error('jurusan_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NIS</label>
        <input class="form-control @error('nis') is-invalid @enderror" name="nis" type="text"
            value="{{ old('nis') }}">
        @error('nis')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>NISN</label>
        <input class="form-control @error('nisn') is-invalid @enderror" name="nisn" type="text"
            value="{{ old('nisn') }}">
        @error('nisn')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NIK Anak</label>
        <input class="form-control @error('nik') is-invalid @enderror" name="nik" type="text"
            value="{{ old('nik') }}">
        @error('nik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Tempat Lahir <span class="login-danger">*</span></label>
        <input class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" type="text"
            value="{{ old('tempat_lahir') }}" required>
        @error('tempat_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Tanggal Lahir <span class="login-danger">*</span></label>
        <input class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" type="date"
            value="{{ old('tanggal_lahir') }}" required>
        @error('tanggal_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Agama <span class="login-danger">*</span></label>
        <select class="form-control select2 @error('agama') is-invalid @enderror" name="agama" required>
            @foreach (\Helper::getEnumValues('siswa', 'agama') as $opt)
                <option value="{{ $opt }}" {{ old('agama', 'Islam') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('agama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Asal Sekolah</label>
        <input class="form-control @error('asal_sekolah') is-invalid @enderror" name="asal_sekolah" type="text"
            value="{{ old('asal_sekolah') }}">
        @error('asal_sekolah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Anak Ke-</label>
        <input class="form-control @error('anak_ke') is-invalid @enderror" name="anak_ke" type="number"
            value="{{ old('anak_ke') }}">
        @error('anak_ke')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Jumlah Saudara</label>
        <input class="form-control @error('jml_saudara') is-invalid @enderror" name="jml_saudara" type="number"
            value="{{ old('jml_saudara') }}">
        @error('jml_saudara')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Cita-cita</label>
        <select class="form-control select2 @error('cita_cita') is-invalid @enderror" name="cita_cita">
            <option value="">Pilih Cita-cita</option>
            @foreach (\Helper::getEnumValues('siswa', 'cita_cita') as $opt)
                <option value="{{ $opt }}" {{ old('cita_cita') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('cita_cita')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>No. HP</label>
        <input class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" type="text"
            value="{{ old('no_hp') }}">
        @error('no_hp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Hobi</label>
        <select class="form-control select2 @error('hobi') is-invalid @enderror" name="hobi">
            <option value="">Pilih Hobi</option>
            @foreach (\Helper::getEnumValues('siswa', 'hobi') as $opt)
                <option value="{{ $opt }}" {{ old('hobi') === $opt ? 'selected' : '' }}>{{ $opt }}
                </option>
            @endforeach
        </select>
        @error('hobi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr>

{{-- ===================== ALAMAT SISWA (SES. KK) ===================== --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Alamat Siswa (Sesuai KK)</span></h5>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Status Tempat Tinggal</label>
        <select class="form-control select2 @error('tempat_tinggal_siswa') is-invalid @enderror"
            name="tempat_tinggal_siswa">
            <option value="">Pilih Status</option>
            @foreach (\Helper::getEnumValues('siswa', 'tempat_tinggal_siswa') as $opt)
                <option value="{{ $opt }}" {{ old('tempat_tinggal_siswa') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('tempat_tinggal_siswa')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="input-block local-forms">
        <label>Alamat Lengkap</label>
        <textarea class="form-control @error('alamat_anak_sesuai_kk') is-invalid @enderror" name="alamat_anak_sesuai_kk"
            rows="3">{{ old('alamat_anak_sesuai_kk') }}</textarea>
        @error('alamat_anak_sesuai_kk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@include('components.form.wilayah', ['postFix' => ''])

<div class="col-12 col-md-12">
    <div class="input-block local-forms">
        <label>Jalan/Dusun</label>
        <input class="form-control @error('jalan_dusun') is-invalid @enderror" name="jalan_dusun" type="text"
            value="{{ old('jalan_dusun') }}">
        @error('jalan_dusun')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-4">
    <div class="input-block local-forms">
        <label>Koordinat Rumah</label>
        <input class="form-control @error('kordinat_rumah') is-invalid @enderror" name="kordinat_rumah"
            type="text" value="{{ old('kordinat_rumah') }}">
        @error('kordinat_rumah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-4">
    <div class="input-block local-forms">
        <label>Kode Pos</label>
        <input class="form-control @error('kodepos') is-invalid @enderror" name="kodepos" type="text"
            value="{{ old('kodepos') }}">
        @error('kodepos')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-4">
    <div class="input-block local-forms">
        <label>Transportasi</label>
        <select class="form-control select2 @error('transportasi') is-invalid @enderror" name="transportasi">
            <option value="">Pilih Transportasi</option>
            @foreach (\Helper::getEnumValues('siswa', 'transportasi') as $opt)
                <option value="{{ $opt }}" {{ old('transportasi') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('transportasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-4">
    <div class="input-block local-forms">
        <label>Jarak Rumah</label>
        <select class="form-control select2 @error('jarak') is-invalid @enderror" name="jarak">
            <option value="">Pilih Jarak</option>
            @foreach (\Helper::getEnumValues('siswa', 'jarak') as $opt)
                <option value="{{ $opt }}" {{ old('jarak') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('jarak')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-4">
    <div class="input-block local-forms">
        <label>Waktu Tempuh</label>
        <select class="form-control select2 @error('waktu') is-invalid @enderror" name="waktu">
            <option value="">Pilih Waktu</option>
            @foreach (\Helper::getEnumValues('siswa', 'waktu') as $opt)
                <option value="{{ $opt }}" {{ old('waktu') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('waktu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>No KIP</label>
        <input class="form-control @error('no_kip') is-invalid @enderror" name="no_kip" type="text"
            value="{{ old('no_kip') }}">
        @error('no_kip')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Kepala Keluarga</label>
        <input class="form-control @error('kepala_keluarga') is-invalid @enderror" name="kepala_keluarga"
            type="text" value="{{ old('kepala_keluarga') }}">
        @error('kepala_keluarga')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- Imunisasi / Riwayat --}}
@foreach (['tk_ra' => 'Pernah TK/RA', 'paud' => 'PAUD', 'hepatitis_b' => 'Hepatitis B', 'polio' => 'Polio', 'bcg' => 'BCG', 'campak' => 'Campak', 'dpt' => 'DPT', 'covid' => 'COVID'] as $field => $label)
    <div class="col-6 col-md-3">
        <div class="input-block local-forms">
            <label>{{ $label }}</label>
            <select class="form-control select2 @error($field) is-invalid @enderror" name="{{ $field }}">
                <option value="">Pilih...</option>
                @foreach (\Helper::getEnumValues('siswa', $field) as $opt)
                    <option value="{{ $opt }}" {{ old($field) === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
            @error($field)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endforeach

<hr>

{{-- ===================== DATA ORANG TUA: AYAH ===================== --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Data Orang Tua</span></h5>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Nama Ayah</label>
        <input class="form-control @error('nama_ayah') is-invalid @enderror" name="nama_ayah" type="text"
            value="{{ old('nama_ayah') }}">
        @error('nama_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Status Ayah</label>
        <select class="form-control select2 @error('status_ayah') is-invalid @enderror" name="status_ayah">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'status_ayah') as $opt)
                <option value="{{ $opt }}" {{ old('status_ayah') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('status_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Kewarganegaraan Ayah</label>
        <select class="form-control select2 @error('kewarganegaraan_ayah') is-invalid @enderror"
            name="kewarganegaraan_ayah">
            @foreach (\Helper::getEnumValues('siswa', 'kewarganegaraan_ayah') as $opt)
                <option value="{{ $opt }}" {{ old('kewarganegaraan_ayah') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('kewarganegaraan_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NIK Ayah</label>
        <input class="form-control @error('nik_ayah') is-invalid @enderror" name="nik_ayah" type="text"
            value="{{ old('nik_ayah') }}">
        @error('nik_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Tempat Lahir Ayah</label>
        <input class="form-control @error('tempat_lahir_ayah') is-invalid @enderror" name="tempat_lahir_ayah"
            type="text" value="{{ old('tempat_lahir_ayah') }}">
        @error('tempat_lahir_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Tanggal Lahir Ayah</label>
        <input class="form-control @error('tanggal_lahir_ayah') is-invalid @enderror" name="tanggal_lahir_ayah"
            type="date" value="{{ old('tanggal_lahir_ayah') }}">
        @error('tanggal_lahir_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pendidikan Ayah</label>
        <select class="form-control select2 @error('pendidikan_ayah') is-invalid @enderror" name="pendidikan_ayah">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'pendidikan_ayah') as $opt)
                <option value="{{ $opt }}" {{ old('pendidikan_ayah') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('pendidikan_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pekerjaan Ayah</label>
        <select class="form-control select2 @error('pekerjaan_ayah') is-invalid @enderror" name="pekerjaan_ayah">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'pekerjaan_ayah') as $opt)
                <option value="{{ $opt }}" {{ old('pekerjaan_ayah') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('pekerjaan_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Penghasilan Ayah</label>
        <select class="form-control select2 @error('penghasilan_ayah') is-invalid @enderror" name="penghasilan_ayah">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'penghasilan_ayah') as $opt)
                <option value="{{ $opt }}" {{ old('penghasilan_ayah') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('penghasilan_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>No HP Ayah</label>
        <input class="form-control @error('no_hp_ayah') is-invalid @enderror" name="no_hp_ayah" type="text"
            value="{{ old('no_hp_ayah') }}">
        @error('no_hp_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Domisili Ayah</label>
        <select class="form-control select2 @error('domisili_ayah') is-invalid @enderror" name="domisili_ayah">
            @foreach (\Helper::getEnumValues('siswa', 'domisili_ayah') as $opt)
                <option value="{{ $opt }}" {{ old('domisili_ayah') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('domisili_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Status Tempat Tinggal Ayah</label>
        <select class="form-control select2 @error('status_tempat_tinggal_ayah') is-invalid @enderror"
            name="status_tempat_tinggal_ayah">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'status_tempat_tinggal_ayah') as $opt)
                <option value="{{ $opt }}"
                    {{ old('status_tempat_tinggal_ayah') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
            @endforeach
        </select>
        @error('status_tempat_tinggal_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="input-block local-forms">
        <label>Alamat Lengkap</label>
        <textarea class="form-control @error('alamat_ayah') is-invalid @enderror" name="alamat_ayah"
            rows="3">{{ old('alamat_ayah') }}</textarea>
        @error('alamat_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@include('components.form.wilayah', ['postFix' => '_ayah'])

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Kode Pos Ayah</label>
        <input class="form-control @error('kodepos_ayah') is-invalid @enderror" name="kodepos_ayah" type="text"
            value="{{ old('kodepos_ayah') }}">
        @error('kodepos_ayah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr>

{{-- ===================== DATA IBU ===================== --}}
<div class="col-12 mt-3">
    <h6 class="form-title"><span>Ibu</span></h6>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Nama Ibu</label>
        <input class="form-control @error('nama_ibu') is-invalid @enderror" name="nama_ibu" type="text"
            value="{{ old('nama_ibu') }}">
        @error('nama_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Status Ibu</label>
        <select class="form-control select2 @error('status_ibu') is-invalid @enderror" name="status_ibu">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'status_ibu') as $opt)
                <option value="{{ $opt }}" {{ old('status_ibu') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('status_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Kewarnegaraan Ibu</label>
        <select class="form-control select2 @error('kewarganegaraan_ibu') is-invalid @enderror"
            name="kewarganegaraan_ibu">
            @foreach (\Helper::getEnumValues('siswa', 'kewarganegaraan_ibu') as $opt)
                <option value="{{ $opt }}" {{ old('kewarganegaraan_ibu') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('kewarganegaraan_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NIK Ibu</label>
        <input class="form-control @error('nik_ibu') is-invalid @enderror" name="nik_ibu" type="text"
            value="{{ old('nik_ibu') }}">
        @error('nik_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Tempat Lahir Ibu</label>
        <input class="form-control @error('tempat_lahir_ibu') is-invalid @enderror" name="tempat_lahir_ibu"
            type="text" value="{{ old('tempat_lahir_ibu') }}">
        @error('tempat_lahir_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Tanggal Lahir Ibu</label>
        <input class="form-control @error('tanggal_lahir_ibu') is-invalid @enderror" name="tanggal_lahir_ibu"
            type="date" value="{{ old('tanggal_lahir_ibu') }}">
        @error('tanggal_lahir_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pendidikan Ibu</label>
        <select class="form-control select2 @error('pendidikan_ibu') is-invalid @enderror" name="pendidikan_ibu">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'pendidikan_ibu') as $opt)
                <option value="{{ $opt }}" {{ old('pendidikan_ibu') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('pendidikan_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pekerjaan Ibu</label>
        <select class="form-control select2 @error('pekerjaan_ibu') is-invalid @enderror" name="pekerjaan_ibu">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'pekerjaan_ibu') as $opt)
                <option value="{{ $opt }}" {{ old('pekerjaan_ibu') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('pekerjaan_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Penghasilan Ibu</label>
        <select class="form-control select2 @error('penghasilan_ibu') is-invalid @enderror" name="penghasilan_ibu">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'penghasilan_ibu') as $opt)
                <option value="{{ $opt }}" {{ old('penghasilan_ibu') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('penghasilan_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>No HP Ibu</label>
        <input class="form-control @error('no_hp_ibu') is-invalid @enderror" name="no_hp_ibu" type="text"
            value="{{ old('no_hp_ibu') }}">
        @error('no_hp_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Status Tinggal Ibu</label>
        <select class="form-control select2 @error('status_tinggal_ibu') is-invalid @enderror"
            name="status_tinggal_ibu">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'status_tinggal_ibu') as $opt)
                <option value="{{ $opt }}" {{ old('status_tinggal_ibu') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('status_tinggal_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Domisili Ibu</label>
        <select class="form-control select2 @error('domisili_ibu') is-invalid @enderror" name="domisili_ibu">
            @foreach (\Helper::getEnumValues('siswa', 'domisili_ibu') as $opt)
                <option value="{{ $opt }}" {{ old('domisili_ibu') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('domisili_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Status Tempat Tinggal Ibu</label>
        <select class="form-control select2 @error('status_tempat_tinggal_ibu') is-invalid @enderror"
            name="status_tempat_tinggal_ibu">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'status_tempat_tinggal_ibu') as $opt)
                <option value="{{ $opt }}"
                    {{ old('status_tempat_tinggal_ibu') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
            @endforeach
        </select>
        @error('status_tempat_tinggal_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>


<div class="col-12">
    <div class="input-block local-forms">
        <label>Alamat Lengkap</label>
        <textarea class="form-control @error('alamat_ibu') is-invalid @enderror" name="alamat_ibu"
            rows="3">{{ old('alamat_ibu') }}</textarea>
        @error('alamat_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@include('components.form.wilayah', ['postFix' => '_ibu'])

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Kode Pos Ibu</label>
        <input class="form-control @error('kodepos_ibu') is-invalid @enderror" name="kodepos_ibu" type="text"
            value="{{ old('kodepos_ibu') }}">
        @error('kodepos_ibu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr>

{{-- ===================== DATA WALI ===================== --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Data Wali (Isi bila ada)</span></h5>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Nama Wali</label>
        <input class="form-control @error('nama_wali') is-invalid @enderror" name="nama_wali" type="text"
            value="{{ old('nama_wali') }}">
        @error('nama_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Status Wali</label>
        <select class="form-control select2 @error('status_wali') is-invalid @enderror" name="status_wali">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'status_wali') as $opt)
                <option value="{{ $opt }}" {{ old('status_wali') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('status_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Kewarnegaraan Wali</label>
        <select class="form-control select2 @error('kewarganegaraan_wali') is-invalid @enderror"
            name="kewarganegaraan_wali">
            @foreach (\Helper::getEnumValues('siswa', 'kewarganegaraan_wali') as $opt)
                <option value="{{ $opt }}" {{ old('kewarganegaraan_wali') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('kewarganegaraan_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>NIK Wali</label>
        <input class="form-control @error('nik_wali') is-invalid @enderror" name="nik_wali" type="text"
            value="{{ old('nik_wali') }}">
        @error('nik_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Tempat Lahir Wali</label>
        <input class="form-control @error('tempat_lahir_wali') is-invalid @enderror" name="tempat_lahir_wali"
            type="text" value="{{ old('tempat_lahir_wali') }}">
        @error('tempat_lahir_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="input-block local-forms">
        <label>Tanggal Lahir Wali</label>
        <input class="form-control @error('tanggal_lahir_wali') is-invalid @enderror" name="tanggal_lahir_wali"
            type="date" value="{{ old('tanggal_lahir_wali') }}">
        @error('tanggal_lahir_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pendidikan Wali</label>
        <select class="form-control select2 @error('pendidikan_wali') is-invalid @enderror" name="pendidikan_wali">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'pendidikan_wali') as $opt)
                <option value="{{ $opt }}" {{ old('pendidikan_wali') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('pendidikan_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Pekerjaan Wali</label>
        <select class="form-control select2 @error('pekerjaan_wali') is-invalid @enderror" name="pekerjaan_wali">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'pekerjaan_wali') as $opt)
                <option value="{{ $opt }}" {{ old('pekerjaan_wali') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('pekerjaan_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Penghasilan Wali</label>
        <select class="form-control select2 @error('penghasilan_wali') is-invalid @enderror" name="penghasilan_wali">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'penghasilan_wali') as $opt)
                <option value="{{ $opt }}" {{ old('penghasilan_wali') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('penghasilan_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>No HP Wali</label>
        <input class="form-control @error('no_hp_wali') is-invalid @enderror" name="no_hp_wali" type="text"
            value="{{ old('no_hp_wali') }}">
        @error('no_hp_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Domisili Wali</label>
        <select class="form-control select2 @error('domisili_wali') is-invalid @enderror" name="domisili_wali">
            @foreach (\Helper::getEnumValues('siswa', 'domisili_wali') as $opt)
                <option value="{{ $opt }}" {{ old('domisili_wali') === $opt ? 'selected' : '' }}>
                    {{ $opt }}</option>
            @endforeach
        </select>
        @error('domisili_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Status Tempat Tinggal Wali</label>
        <select class="form-control select2 @error('status_tempat_tinggal_wali') is-invalid @enderror"
            name="status_tempat_tinggal_wali">
            <option value="">Pilih</option>
            @foreach (\Helper::getEnumValues('siswa', 'status_tempat_tinggal_wali') as $opt)
                <option value="{{ $opt }}"
                    {{ old('status_tempat_tinggal_wali') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
            @endforeach
        </select>
        @error('status_tempat_tinggal_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12">
    <div class="input-block local-forms">
        <label>Alamat Lengkap</label>
        <textarea class="form-control @error('alamat_wali') is-invalid @enderror" name="alamat_wali"
            rows="3">{{ old('alamat_wali') }}</textarea>
        @error('alamat_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
@include('components.form.wilayah', ['postFix' => '_wali'])

<div class="col-12 col-md-6">
    <div class="input-block local-forms">
        <label>Kode Pos Wali</label>
        <input class="form-control @error('kodepos_wali') is-invalid @enderror" name="kodepos_wali" type="text"
            value="{{ old('kodepos_wali') }}">
        @error('kodepos_wali')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- UPLOAD FILE --}}
<div class="col-12 mt-4">
    <h5 class="form-title"><span>Upload Berkas</span></h5>
</div>
<div class="col-12">
    <div class="input-block local-top-form">
        <label class="local-top">
            Foto
        </label>

        <div class="settings-btn upload-files-avator">
            <input type="file" name="foto" id="foto"
                class="hide-input @error('foto') is-invalid @enderror" accept=".jpg, .jpeg, .png"
                onchange="handleFileUpload(this, 'file-info-foto', 'upload-label-foto')" />

            <label for="foto" id="file-info-foto" class="file-info-text">Belum ada file</label>
            <label for="foto" class="upload" id="upload-label-foto">Pilih File</label>
        </div>
        @error('avatar')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <div class="ms-2 mb-4 view-foto d-none">
            <small class="text-decoration-underline"><a href="" id="view-foto">Lihat Berkas <i
                        class="fa fa-eye"></i></a></small>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="input-block local-top-form">
        <label class="local-top">
            KK
        </label>

        <div class="settings-btn upload-files-avator">
            <input type="file" name="kk" id="kk"
                class="hide-input @error('kk') is-invalid @enderror" accept=".pdf .jpg, .jpeg, .png"
                onchange="handleFileUpload(this, 'file-info-kk', 'upload-label-kk')" />

            <label for="kk" id="file-info-kk" class="file-info-text">Belum ada file</label>
            <label for="kk" class="upload" id="upload-label-kk">Pilih File</label>
        </div>
        @error('kk')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <div class="ms-2 mb-4 view-kk d-none">
            <small class="text-decoration-underline"><a href="" id="view-kk">Lihat Berkas <i
                        class="fa fa-eye"></i></a></small>
        </div>

    </div>
</div>
<div class="col-12">
    <div class="input-block local-top-form">
        <label class="local-top">
            Akta Kelahiran
        </label>

        <div class="settings-btn upload-files-avator">
            <input type="file" name="akta_kelahiran" id="akta_kelahiran"
                class="hide-input @error('akta_kelahiran') is-invalid @enderror" accept=".pdf .jpg, .jpeg, .png"
                onchange="handleFileUpload(this, 'file-info-akta', 'upload-label-akta')" />

            <label for="akta_kelahiran" id="file-info-akta" class="file-info-text">Belum ada file</label>
            <label for="akta_kelahiran" class="upload" id="upload-label-akta">Pilih File</label>
        </div>
        @error('akta_kelahiran')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <div class="ms-2 mb-4 view-akta_kelahiran d-none">
            <small class="text-decoration-underline"><a href="" id="view-akta_kelahiran">Lihat Berkas <i
                        class="fa fa-eye"></i></a></small>
        </div>

    </div>
</div>
<div class="col-12">
    <div class="input-block local-top-form">
        <label class="local-top">
            Ijazah
        </label>

        <div class="settings-btn upload-files-avator">
            <input type="file" name="ijazah" id="ijazah"
                class="hide-input @error('ijazah') is-invalid @enderror" accept=".pdf .jpg, .jpeg, .png"
                onchange="handleFileUpload(this, 'file-info-ijazah', 'upload-label-ijazah')" />

            <label for="ijazah" id="file-info-ijazah" class="file-info-text">Belum ada file</label>
            <label for="ijazah" class="upload" id="upload-label-ijazah">Pilih File</label>
        </div>
        @error('ijazah')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <div class="ms-2 mb-4 view-ijazah d-none">
            <small class="text-decoration-underline"><a href="" id="view-ijazah">Lihat Berkas <i
                        class="fa fa-eye"></i></a></small>
        </div>

    </div>
</div>
<div class="col-12">
    <div class="input-block local-top-form">
        <label class="local-top">
            Pakta Integritas
        </label>

        <div class="settings-btn upload-files-avator">
            <input type="file" name="pakta_integritas" id="pakta_integritas"
                class="hide-input @error('ijazah') is-invalid @enderror" accept=".pdf .jpg, .jpeg, .png"
                onchange="handleFileUpload(this, 'file-info-pakta_integritas', 'upload-label-pakta_integritas')" />

            <label for="pakta_integritas" id="file-info-pakta_integritas" class="file-info-text">Belum ada file</label>
            <label for="pakta_integritas" class="upload" id="upload-label-pakta_integritas">Pilih File</label>
        </div>
        @error('pakta_integritas')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <div class="ms-2 mb-4 view-pakta_integritas d-none">
            <small class="text-decoration-underline"><a href="" id="view-pakta_integritas">Lihat Berkas <i
                        class="fa fa-eye"></i></a></small>
        </div>

    </div>
</div>


{{-- TOMBOL SUBMIT --}}
<div class="col-12 mt-5">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <a href="{{ route('admin.pendaftaran-siswa-baru.index') }}"
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
