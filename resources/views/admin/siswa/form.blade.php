<div class="row">

    {{-- ===================== 1. DATA AKUN & AKADEMIK ===================== --}}
    <div class="col-12">
        <h5 class="form-title border-bottom pb-2"><span>1. Data Akun & Akademik</span></h5>
    </div>

    {{-- Baris 1: Kelas, Kurikulum, Tahun Pelajaran --}}
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Status</label>
            <select class="form-control select2 @error('status') is-invalid @enderror" name="status">
                <option value="">Pilih Status</option>
                @foreach ($status as $item)
                    <option value="{{ $item }}" {{ old('status') == $item ? 'selected' : '' }}>
                        {{ $item }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Kelas</label>
            <select class="form-control select2 @error('kelas_id') is-invalid @enderror" name="kelas_id">
                <option value="">Pilih Kelas</option>
                @foreach ($kelas as $item)
                    <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->angka }} ({{ $item->unitSekolah->nama_unit }})
                    </option>
                @endforeach
            </select>
            @error('kelas_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Kurikulum <span class="login-danger">*</span></label>
            <select class="form-control select2 @error('kurikulum_id') is-invalid @enderror" name="kurikulum_id"
                required>
                <option value="">Pilih Kurikulum</option>
                @foreach ($kurikulum as $item)
                    <option value="{{ $item->id }}" {{ old('kurikulum_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
            @error('kurikulum_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Tahun Pelajaran <span class="login-danger">*</span></label>
            <select class="form-control select2 @error('tahun_pelajaran_id') is-invalid @enderror"
                name="tahun_pelajaran_id" required>
                <option value="">Pilih Tahun</option>
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

    {{-- Baris 2: Email, Jurusan --}}

    <div class="col-12 col-md-4">
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

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Email</label>
            <input class="form-control @error('email') is-invalid @enderror" name="email" type="text"
                value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>


    {{-- ===================== 2. INFORMASI PRIBADI SISWA ===================== --}}
    <div class="col-12 mt-4">
        <h5 class="form-title border-bottom pb-2"><span>2. Informasi Pribadi Siswa</span></h5>
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
            <label>Jenis Kelamin <span class="login-danger">*</span></label>
            <select class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin"
                required>
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

    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Kewarganegaraan <span class="login-danger">*</span></label>
            <select class="form-control select2 @error('kewarganegaraan') is-invalid @enderror" name="kewarganegaraan"
                required>
                @foreach (\Helper::getEnumValues('siswa', 'kewarganegaraan') as $opt)
                    <option value="{{ $opt }}"
                        {{ old('kewarganegaraan', 'WNI') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
            @error('kewarganegaraan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Group Identitas Nomor --}}
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>NIK Anak</label>
            <input class="form-control @error('nik') is-invalid @enderror" name="nik" type="text"
                value="{{ old('nik') }}">
            @error('nik')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>NISN</label>
            <input class="form-control @error('nisn') is-invalid @enderror" name="nisn" type="text"
                value="{{ old('nisn') }}">
            @error('nisn')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>NIS</label>
            <input class="form-control @error('nis') is-invalid @enderror" name="nis" type="text"
                value="{{ old('nis') }}">
            @error('nis')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="input-block local-forms">
            <label>NPSN</label>
            <input class="form-control @error('npsn') is-invalid @enderror" name="npsn" type="text"
                value="{{ old('npsn') }}">
            @error('npsn')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="input-block local-forms">
            <label>NSM</label>
            <input class="form-control @error('nsm') is-invalid @enderror" name="nsm" type="text"
                value="{{ old('nsm') }}">
            @error('nsm')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Kelahiran & Agama --}}
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Tempat Lahir <span class="login-danger">*</span></label>
            <input class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir"
                type="text" value="{{ old('tempat_lahir') }}" required>
            @error('tempat_lahir')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Tanggal Lahir <span class="login-danger">*</span></label>
            <input class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir"
                type="date" value="{{ old('tanggal_lahir') }}" required>
            @error('tanggal_lahir')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
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

    {{-- Detail Lainnya --}}
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Anak Ke-</label>
            <input class="form-control @error('anak_ke') is-invalid @enderror" name="anak_ke" type="number"
                value="{{ old('anak_ke') }}">
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Jml Saudara</label>
            <input class="form-control @error('jml_saudara') is-invalid @enderror" name="jml_saudara" type="number"
                value="{{ old('jml_saudara') }}">
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Cita-cita</label>
            <select class="form-control select2" name="cita_cita">
                <option value="">Pilih...</option>
                @foreach (\Helper::getEnumValues('siswa', 'cita_cita') as $opt)
                    <option value="{{ $opt }}" {{ old('cita_cita') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Hobi</label>
            <select class="form-control select2" name="hobi">
                <option value="">Pilih...</option>
                @foreach (\Helper::getEnumValues('siswa', 'hobi') as $opt)
                    <option value="{{ $opt }}" {{ old('hobi') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="input-block local-forms">
            <label>Asal Sekolah</label>
            <input class="form-control @error('asal_sekolah') is-invalid @enderror" name="asal_sekolah"
                type="text" value="{{ old('asal_sekolah') }}">
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="input-block local-forms">
            <label>No. HP Siswa</label>
            <input class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" type="text"
                value="{{ old('no_hp') }}">
        </div>
    </div>


    {{-- ===================== 3. ALAMAT SISWA ===================== --}}
    <div class="col-12 mt-4">
        <h5 class="form-title border-bottom pb-2"><span>3. Alamat Siswa (Sesuai KK)</span></h5>
    </div>

    <div class="col-12 col-md-12">
        <div class="input-block local-forms">
            <label>Alamat Lengkap (Jalan, RT/RW)</label>
            <textarea class="form-control @error('alamat_anak_sesuai_kk') is-invalid @enderror" name="alamat_anak_sesuai_kk"
                rows="2">{{ old('alamat_anak_sesuai_kk') }}</textarea>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="input-block local-forms">
            <label>Jalan/Dusun</label>
            <input class="form-control @error('jalan_dusun') is-invalid @enderror" name="jalan_dusun" type="text"
                value="{{ old('jalan_dusun') }}">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="input-block local-forms">
            <label>Status Tempat Tinggal</label>
            <select class="form-control select2" name="tempat_tinggal_siswa">
                <option value="">Pilih Status</option>
                @foreach (\Helper::getEnumValues('siswa', 'tempat_tinggal_siswa') as $opt)
                    <option value="{{ $opt }}" {{ old('tempat_tinggal_siswa') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Komponen Wilayah (Provinsi, Kota, dll) --}}
    @include('components.form.wilayah', ['postFix' => ''])

    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Kode Pos</label>
            <input class="form-control" name="kodepos" type="text" value="{{ old('kodepos') }}">
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Transportasi</label>
            <select class="form-control select2" name="transportasi">
                <option value="">Pilih...</option>
                @foreach (\Helper::getEnumValues('siswa', 'transportasi') as $opt)
                    <option value="{{ $opt }}" {{ old('transportasi') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Jarak Rumah</label>
            <select class="form-control select2" name="jarak">
                <option value="">Pilih...</option>
                @foreach (\Helper::getEnumValues('siswa', 'jarak') as $opt)
                    <option value="{{ $opt }}" {{ old('jarak') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Waktu Tempuh</label>
            <select class="form-control select2" name="waktu">
                <option value="">Pilih...</option>
                @foreach (\Helper::getEnumValues('siswa', 'waktu') as $opt)
                    <option value="{{ $opt }}" {{ old('waktu') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="input-block local-forms">
            <label>Koordinat Rumah</label>
            <input class="form-control" name="kordinat_rumah" type="text" value="{{ old('kordinat_rumah') }}"
                placeholder="-6.200000, 106.816666">
        </div>
    </div>


    {{-- ===================== 4. DATA KELUARGA & KESEHATAN ===================== --}}
    <div class="col-12 mt-4">
        <h5 class="form-title border-bottom pb-2"><span>4. Data Keluarga (KK & KIP) & Kesehatan</span></h5>
    </div>

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>No KK</label>
            <input class="form-control @error('no_kk') is-invalid @enderror" name="no_kk" type="text"
                value="{{ old('no_kk') }}">
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Nama Kepala Keluarga</label>
            <input class="form-control" name="kepala_keluarga" type="text" value="{{ old('kepala_keluarga') }}">
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>No KIP (Jika ada)</label>
            <input class="form-control" name="no_kip" type="text" value="{{ old('no_kip') }}">
        </div>
    </div>

    <div class="col-12 mt-2">
        <h6 class="text-muted mb-3">Riwayat Kesehatan & Imunisasi</h6>
    </div>

    @foreach (['tk_ra' => 'Pernah TK/RA', 'paud' => 'PAUD', 'hepatitis_b' => 'Hepatitis B', 'polio' => 'Polio', 'bcg' => 'BCG', 'campak' => 'Campak', 'dpt' => 'DPT', 'covid' => 'COVID'] as $field => $label)
        <div class="col-6 col-md-3">
            <div class="input-block local-forms">
                <label>{{ $label }}</label>
                <select class="form-control select2" name="{{ $field }}">
                    <option value="">Pilih...</option>
                    @foreach (\Helper::getEnumValues('siswa', $field) as $opt)
                        <option value="{{ $opt }}" {{ old($field) === $opt ? 'selected' : '' }}>
                            {{ $opt }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endforeach


    {{-- ===================== 5. DATA ORANG TUA (AYAH) ===================== --}}
    <div class="col-12 mt-4">
        <h5 class="form-title border-bottom pb-2"><span>5. Data Ayah Kandung</span></h5>
    </div>

    <div class="col-12 col-md-6">
        <div class="input-block local-forms">
            <label>Nama Ayah</label>
            <input class="form-control @error('nama_ayah') is-invalid @enderror" name="nama_ayah" type="text"
                value="{{ old('nama_ayah') }}">
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Status Ayah</label>
            <select class="form-control select2" name="status_ayah">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'status_ayah') as $opt)
                    <option value="{{ $opt }}" {{ old('status_ayah') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>NIK Ayah</label>
            <input class="form-control" name="nik_ayah" type="text" value="{{ old('nik_ayah') }}">
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Tempat Lahir</label>
            <input class="form-control" name="tempat_lahir_ayah" type="text"
                value="{{ old('tempat_lahir_ayah') }}">
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Tanggal Lahir</label>
            <input class="form-control" name="tanggal_lahir_ayah" type="date"
                value="{{ old('tanggal_lahir_ayah') }}">
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Kewarganegaraan</label>
            <select class="form-control select2" name="kewarganegaraan_ayah">
                @foreach (\Helper::getEnumValues('siswa', 'kewarganegaraan_ayah') as $opt)
                    <option value="{{ $opt }}" {{ old('kewarganegaraan_ayah') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Pendidikan</label>
            <select class="form-control select2" name="pendidikan_ayah">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'pendidikan_ayah') as $opt)
                    <option value="{{ $opt }}" {{ old('pendidikan_ayah') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Pekerjaan</label>
            <select class="form-control select2" name="pekerjaan_ayah">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'pekerjaan_ayah') as $opt)
                    <option value="{{ $opt }}" {{ old('pekerjaan_ayah') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Penghasilan</label>
            <select class="form-control select2" name="penghasilan_ayah">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'penghasilan_ayah') as $opt)
                    <option value="{{ $opt }}" {{ old('penghasilan_ayah') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>No HP Ayah</label>
            <input class="form-control" name="no_hp_ayah" type="text" value="{{ old('no_hp_ayah') }}">
        </div>
    </div>

    <div class="col-12">
        <div class="input-block local-forms">
            <label>Alamat Ayah</label>
            <textarea class="form-control" name="alamat_ayah" rows="2">{{ old('alamat_ayah') }}</textarea>
        </div>
    </div>
    @include('components.form.wilayah', ['postFix' => '_ayah'])

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Kode Pos Ayah</label>
            <input class="form-control" name="kodepos_ayah" type="text" value="{{ old('kodepos_ayah') }}">
        </div>
    </div>


    {{-- ===================== 6. DATA ORANG TUA (IBU) ===================== --}}
    <div class="col-12 mt-4">
        <h5 class="form-title border-bottom pb-2"><span>6. Data Ibu Kandung</span></h5>
    </div>

    <div class="col-12 col-md-6">
        <div class="input-block local-forms">
            <label>Nama Ibu</label>
            <input class="form-control @error('nama_ibu') is-invalid @enderror" name="nama_ibu" type="text"
                value="{{ old('nama_ibu') }}">
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Status Ibu</label>
            <select class="form-control select2" name="status_ibu">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'status_ibu') as $opt)
                    <option value="{{ $opt }}" {{ old('status_ibu') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>NIK Ibu</label>
            <input class="form-control" name="nik_ibu" type="text" value="{{ old('nik_ibu') }}">
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Tempat Lahir</label>
            <input class="form-control" name="tempat_lahir_ibu" type="text"
                value="{{ old('tempat_lahir_ibu') }}">
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Tanggal Lahir</label>
            <input class="form-control" name="tanggal_lahir_ibu" type="date"
                value="{{ old('tanggal_lahir_ibu') }}">
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Kewarganegaraan</label>
            <select class="form-control select2" name="kewarganegaraan_ibu">
                @foreach (\Helper::getEnumValues('siswa', 'kewarganegaraan_ibu') as $opt)
                    <option value="{{ $opt }}"
                        {{ old('kewarganegaraan_ibu') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Pendidikan</label>
            <select class="form-control select2" name="pendidikan_ibu">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'pendidikan_ibu') as $opt)
                    <option value="{{ $opt }}" {{ old('pendidikan_ibu') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Pekerjaan</label>
            <select class="form-control select2" name="pekerjaan_ibu">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'pekerjaan_ibu') as $opt)
                    <option value="{{ $opt }}" {{ old('pekerjaan_ibu') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Penghasilan</label>
            <select class="form-control select2" name="penghasilan_ibu">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'penghasilan_ibu') as $opt)
                    <option value="{{ $opt }}" {{ old('penghasilan_ibu') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>No HP Ibu</label>
            <input class="form-control" name="no_hp_ibu" type="text" value="{{ old('no_hp_ibu') }}">
        </div>
    </div>

    <div class="col-12">
        <div class="input-block local-forms">
            <label>Alamat Ibu</label>
            <textarea class="form-control" name="alamat_ibu" rows="2">{{ old('alamat_ibu') }}</textarea>
        </div>
    </div>
    @include('components.form.wilayah', ['postFix' => '_ibu'])

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Kode Pos Ibu</label>
            <input class="form-control" name="kodepos_ibu" type="text" value="{{ old('kodepos_ibu') }}">
        </div>
    </div>


    {{-- ===================== 7. DATA WALI (OPSIONAL) ===================== --}}
    <div class="col-12 mt-4">
        <h5 class="form-title border-bottom pb-2"><span>7. Data Wali (Isi bila ada)</span></h5>
    </div>

    <div class="col-12 col-md-6">
        <div class="input-block local-forms">
            <label>Nama Wali</label>
            <input class="form-control" name="nama_wali" type="text" value="{{ old('nama_wali') }}">
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Status Wali</label>
            <select class="form-control select2" name="status_wali">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'status_wali') as $opt)
                    <option value="{{ $opt }}" {{ old('status_wali') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>NIK Wali</label>
            <input class="form-control" name="nik_wali" type="text" value="{{ old('nik_wali') }}">
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Tempat Lahir</label>
            <input class="form-control" name="tempat_lahir_wali" type="text"
                value="{{ old('tempat_lahir_wali') }}">
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Tanggal Lahir</label>
            <input class="form-control" name="tanggal_lahir_wali" type="date"
                value="{{ old('tanggal_lahir_wali') }}">
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Kewarganegaraan</label>
            <select class="form-control select2" name="kewarganegaraan_wali">
                @foreach (\Helper::getEnumValues('siswa', 'kewarganegaraan_wali') as $opt)
                    <option value="{{ $opt }}"
                        {{ old('kewarganegaraan_wali') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Pendidikan</label>
            <select class="form-control select2" name="pendidikan_wali">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'pendidikan_wali') as $opt)
                    <option value="{{ $opt }}" {{ old('pendidikan_wali') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Pekerjaan</label>
            <select class="form-control select2" name="pekerjaan_wali">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'pekerjaan_wali') as $opt)
                    <option value="{{ $opt }}" {{ old('pekerjaan_wali') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>Penghasilan</label>
            <select class="form-control select2" name="penghasilan_wali">
                <option value="">Pilih</option>
                @foreach (\Helper::getEnumValues('siswa', 'penghasilan_wali') as $opt)
                    <option value="{{ $opt }}" {{ old('penghasilan_wali') === $opt ? 'selected' : '' }}>
                        {{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="input-block local-forms">
            <label>No HP Wali</label>
            <input class="form-control" name="no_hp_wali" type="text" value="{{ old('no_hp_wali') }}">
        </div>
    </div>

    <div class="col-12">
        <div class="input-block local-forms">
            <label>Alamat Wali</label>
            <textarea class="form-control" name="alamat_wali" rows="2">{{ old('alamat_wali') }}</textarea>
        </div>
    </div>
    @include('components.form.wilayah', ['postFix' => '_wali'])
    <div class="col-12 col-md-4">
        <div class="input-block local-forms">
            <label>Kode Pos Wali</label>
            <input class="form-control" name="kodepos_wali" type="text" value="{{ old('kodepos_wali') }}">
        </div>
    </div>


    {{-- ===================== 8. UPLOAD BERKAS ===================== --}}
    <div class="col-12 mt-4">
        <h5 class="form-title border-bottom pb-2"><span>8. Upload Berkas</span></h5>
    </div>

    {{-- File: Pas Foto --}}
    <div class="col-12 col-md-4 mb-3">
        <div class="input-block local-top-form">
            <label class="local-top">Foto Siswa</label>
            <div class="settings-btn upload-files-avator">
                <input type="file" name="foto" id="foto"
                    class="hide-input @error('foto') is-invalid @enderror" accept=".jpg, .jpeg, .png"
                    onchange="handleFileUpload(this, 'file-info-foto', 'upload-label-foto')" />
                <label for="foto" id="file-info-foto" class="file-info-text text-truncate">Belum ada file</label>
                <label for="foto" class="upload" id="upload-label-foto">Pilih</label>
            </div>
            @error('foto')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="ms-2 view-foto d-none">
                <small class="text-decoration-underline"><a href="" id="view-foto">Lihat Berkas <i
                            class="fa fa-eye"></i></a></small>
            </div>
        </div>
    </div>

    {{-- File: KK --}}
    <div class="col-12 col-md-4 mb-3">
        <div class="input-block local-top-form">
            <label class="local-top">Kartu Keluarga (KK)</label>
            <div class="settings-btn upload-files-avator">
                <input type="file" name="kk" id="kk"
                    class="hide-input @error('kk') is-invalid @enderror" accept=".pdf, .jpg, .jpeg, .png"
                    onchange="handleFileUpload(this, 'file-info-kk', 'upload-label-kk')" />
                <label for="kk" id="file-info-kk" class="file-info-text text-truncate">Belum ada file</label>
                <label for="kk" class="upload" id="upload-label-kk">Pilih</label>
            </div>
            @error('kk')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="ms-2 view-kk d-none">
                <small class="text-decoration-underline"><a href="" id="view-kk">Lihat Berkas <i
                            class="fa fa-eye"></i></a></small>
            </div>
        </div>
    </div>

    {{-- File: Akta --}}
    <div class="col-12 col-md-4 mb-3">
        <div class="input-block local-top-form">
            <label class="local-top">Akta Kelahiran</label>
            <div class="settings-btn upload-files-avator">
                <input type="file" name="akta_kelahiran" id="akta_kelahiran"
                    class="hide-input @error('akta_kelahiran') is-invalid @enderror" accept=".pdf, .jpg, .jpeg, .png"
                    onchange="handleFileUpload(this, 'file-info-akta', 'upload-label-akta')" />
                <label for="akta_kelahiran" id="file-info-akta" class="file-info-text text-truncate">Belum ada
                    file</label>
                <label for="akta_kelahiran" class="upload" id="upload-label-akta">Pilih</label>
            </div>
            @error('akta_kelahiran')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="ms-2 view-akta_kelahiran d-none">
                <small class="text-decoration-underline"><a href="" id="view-akta_kelahiran">Lihat Berkas <i
                            class="fa fa-eye"></i></a></small>
            </div>
        </div>
    </div>

    {{-- File: Ijazah --}}
    <div class="col-12 col-md-6 mb-3">
        <div class="input-block local-top-form">
            <label class="local-top">Ijazah Terakhir</label>
            <div class="settings-btn upload-files-avator">
                <input type="file" name="ijazah" id="ijazah"
                    class="hide-input @error('ijazah') is-invalid @enderror" accept=".pdf, .jpg, .jpeg, .png"
                    onchange="handleFileUpload(this, 'file-info-ijazah', 'upload-label-ijazah')" />
                <label for="ijazah" id="file-info-ijazah" class="file-info-text text-truncate">Belum ada
                    file</label>
                <label for="ijazah" class="upload" id="upload-label-ijazah">Pilih</label>
            </div>
            @error('ijazah')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="ms-2 view-ijazah d-none">
                <small class="text-decoration-underline"><a href="" id="view-ijazah">Lihat Berkas <i
                            class="fa fa-eye"></i></a></small>
            </div>
        </div>
    </div>

    {{-- File: Pakta --}}
    <div class="col-12 col-md-6 mb-3">
        <div class="input-block local-top-form">
            <label class="local-top">Pakta Integritas</label>
            <div class="settings-btn upload-files-avator">
                <input type="file" name="pakta_integritas" id="pakta_integritas"
                    class="hide-input @error('pakta_integritas') is-invalid @enderror"
                    accept=".pdf, .jpg, .jpeg, .png"
                    onchange="handleFileUpload(this, 'file-info-pakta_integritas', 'upload-label-pakta_integritas')" />
                <label for="pakta_integritas" id="file-info-pakta_integritas"
                    class="file-info-text text-truncate">Belum ada file</label>
                <label for="pakta_integritas" class="upload" id="upload-label-pakta_integritas">Pilih</label>
            </div>
            @error('pakta_integritas')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="ms-2 view-pakta_integritas d-none">
                <small class="text-decoration-underline"><a href="" id="view-pakta_integritas">Lihat Berkas <i
                            class="fa fa-eye"></i></a></small>
            </div>
        </div>
    </div>

    {{-- TOMBOL SUBMIT --}}
    <div class="col-12 mt-5">
        <div class="doctor-submit text-end">
            <button type="submit" class="btn btn-primary submit-form me-2">Simpan Data</button>
            <a href="{{ route('admin.pendaftaran-siswa-baru.index') }}"
                class="btn btn-secondary cancel-form">Batalkan</a>
        </div>
    </div>

</div> {{-- End Row --}}

@push('script')
    <script>
        function handleFileUpload(input, fileInfoId, uploadLabelId) {
            const fileInfo = document.getElementById(fileInfoId);
            const uploadLabel = document.getElementById(uploadLabelId);
            const file = input.files[0];

            if (file) {
                // Modifikasi: Tidak hanya cek image/ tapi tampilkan nama file apapun yang dipilih (PDF/JPG)
                // Karena di HTML accept sudah dibatasi
                fileInfo.innerText = file.name;
                uploadLabel.innerText = "Ganti";

                // Opsional: Cek tipe file jika ingin validasi strict via JS
                // const validTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                // if (!validTypes.includes(file.type)) { ... }

            } else {
                fileInfo.innerText = "Belum ada file";
                uploadLabel.innerText = "Pilih";
            }
        }
    </script>
@endpush
@push('css')
    <style>
        .form-title {
            margin-bottom: 24px;
            font-weight: bold;
            color: #2e384d;
            /* Sesuaikan warna tema */
        }

        .text-truncate {
            max-width: 200px;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
@endpush
