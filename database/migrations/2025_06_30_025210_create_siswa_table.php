<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('kelas_id')->nullable()->constrained('kelas');
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajaran');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('kurikulum_id')->constrained('kurikulum');

            // Student Information
            $table->string('nama_siswa');
            $table->enum('kewarganegaraan', ['WNI', 'WNA']);
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusan');
            $table->string('nis')->unique()->nullable();
            $table->string('nisn')->unique()->nullable();
            $table->string('nik')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('asal_sekolah')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jml_saudara')->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Khatolik', 'Hindu', 'Budha', 'Kong Hu Cu'])->default('Islam');
            $table->enum('cita_cita', ["PNS", "TNI/Polri", "Guru/Dosen", "Dokter", "Politikus", "Wiraswasta", "Seniman/Artis", "Ilmuwan", "Agamawan", "Lainnya"])->nullable();
            $table->string('no_hp')->nullable();
            $table->enum('hobi', ['Olahraga', 'Kesenian', 'Membaca', 'Menulis', 'Jalan-jalan', 'Lainnya'])->nullable();

            // Student Address
            $table->enum('tempat_tinggal_siswa', ["Tinggal dengan Ortu/Wali", "Ikut Saudara/Kerabat", "Asrama Madrasah", "Kontrak/kost", "Tinggal di asrama pesantren", "Panti asuhan", "Rumah singgah", "Lainnya"])->nullable();
            $table->text('alamat_anak_sesuai_kk')->nullable();
            $table->string('jalan_dusun')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kab_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kordinat_rumah')->nullable();
            $table->string('kodepos')->nullable();
            $table->enum('transportasi', ["Jalan kaki", "Sepeda", "Sepeda motor", "Mobil pribadi", "Antar jemput sekolah", "Angkutan umum", "Perahu/sampan", "Lainnya"])->nullable();
            $table->enum('jarak', ["Kurang dari 5 km", "Antara 5-10 km", "Antara 11-20 km", "Antara 21-30 km", "Lebih dari 30 km"])->nullable();
            $table->enum('waktu', ["1-10 menit", "10-19 menit", "20-29 menit", "30-39 menit", "1-2 jam", ">2 jam"])->nullable();
            $table->string('nsm')->nullable();
            $table->string('npsn')->nullable();

            $table->enum('biaya_sekolah', ["Orangtua", "Wali/orangtua asuh", "Tanggungan Sendiri", "Lainnya"])->nullable();
            $table->enum('keb_khusus', ["Tidak ada", "Lamban belajar", "Kesulitan belajar spesifik", "Gangguan komunikasi", "Berbakat/memiliki kemampuan", "Lainnya"])->nullable();
            $table->enum('keb_disabilitas', ["Tidak ada", "Tuna Netra", "Tuna Rungu", "Tuna Daksa", "Tuna Grahita", "Tuna Laras", "Lainnya"])->nullable();
            $table->enum('tk_ra', ['Y', 'T'])->nullable();
            $table->enum('paud', ['Y', 'T'])->nullable();
            $table->enum('hepatitis_b', ['Y', 'T'])->nullable();
            $table->enum('polio', ['Y', 'T'])->nullable();
            $table->enum('bcg', ['Y', 'T'])->nullable();
            $table->enum('campak', ['Y', 'T'])->nullable();
            $table->enum('dpt', ['Y', 'T'])->nullable();
            $table->enum('covid', ['Y', 'T'])->nullable();
            $table->string('no_kip')->nullable();
            $table->string('kepala_keluarga')->nullable();

            $table->string('foto')->nullable();

            // Family Information (Parents)
            $table->string('nama_ayah')->nullable();
            $table->enum('status_ayah', ['Masih Hidup', 'Sudah Meninggal', 'Tidak Diketahui'])->nullable();
            $table->enum('kewarganegaraan_ayah', ['WNI', 'WNA'])->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->enum('pendidikan_ayah', ["SD/Sederajat", "SMP/Sederajat", "SMA/Sederajat", "D1", "D2", "D3", "D4/S1", "S2", "S3", "Tidak Bersekolah"])->nullable();
            $table->enum('pekerjaan_ayah', ["Tidak Bekerja", "Pensiunan", "PNS", "TNI/Polisi", "Guru/Dosen", "Pegawai Swasta", "Wiraswasta", "Pengacara/Jaksa/Hakim/No", "Seniman/Pelukis/Artis/Seje", "Dokter/Bidan/Perawat", "Pilot/Pramugara", "Pedagang", "Petani/Peternak", "Nelayan", "Buruh (Tani/Pabrik/Banguna", "Sopir/Masinis/Kondektur", "Politikus", "Lainnya"])->nullable();
            $table->enum('penghasilan_ayah',["Kurang dari 500.000","500.000 - 1.000.000","1.000.001 - 2.000.000","2.000.001 - 3.000.000","3.000.001 - 5.000.000","Lebih dari 5.000.000","Tidak ada"])->nullable();
            $table->string('no_hp_ayah')->nullable();
            $table->enum('domisili_ayah', ['Dalam Negeri', 'Luar Negeri'])->nullable();
            $table->enum('status_tempat_tinggal_ayah', ["Milik Sendiri","Rumah Orangtua","Rumah Saudara/Kerabat","Rumah Dinas","Sewa/Kontrak","Lainnya"])->nullable();
            $table->string('desa_keluarahan_ayah')->nullable();
            $table->string('kecamatan_ayah')->nullable();
            $table->string('kab_kota_ayah')->nullable();
            $table->string('provinsi_ayah')->nullable();
            $table->string('kodepos_ayah')->nullable();
            $table->string('alamat_ayah')->nullable();

            $table->string('nama_ibu')->nullable();
            $table->enum('status_ibu', ['Masih Hidup', 'Sudah Meninggal', 'Tidak Diketahui'])->nullable();
            $table->enum('kewarganegaraan_ibu', ['WNI', 'WNA'])->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('tempat_lahir_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->enum('pendidikan_ibu', ["SD/Sederajat", "SMP/Sederajat", "SMA/Sederajat", "D1", "D2", "D3", "D4/S1", "S2", "S3", "Tidak Bersekolah"])->nullable();
            $table->enum('pekerjaan_ibu', ["Tidak Bekerja", "Pensiunan", "PNS", "TNI/Polisi", "Guru/Dosen", "Pegawai Swasta", "Wiraswasta", "Pengacara/Jaksa/Hakim/No", "Seniman/Pelukis/Artis/Seje", "Dokter/Bidan/Perawat", "Pilot/Pramugara", "Pedagang", "Petani/Peternak", "Nelayan", "Buruh (Tani/Pabrik/Banguna", "Sopir/Masinis/Kondektur", "Politikus", "Lainnya"])->nullable();
            $table->enum('penghasilan_ibu',["Kurang dari 500.000","500.000 - 1.000.000","1.000.001 - 2.000.000","2.000.001 - 3.000.000","3.000.001 - 5.000.000","Lebih dari 5.000.000","Tidak ada"])->nullable();
            $table->string('no_hp_ibu')->nullable();
            $table->enum('status_tinggal_ibu', ['Beda Dengan Ayah', 'Sama Dengan Ayah'])->nullable();
            $table->enum('domisili_ibu', ['Dalam Negeri', 'Luar Negeri'])->nullable();
            $table->enum('status_tempat_tinggal_ibu', ["Milik Sendiri","Rumah Orangtua","Rumah Saudara/Kerabat","Rumah Dinas","Sewa/Kontrak","Lainnya"])->nullable();
            $table->string('desa_keluarahan_ibu')->nullable();
            $table->string('kecamatan_ibu')->nullable();
            $table->string('kab_kota_ibu')->nullable();
            $table->string('provinsi_ibu')->nullable();
            $table->string('kodepos_ibu')->nullable();
            $table->string('alamat_ibu')->nullable();

            $table->string('nama_wali')->nullable();
            $table->enum('status_wali', ['Sama Dengan Ayah', 'Sama Dengan Ibu', 'Lainnya'])->nullable();
            $table->enum('kewarganegaraan_wali', ['WNI', 'WNA'])->nullable();
            $table->string('nik_wali')->nullable();
            $table->string('tempat_lahir_wali')->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->enum('pendidikan_wali', ["SD/Sederajat", "SMP/Sederajat", "SMA/Sederajat", "D1", "D2", "D3", "D4/S1", "S2", "S3", "Tidak Bersekolah"])->nullable();
            $table->enum('pekerjaan_wali', ["Tidak Bekerja", "Pensiunan", "PNS", "TNI/Polisi", "Guru/Dosen", "Pegawai Swasta", "Wiraswasta", "Pengacara/Jaksa/Hakim/No", "Seniman/Pelukis/Artis/Seje", "Dokter/Bidan/Perawat", "Pilot/Pramugara", "Pedagang", "Petani/Peternak", "Nelayan", "Buruh (Tani/Pabrik/Banguna", "Sopir/Masinis/Kondektur", "Politikus", "Lainnya"])->nullable();
            $table->enum('penghasilan_wali',["Kurang dari 500.000","500.000 - 1.000.000","1.000.001 - 2.000.000","2.000.001 - 3.000.000","3.000.001 - 5.000.000","Lebih dari 5.000.000","Tidak ada"])->nullable();
            $table->string('no_hp_wali')->nullable();
            $table->enum('domisili_wali', ['Dalam Negeri', 'Luar Negeri'])->nullable();
            $table->enum('status_tempat_tinggal_wali', ["Milik Sendiri","Rumah Orangtua","Rumah Saudara/Kerabat","Rumah Dinas","Sewa/Kontrak","Lainnya"])->nullable();
            $table->string('desa_keluarahan_wali')->nullable();
            $table->string('kecamatan_wali')->nullable();
            $table->string('kab_kota_wali')->nullable();
            $table->string('provinsi_wali')->nullable();
            $table->string('kodepos_wali')->nullable();
            $table->string('alamat_wali')->nullable();

            $table->string('kk')->nullable();
            $table->string('akta_kelahiran')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('pakta_integritas')->nullable();

            $table->enum('status_daftar', ['daftar', 'diterima', 'tidak diterima'])->default('daftar');
            $table->enum('status', ['aktif', 'tidak aktif', 'cuti', 'pindah', 'lulus'])->default('aktif');
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
