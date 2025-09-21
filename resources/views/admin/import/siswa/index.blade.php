@extends('layouts.admin.template')
@section('title', 'Import Siswa')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.import.siswa.show') }}">Siswa</a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Import Siswa</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Import Data Siswa</h5>
            <a class="mb-1 btn clip-btn btn-primary" href="{{ asset('import/importsiswa.xls') }}"><i
                    class="fa fa-download" style="margin-right: 5px"></i> Download Format</a>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('admin.import.siswa.save') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="col-12 col-md-12">
                    <div class="input-block local-forms">
                        <label>Unit Sekolah <span class="login-danger">*</span></label>
                        <select class="form-control select2 filter-dt" name="unit_sekolah_id" required>
                            @if (Auth::user()->role->nama == 'unit sekolah')
                                <option value="{{ Auth::user()->unitSekolah->unit_sekolah_id }}">
                                    {{ Auth::user()->unitSekolah->unitSekolah->nama_unit }}
                                </option>
                            @else
                                <option value="">Pilih Unit Sekolah</option>
                                @foreach ($unitSekolah as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama_unit }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-block local-top-form">
                        <label class="local-top">
                            Upload File <span class="login-danger">*</span>
                        </label>

                        <div class="settings-btn upload-files-avator">
                            <input type="file" name="import_siswa" id="import_siswa"
                                class="hide-input @error('import_siswa') is-invalid @enderror" accept=".xlsx, .xls"
                                onchange="handleFileUpload(this, 'file-info', 'upload-label')" required />

                            <label for="import_siswa" id="file-info" class="file-info-text">Belum ada file</label>
                            <label for="import_siswa" class="upload" id="upload-label">Pilih File</label>
                        </div>
                        @error('avatar')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="ms-2 mb-4 view-foto d-none">
                            <small class="text-decoration-underline"><a href="" id="view-foto">Lihat Berkas <i
                                        class="fa fa-eye"></i></a></small>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="mb-1 btn btn-primary">
                        <i class="fa fa-upload"></i> Upload
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function handleFileUpload(input, fileInfoId, uploadLabelId) {
            const fileInfo = document.getElementById(fileInfoId);
            const uploadLabel = document.getElementById(uploadLabelId);
            const file = input.files[0];

            if (file) {
                const isImage = file.type.startsWith("image/");
                if (!isImage) {
                    fileInfo.innerText = "Belum ada file";
                    uploadLabel.innerText = "Pilih File";
                    return;
                }

                fileInfo.innerText = file.name;
                uploadLabel.innerText = "Ganti File";
            } else {
                fileInfo.innerText = "Belum ada file";
                uploadLabel.innerText = "Pilih File";
            }
        }
    </script>
@endpush
