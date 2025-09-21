{{-- resources/views/components/wilayah.blade.php --}}
<div class="col-12 col-md-6 col-lg-3">
    <div class="input-block local-forms">
        <label>Provinsi</label>
        <input class="form-control @error('provinsi' . $postFix) is-invalid @enderror" name="provinsi{{ $postFix }}"
            type="text" value="{{ old('provinsi' . $postFix) }}" readonly>
        <small class="text-muted">Klik reset untuk merubah</small>
        @error('provinsi' . $postFix)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6 col-lg-3">
    <div class="input-block local-forms">
        <label>Kabupaten/Kota</label>
        <input class="form-control @error('kab_kota' . $postFix) is-invalid @enderror"
            name="kab_kota{{ $postFix }}" type="text" value="{{ old('kab_kota' . $postFix) }}" readonly>
        @error('kab_kota' . $postFix)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6 col-lg-3">
    <div class="input-block local-forms">
        <label>Kecamatan</label>
        <input class="form-control @error('kecamatan' . $postFix) is-invalid @enderror"
            name="kecamatan{{ $postFix }}" type="text" value="{{ old('kecamatan' . $postFix) }}" readonly>
        @error('kecamatan' . $postFix)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6 col-lg-2">
    <div class="input-block local-forms">
        <label>Desa / Kelurahan</label>
        <input class="form-control @error('desa_kelurahan' . $postFix) is-invalid @enderror"
            name="desa_kelurahan{{ $postFix }}" type="text" value="{{ old('desa_kelurahan' . $postFix) }}"
            readonly>
        @error('desa_kelurahan' . $postFix)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12 col-md-6 col-lg-1">
    <div class="input-block local-forms">
        <button class="btn btn-primary" type="button" onclick="resetWilayah{{ $postFix }}()">
            Reset
        </button>
    </div>
</div>

@push('script')
    <script>
        // Inisialisasi Autocomplete Provinsi
        $("[name='provinsi{{ $postFix }}']").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "https://mfahmialif.github.io/api-wilayah-indonesia/api/provinces.json",
                    dataType: "json",
                    beforeSend: function() {
                        $("[name='provinsi{{ $postFix }}']").loading('start');
                    },
                    complete: function() {
                        $("[name='provinsi{{ $postFix }}']").loading('stop');
                    },
                    success: function(data) {
                        var filtered = $.map(data, function(item) {
                            if (item.name.toLowerCase().indexOf(request.term
                                    .toLowerCase()) !== -1) {
                                return {
                                    label: item.name,
                                    value: item.name,
                                    id: item.id
                                };
                            }
                        });
                        response(filtered);
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                console.log("Provinsi dipilih:", ui.item.value, "ID:", ui.item.id);
                loadKabupaten{{ $postFix }}(ui.item.id);
                // kosongkan level di bawahnya
                $("[name='kab_kota{{ $postFix }}'],[name='kecamatan{{ $postFix }}'],[name='desa_kelurahan{{ $postFix }}']")
                    .val('');
            }
        });

        // Load & Autocomplete Kabupaten/Kota
        function loadKabupaten{{ $postFix }}(provinsiId) {
            $("[name='kab_kota{{ $postFix }}']").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "https://mfahmialif.github.io/api-wilayah-indonesia/api/regencies/" +
                            provinsiId + ".json",
                        dataType: "json",
                        beforeSend: function() {
                            $("[name='kab_kota{{ $postFix }}']").loading('start');
                        },
                        complete: function() {
                            $("[name='kab_kota{{ $postFix }}']").loading('stop');
                        },
                        success: function(data) {
                            var filtered = $.map(data, function(item) {
                                if (item.name.toLowerCase().indexOf(request.term
                                        .toLowerCase()) !== -1) {
                                    return {
                                        label: item.name,
                                        value: item.name,
                                        id: item.id
                                    };
                                }
                            });
                            response(filtered);
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    console.log("Kab/Kota dipilih:", ui.item.value, "ID:", ui.item.id);
                    loadKecamatan{{ $postFix }}(ui.item.id);
                    // kosongkan level di bawahnya
                    $("[name='kecamatan{{ $postFix }}'],[name='desa_kelurahan{{ $postFix }}']").val(
                        '');
                }
            });
        }

        // Load & Autocomplete Kecamatan
        function loadKecamatan{{ $postFix }}(kabupatenId) {
            $("[name='kecamatan{{ $postFix }}']").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "https://mfahmialif.github.io/api-wilayah-indonesia/api/districts/" +
                            kabupatenId + ".json",
                        dataType: "json",
                        beforeSend: function() {
                            $("[name='kecamatan{{ $postFix }}']").loading('start');
                        },
                        complete: function() {
                            $("[name='kecamatan{{ $postFix }}']").loading('stop');
                        },
                        success: function(data) {
                            var filtered = $.map(data, function(item) {
                                if (item.name.toLowerCase().indexOf(request.term
                                        .toLowerCase()) !== -1) {
                                    return {
                                        label: item.name,
                                        value: item.name,
                                        id: item.id
                                    };
                                }
                            });
                            response(filtered);
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    console.log("Kecamatan dipilih:", ui.item.value, "ID:", ui.item.id);
                    loadDesa{{ $postFix }}(ui.item.id);
                    // kosongkan level di bawahnya
                    $("[name='desa_kelurahan{{ $postFix }}']").val('');
                }
            });
        }

        // Load & Autocomplete Desa/Kelurahan
        function loadDesa{{ $postFix }}(kecamatanId) {
            $("[name='desa_kelurahan{{ $postFix }}']").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "https://mfahmialif.github.io/api-wilayah-indonesia/api/villages/" +
                            kecamatanId + ".json",
                        dataType: "json",
                        beforeSend: function() {
                            $("[name='desa_kelurahan{{ $postFix }}']").loading('start');
                        },
                        complete: function() {
                            $("[name='desa_kelurahan{{ $postFix }}']").loading('stop');
                        },
                        success: function(data) {
                            var filtered = $.map(data, function(item) {
                                if (item.name.toLowerCase().indexOf(request.term
                                        .toLowerCase()) !== -1) {
                                    return {
                                        label: item.name,
                                        value: item.name,
                                        id: item.id
                                    };
                                }
                            });
                            response(filtered);
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    console.log("Desa/Kelurahan dipilih:", ui.item.value, "ID:", ui.item.id);
                }
            });
        }

        // Reset semua field & izinkan edit kembali
        function resetWilayah{{ $postFix }}() {
            $("[name='provinsi{{ $postFix }}']").val('').prop('readonly', false);
            $("[name='kab_kota{{ $postFix }}']").val('').prop('readonly', false);
            $("[name='kecamatan{{ $postFix }}']").val('').prop('readonly', false);
            $("[name='desa_kelurahan{{ $postFix }}']").val('').prop('readonly', false);
            $("[name='provinsi{{ $postFix }}']").focus();
        }
    </script>
@endpush
