<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Kurikulum;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        // Username angka 10 digit
        $username = $this->faker->unique()->numerify('##########');

        // Gender & nama sesuai gender
        $gender = $this->faker->randomElement(['Laki-laki', 'Perempuan']);
        $name   = $gender === 'Laki-laki' ? $this->faker->name('male') : $this->faker->name('female');

        // Buat user baru
        $user = User::factory()->siswa()->create([
            'username'      => $username,
            'name'          => $name,
            'jenis_kelamin' => $gender,
        ]);

        return [
            // FK
            'kelas_id'           => Kelas::inRandomOrder()->value('id') ?? 1,
            'tahun_pelajaran_id' => TahunPelajaran::inRandomOrder()->value('id') ?? 1,
            'user_id'            => $user->id,
            'kurikulum_id'       => Kurikulum::inRandomOrder()->value('id') ?? 1,

            // Student Information (SAMA DENGAN MIGRATION TERBARU)
            'nama_siswa'     => $user->name,
            'kewarganegaraan' => $this->faker->randomElement(['WNI', 'WNA']),
            'jurusan_id'     => 1,
            'nis'            => $user->username,
            'nisn'           => $this->faker->unique()->numerify('##########'),
            'nik'            => $this->faker->numerify('################'),
            'tempat_lahir'   => $this->faker->city,
            'tanggal_lahir'  => $this->faker->dateTimeBetween('2010-01-01', '2019-12-31')->format('Y-m-d'),
            'jenis_kelamin'  => $user->jenis_kelamin,
            'asal_sekolah'   => $this->faker->company,
            'anak_ke'        => $this->faker->numberBetween(1, 5),
            'jml_saudara'    => $this->faker->numberBetween(0, 6),
            'agama'          => $this->faker->randomElement(['Islam', 'Kristen', 'Khatolik', 'Hindu', 'Budha', 'Kong Hu Cu']),
            'cita_cita'      => $this->faker->randomElement(["PNS", "TNI/Polri", "Guru/Dosen", "Dokter", "Politikus", "Wiraswasta", "Seniman/Artis", "Ilmuwan", "Agamawan", "Lainnya"]),
            'no_hp'          => $this->faker->numerify('08##########'),
            'hobi'           => $this->faker->randomElement(['Olahraga', 'Kesenian', 'Membaca', 'Menulis', 'Jalan-jalan', 'Lainnya']),

            // Student Address (SAMA DENGAN MIGRATION TERBARU)
            'tempat_tinggal_siswa' => $this->faker->randomElement(["Tinggal dengan Ortu/Wali", "Ikut Saudara/Kerabat", "Asrama Madrasah", "Kontrak/kost", "Tinggal di asrama pesantren", "Panti asuhan", "Rumah singgah", "Lainnya"]),
            'alamat_anak_sesuai_kk' => $this->faker->address,
            'jalan_dusun'           => $this->faker->streetAddress,
            'desa_kelurahan'        => $this->faker->streetName,
            'kecamatan'             => $this->faker->city,
            'kab_kota'         => $this->faker->city,     // sesuai nama kolom di migration
            'provinsi'              => $this->faker->state,
            'kordinat_rumah'        => $this->faker->latitude . ',' . $this->faker->longitude, // ejaan kolom "kordinat_"
            'kodepos'               => $this->faker->postcode,
            'transportasi'          => $this->faker->randomElement(["Jalan kaki", "Sepeda", "Sepeda motor", "Mobil pribadi", "Antar jemput sekolah", "Angkutan umum", "Perahu/sampan", "Lainnya"]),
            'jarak'                 => $this->faker->randomElement(["Kurang dari 5 km", "Antara 5-10 km", "Antara 11-20 km", "Antara 21-30 km", "Lebih dari 30 km"]),
            'waktu'                 => $this->faker->randomElement(["1-10 menit", "10-19 menit", "20-29 menit", "30-39 menit", "1-2 jam", ">2 jam"]),
            'nsm'                   => $this->faker->numerify('##########'),
            'npsn'                  => $this->faker->numerify('########'),

            'biaya_sekolah'   => $this->faker->randomElement(["Orangtua", "Wali/orangtua asuh", "Tanggungan Sendiri", "Lainnya"]),
            'keb_khusus'      => $this->faker->randomElement(["Tidak ada", "Lamban belajar", "Kesulitan belajar spesifik", "Gangguan komunikasi", "Berbakat/memiliki kemampuan", "Lainnya"]),
            'keb_disabilitas' => $this->faker->randomElement(["Tidak ada", "Tuna Netra", "Tuna Rungu", "Tuna Daksa", "Tuna Grahita", "Tuna Laras", "Lainnya"]),
            'tk_ra'           => $this->faker->randomElement(['Y', 'T']),
            'paud'            => $this->faker->randomElement(['Y', 'T']),
            'hepatitis_b'     => $this->faker->randomElement(['Y', 'T']),
            'polio'           => $this->faker->randomElement(['Y', 'T']),
            'bcg'             => $this->faker->randomElement(['Y', 'T']),
            'campak'          => $this->faker->randomElement(['Y', 'T']),
            'dpt'             => $this->faker->randomElement(['Y', 'T']),
            'covid'           => $this->faker->randomElement(['Y', 'T']),

            'no_kk'           => $this->faker->numerify('########'),
            'no_kip'          => null,
            'kepala_keluarga' => $this->faker->name('male'),
            'foto'            => null,

            // AYAH (SAMA DENGAN MIGRATION TERBARU)
            'nama_ayah'                 => $this->faker->name('male'),
            'status_ayah'               => $this->faker->randomElement(['Masih Hidup', 'Sudah Meninggal', 'Tidak Diketahui']),
            'kewarganegaraan_ayah'      => $this->faker->randomElement(['WNI', 'WNA']),
            'nik_ayah'                  => $this->faker->numerify('################'),
            'tempat_lahir_ayah'         => $this->faker->city,
            'tanggal_lahir_ayah'        => $this->faker->dateTimeBetween('1960-01-01', '1985-12-31')->format('Y-m-d'),
            'pendidikan_ayah'           => $this->faker->randomElement(["SD/Sederajat", "SMP/Sederajat", "SMA/Sederajat", "D1", "D2", "D3", "D4/S1", "S2", "S3", "Tidak Bersekolah"]),
            'pekerjaan_ayah'            => $this->faker->randomElement(["Tidak Bekerja", "Pensiunan", "PNS", "TNI/Polisi", "Guru/Dosen", "Pegawai Swasta", "Wiraswasta", "Pengacara/Jaksa/Hakim/No", "Seniman/Pelukis/Artis/Seje", "Dokter/Bidan/Perawat", "Pilot/Pramugara", "Pedagang", "Petani/Peternak", "Nelayan", "Buruh (Tani/Pabrik/Banguna", "Sopir/Masinis/Kondektur", "Politikus", "Lainnya"]),
            'penghasilan_ayah'          => $this->faker->randomElement(["Kurang dari 500.000", "500.000 - 1.000.000", "1.000.001 - 2.000.000", "2.000.001 - 3.000.000", "3.000.001 - 5.000.000", "Lebih dari 5.000.000", "Tidak ada"]),
            'no_hp_ayah'                => $this->faker->numerify('08##########'),
            'domisili_ayah'             => $this->faker->randomElement(['Dalam Negeri', 'Luar Negeri']),
            'status_tempat_tinggal_ayah' => $this->faker->randomElement(["Milik Sendiri", "Rumah Orangtua", "Rumah Saudara/Kerabat", "Rumah Dinas", "Sewa/Kontrak", "Lainnya"]),
            'desa_keluarahan_ayah'      => $this->faker->streetName, // ejaannya ikut migration (keluarahan)
            'kecamatan_ayah'            => $this->faker->city,
            'kab_kota_ayah'             => $this->faker->city,
            'provinsi_ayah'             => $this->faker->state,
            'kodepos_ayah'             => $this->faker->postcode,
            'alamat_ayah'               => $this->faker->address,

            // IBU (SAMA DENGAN MIGRATION TERBARU) — perhatikan: kewarganegaraan_ibu (tanpa 'g')
            'nama_ibu'                  => $this->faker->name('female'),
            'status_ibu'                => $this->faker->randomElement(['Masih Hidup', 'Sudah Meninggal', 'Tidak Diketahui']),
            'kewarganegaraan_ibu'         => $this->faker->randomElement(['WNI', 'WNA']),
            'nik_ibu'                   => $this->faker->numerify('################'),
            'tempat_lahir_ibu'          => $this->faker->city,
            'tanggal_lahir_ibu'         => $this->faker->dateTimeBetween('1965-01-01', '1990-12-31')->format('Y-m-d'),
            'pendidikan_ibu'            => $this->faker->randomElement(["SD/Sederajat", "SMP/Sederajat", "SMA/Sederajat", "D1", "D2", "D3", "D4/S1", "S2", "S3", "Tidak Bersekolah"]),
            'pekerjaan_ibu'             => $this->faker->randomElement(["Tidak Bekerja", "Pensiunan", "PNS", "TNI/Polisi", "Guru/Dosen", "Pegawai Swasta", "Wiraswasta", "Pengacara/Jaksa/Hakim/No", "Seniman/Pelukis/Artis/Seje", "Dokter/Bidan/Perawat", "Pilot/Pramugara", "Pedagang", "Petani/Peternak", "Nelayan", "Buruh (Tani/Pabrik/Banguna", "Sopir/Masinis/Kondektur", "Politikus", "Lainnya"]),
            'penghasilan_ibu'           => $this->faker->randomElement(["Kurang dari 500.000", "500.000 - 1.000.000", "1.000.001 - 2.000.000", "2.000.001 - 3.000.000", "3.000.001 - 5.000.000", "Lebih dari 5.000.000", "Tidak ada"]),
            'no_hp_ibu'                 => $this->faker->numerify('08##########'),
            'status_tinggal_ibu'        => $this->faker->randomElement(['Beda Dengan Ayah', 'Sama Dengan Ayah']),
            'domisili_ibu'              => $this->faker->randomElement(['Dalam Negeri', 'Luar Negeri']),
            'status_tempat_tinggal_ibu' => $this->faker->randomElement(["Milik Sendiri", "Rumah Orangtua", "Rumah Saudara/Kerabat", "Rumah Dinas", "Sewa/Kontrak", "Lainnya"]),
            'desa_keluarahan_ibu'       => $this->faker->streetName, // ikut migration (keluarahan)
            'kecamatan_ibu'             => $this->faker->city,
            'kab_kota_ibu'              => $this->faker->city,
            'provinsi_ibu'              => $this->faker->state,
            'kodepos_ibu'              => $this->faker->postcode,

            // WALI (SAMA DENGAN MIGRATION TERBARU) — kewarganegaraan_wali (tanpa 'g')
            'nama_wali'                  => $this->faker->name('male'),
            'status_wali'                => $this->faker->randomElement(['Sama Dengan Ayah', 'Sama Dengan Ibu', 'Lainnya']),
            'kewarganegaraan_wali'         => $this->faker->randomElement(['WNI', 'WNA']),
            'nik_wali'                   => $this->faker->numerify('################'),
            'tempat_lahir_wali'          => $this->faker->city,
            'tanggal_lahir_wali'         => $this->faker->dateTimeBetween('1955-01-01', '1995-12-31')->format('Y-m-d'),
            'pendidikan_wali'            => $this->faker->randomElement(["SD/Sederajat", "SMP/Sederajat", "SMA/Sederajat", "D1", "D2", "D3", "D4/S1", "S2", "S3", "Tidak Bersekolah"]),
            'pekerjaan_wali'             => $this->faker->randomElement(["Tidak Bekerja", "Pensiunan", "PNS", "TNI/Polisi", "Guru/Dosen", "Pegawai Swasta", "Wiraswasta", "Pengacara/Jaksa/Hakim/No", "Seniman/Pelukis/Artis/Seje", "Dokter/Bidan/Perawat", "Pilot/Pramugara", "Pedagang", "Petani/Peternak", "Nelayan", "Buruh (Tani/Pabrik/Banguna", "Sopir/Masinis/Kondektur", "Politikus", "Lainnya"]),
            'penghasilan_wali'           => $this->faker->randomElement(["Kurang dari 500.000", "500.000 - 1.000.000", "1.000.001 - 2.000.000", "2.000.001 - 3.000.000", "3.000.001 - 5.000.000", "Lebih dari 5.000.000", "Tidak ada"]),
            'no_hp_wali'                 => $this->faker->numerify('08##########'),
            'domisili_wali'              => $this->faker->randomElement(['Dalam Negeri', 'Luar Negeri']),
            'status_tempat_tinggal_wali' => $this->faker->randomElement(["Milik Sendiri", "Rumah Orangtua", "Rumah Saudara/Kerabat", "Rumah Dinas", "Sewa/Kontrak", "Lainnya"]),
            'desa_keluarahan_wali'       => $this->faker->streetName, // ikut migration (keluarahan)
            'kecamatan_wali'             => $this->faker->city,
            'kab_kota_wali'              => $this->faker->city,
            'provinsi_wali'              => $this->faker->state,
            'kodepos_wali'              => $this->faker->postcode,

            // Status
            'status_daftar' => 'daftar',
            'status'        => 'aktif',
        ];
    }
}
