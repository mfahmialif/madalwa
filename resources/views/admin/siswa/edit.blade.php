@extends('layouts.admin.template')
@section('title', 'Edit Siswa')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Siswa </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Siswa</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.siswa.update', ['siswa' => $siswa]) }}" onsubmit="submitForm(this)"
                        method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Siswa</h4>
                                </div>
                            </div>
                            @include('admin.siswa.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        // Pastikan jQuery sudah dimuat sebelum skrip ini dijalankan
        function setFormEdit(data, form) {
            Object.entries(data).forEach(([key, value]) => {
                if (value === null) return; // Lewati jika nilainya null

                const element = form.find(`[name="${key}"]`);

                const assetUrl = {
                    'foto': "{{ asset('foto_siswa') }}",
                    'kk': "{{ asset('kk') }}",
                    'akta_kelahiran': "{{ asset('akta_kelahiran') }}",
                    'ijazah': "{{ asset('ijazah') }}",
                    'pakta_integritas': "{{ asset('pakta_integritas') }}",
                }

                if (element.length > 0) {
                    // Logika untuk mengisi berbagai jenis input
                    if (element.is('select') && element.hasClass('select2-hidden-accessible')) {
                        element.val(value).trigger('change'); // Set value dan update Select2
                    } else if (element.is('[type="file"]')) {
                        $('#file-info-' + key).text(value);
                        $('.view-' + key).removeClass('d-none');
                        $('#view-' + key).attr('href', assetUrl[key] + '/' + value);
                    } else if (element.is(':radio')) {
                        form.find(`[name="${key}"][value="${value}"]`).prop('checked', true);
                    } else if (element.is(':checkbox')) {
                        if (Array.isArray(value)) {
                            element.each(function() {
                                $(this).prop('checked', value.includes($(this).val()));
                            });
                        } else {
                            element.prop('checked', !!value);
                        }
                    } else {
                        element.val(value); // Untuk input teks, textarea, select biasa
                    }
                }
            });
        }

        $(document).ready(function() {
            // Ambil data siswa dan data 'old' dari Blade
            const siswa = @json($siswa);
            const oldData = @json(session()->getOldInput());
            const hasOldData = Object.keys(oldData).length > 0;

            // Fungsi helper untuk mendapatkan nilai, dengan prioritas pada old data
            function getValue(key) {
                // Prioritas 1: Ambil dari old data jika ada
                if (hasOldData && oldData[key] !== undefined) {
                    return oldData[key];
                }

                // Prioritas 2: Ambil dari data siswa, mendukung nested object (cth: 'user.email')
                if (key.includes('.')) {
                    const keys = key.split('.');
                    let value = siswa;
                    for (const k of keys) {
                        if (value && typeof value === 'object' && k in value) {
                            value = value[k];
                        } else {
                            return ''; // Kembalikan string kosong jika path tidak valid
                        }
                    }
                    return value;
                }

                // Ambil dari properti langsung di objek siswa
                return siswa[key] !== undefined ? siswa[key] : '';
            }

            // Cache selector form untuk efisiensi
            const form = $('#form_edit');

            // Tampilkan elemen input edit dan atur atribut required
            form.find('.input-edit').removeClass('d-none');
            form.find('.input-edit').find('input, select, textarea').prop('required', true);
            form.find('.input-password').find('input').prop('required', false);

            // Set nilai-nilai form
            setFormEdit(siswa, form);
        });
    </script>
@endpush
