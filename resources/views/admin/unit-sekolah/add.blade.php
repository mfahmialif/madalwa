@extends('layouts.admin.template')
@section('title', 'Tambah Data Unit Sekolah')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.unit-sekolah.index') }}">Unit Sekolah</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Tambah Unit Sekolah</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.unit-sekolah.store') }}" onsubmit="submitForm(this)" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Tambah Data Unit Sekolah</h4>
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
