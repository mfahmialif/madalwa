@extends('layouts.admin.template')
@section('title', 'Edit Data User')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.mutasi-masuk.index') }}">Mutasi Masuk</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Mutasi Masuk</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.mutasi-masuk.update', ['mutasi' => $mutasi]) }}" onsubmit="submitForm(this)"
                        method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Data Mutasi Masuk</h4>
                                </div>
                            </div>
                            @include('admin.mutasi-masuk.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    {{-- <script>
        const mutasiMasuk = @json($mutasiMasuk);
        $('#form_edit').find('select[name="kelas"]').val(mataPelajaran.kelas_id).trigger('change');
        $('#form_edit').find('input[name="kode"]').val(mataPelajaran.kode);
        $('#form_edit').find('input[name="nama"]').val(mataPelajaran.nama);
        $('#form_edit').find('select[name="status"]').val(mataPelajaran.status).trigger('change');
    </script> --}}
@endpush
