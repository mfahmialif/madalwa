@extends('layouts.auth.template')
@section('title', 'Register')
@section('content')
    <div class="main-wrapper login-body">
        <div class="container-fluid px-0">
            <div class="row">


                <!-- Login Content -->
                <div class="col-lg-12 login-wrap-bg">
                    <div class="login-wrapper">
                        <div class="loginbox">
                            <div class="login-right">
                                <div class="login-right-wrap">

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                            @endforeach
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <h2>Register</h2>
                                    <!-- Form -->
                                    <form method="POST" action="{{ route('register') }}" onsubmit="register()"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            @include('auth.register.form')

                                        </div>
                                    </form>
                                    <!-- /Form -->

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /Login Content -->

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function register() {
            const btn = document.getElementById('register-button');
            const spinner = btn.querySelector('.spinner-border');
            const text = btn.querySelector('.btn-text');

            // Tampilkan spinner dan ubah state tombol
            spinner.classList.remove('d-none');
            text.textContent = 'Process Register...';
            btn.disabled = true;

            return true; // lanjutkan submit
        }

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
                uploadLabel.innerText = file.name;
            } else {
                fileInfo.innerText = "Belum ada file";
                uploadLabel.innerText = "Pilih File";
            }
        }
    </script>
@endpush
