@extends('layouts.admin.template')
@section('title', 'Import Kelas')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.import.kelas.show') }}">Kelas</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Import Kelas</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
            <h5 class="card-title">Import Data Kelas</h5>
            <a class="mb-1 btn clip-btn btn-sm btn-primary" href="javascript:;" data-clipboard-target="#input-copy"><i
                    class="fa fa-download"></i>download format</a>
        </div>
        <div class="card-body">
            <div class="clipboard">
                <form class="form-horizontal" method="POST" action="{{ route('admin.import.kelas.save') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" class="form-control mb-4" id="import_kelas" name="import_kelas">
                    <div class="text-end">
                        <button type="submit" class="mb-1 btn btn-sm btn-primary">
                            <i class="fa fa-upload"></i> Upload
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session("success") }}'
            });
        </script>
    @endif

    {{-- Error umum --}}
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: '{{ session("error") }}'
            });
        </script>
    @endif

    {{-- Error validasi (bisa lebih dari 1) --}}
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: `{!! implode('<br>', $errors->all()) !!}` // ditampilkan per baris
            });
        </script>
    @endif
@endpush
