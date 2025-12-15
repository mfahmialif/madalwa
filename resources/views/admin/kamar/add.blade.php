@extends('layouts.admin.template')
@section('title', 'Tambah Data Kamar')
@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.kamar.index') }}">Kamar</a></li>
                <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                <li class="breadcrumb-item active">Tambah Kamar</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.kamar.store') }}" onsubmit="submitForm(this)" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-heading">
                                <h4>Tambah Data Kamar</h4>
                            </div>
                        </div>
                        @include('admin.kamar.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
