<div class="table-responsive">
    <table id="tableAdd" class="table border-0 custom-table comman-table datatable mb-0 table-hover">
        <thead>
            <tr>
                <th style="width: 5%">
                    <div class="form-check check-tables">
                        <input class="form-check-input" id="check-all" type="checkbox" value="something">
                    </div>
                </th>
                <th style="width: 5%">No</th>
                <th>Kode</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mataPelajaran as $item)
                <tr>
                    <td>
                        <div class="form-check check-tables">
                            <input class="form-check-input check-table status_daftar_checkbox" type="checkbox"
                                name="mata_pelajaran_id[]" value="{{ $item->id }}">
                        </div>
                    </td>
                    <td>{{ $item->iteration }}</td>
                    <td>
                        {{ $item->kode }}
                    </td>
                    <td>
                        {{ $item->nama }}
                    </td>
                    <td>
                        {{ $item->kelas->angka }} ({{ $item->kelas->unitSekolah->nama_unit }})
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
