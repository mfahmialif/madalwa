@extends('layouts.admin.template')
@section('title', 'Edit Data Jurusan')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.jurusan.index') }}">Jurusan </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Jurusan</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.jurusan.update', ['jurusan' => $jurusan]) }}" onsubmit="submitForm(this)"
                        method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Data Jurusan</h4>
                                </div>
                            </div>
                            @include('admin.jurusan.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const jurusan = @json($jurusan);
        $('#form_edit').find('[name="kode_jurusan"]').val(jurusan.kode_jurusan);
        $('#form_edit').find('[name="nama_jurusan"]').val(jurusan.nama_jurusan);
        $('#form_edit').find('[name="kuota"]').val(jurusan.kuota);
        $('#form_edit').find('[name="status"]').val(jurusan.status).trigger('change');
    </script>
@endpush
