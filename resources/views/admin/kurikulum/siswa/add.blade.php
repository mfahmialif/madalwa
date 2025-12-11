@extends('layouts.admin.template')
@section('title', 'Tambah Data Siswa Kurikulum')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kurikulum.index') }}">Kurikulum </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('admin.kurikulum.siswa.index', ['kurikulum' => $kurikulum]) }}">Kurikulum Siswa
                        </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Tambah Data Siswa Kurikulum</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <form action="{{ route('admin.kurikulum.siswa.store', ['kurikulum' => $kurikulum]) }}" onsubmit="submitFormThis(this)"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info d-flex align-items-center gap-2" role="alert">
                    <i class="feather-info"></i>
                    <div>
                        <strong>Informasi:</strong> Anda sedang menambahkan siswa untuk
                        <strong>kurikulum: {{ $kurikulum->nama }}</strong>.
                    </div>
                </div>
                <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                    <i class="feather-check"></i>
                    <div>
                        Centang untuk memilih siswa yang akan dimasukkan di kurikulum ini.
                    </div>
                </div>
                @include('admin.kurikulum.siswa.form')
            </div>
        </div>
    </form>
@endsection
