@extends('layouts.admin.template')
@section('title', 'Edit Data Unit Sekolah')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.unit-sekolah.index') }}">Unit Sekolah </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Unit Sekolah</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.unit-sekolah.update', ['unitSekolah' => $unitSekolah]) }}" onsubmit="submitForm(this)"
                        method="POST" enctype="multipart/form-data" id="form_edit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Data Unit Sekolah</h4>
                                </div>
                            </div>
                            @include('admin.unit-sekolah.form')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const unitSekolah = @json($unitSekolah);
        $('#form_edit').find('[name="nama_unit"]').val(unitSekolah.nama_unit);
        $('#form_edit').find('[name="alamat"]').val(unitSekolah.alamat);
        $('#form_edit').find('[name="keterangan"]').val(unitSekolah.keterangan);
    </script>
@endpush
