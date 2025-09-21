@extends('layouts.admin.template')
@section('title', 'Jadwal')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.jadwal.index') }}">Jadwal </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Data Jadwal</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">
            <div class="col-12">
                <div class="input-block local-forms">
                    <select class="form-control select2 filter-dt" id="filter_tahun_pelajaran_id" required>
                        @foreach ($tahunPelajaran as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama }} {{ $item->semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12 col-md-12">
                <div class="input-block local-forms">
                    <select class="form-control select2 filter-dt" id="filter_unit_sekolah_id" required>
                        @if (Auth::user()->role->nama == 'unit sekolah')
                            <option value="{{ Auth::user()->unitSekolah->unit_sekolah_id }}">
                                {{ Auth::user()->unitSekolah->unitSekolah->nama_unit }}
                            </option>
                        @else
                            <option value="">Semua Unit Sekolah</option>
                            @foreach ($unitSekolah as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_unit }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div id="kurikulum">

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>

        function loadKurikulum() {
            $('#kurikulum').loading('start');
            $.ajax({
                type: "GET",
                url: "{{ route('admin.jadwal.data') }}",
                data: {
                    tahun_pelajaran_id: $('#filter_tahun_pelajaran_id').val(),
                    unit_sekolah_id: $('#filter_unit_sekolah_id').val(),
                },
                dataType: "html",
                success: function(response) {
                    $('#kurikulum').html(response);
                },
                complete: function() {
                    $('#kurikulum').loading('stop');
                }
            });
        }

        $('#filter_tahun_pelajaran_id').change(function (e) {
            loadKurikulum();
        });
        $('#filter_unit_sekolah_id').change(function (e) {
            loadKurikulum();
        });

        loadKurikulum();
    </script>
@endpush
