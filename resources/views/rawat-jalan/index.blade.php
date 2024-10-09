@extends('layouts.user_type.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <form method="POST" action="{{ route('rawat-jalan.store') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary" name="action" value="dumpSession">New Session</button>
                        <ul class="nav nav-fill nav-pills">
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 1 ? 'active' : '' }}">Pendaftaran</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 2 ? 'active' : '' }}">Obat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 3 ? 'active' : '' }}">Pembayaran</a>
                            </li>
                        </ul>
                    </form>
                </div>

                <div class="card-body">
                    <form id="rawatJalanForm" method="POST" action="{{ route('rawat-jalan.store') }}">
                        @csrf
                        <input type="hidden" name="step" value="{{ $step }}">

                        @if ($step == 1)
                            <div class="form-group mb-2">
                                <label for="pasien_id">{{ __('Pasien') }}</label>
                                <select name="pasien_id" id="pasien_id" class="form-control" required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach ($pasiens as $pasien)
                                        <option value="{{ $pasien->id }}">{{ $pasien->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="dokter_id">{{ __('Dokter') }}</label>
                                <select name="dokter_id" id="dokter_id" class="form-control" required>
                                    <option value="">Pilih Dokter</option>
                                    @foreach ($dokters as $dokter)
                                        <option value="{{ $dokter->id }}">{{ $dokter->nama_dokter }} - {{ $dokter->spesialis }}</option>
                                    @endforeach
                                </select>
                            </div>

                        @elseif ($step == 2)
                            <div id="obat-container">
                                @if(isset($rawat_jalan_data['obat_id']))
                                    @foreach($rawat_jalan_data['obat_id'] as $index => $obat_id)
                                        <div class="mb-3 obat-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label for="obat_id" class="form-label">Pilih Obat</label>
                                                <button type="button" class="btn btn-danger btn-sm hapus-obat" @if($loop->first) style="display: none;" @endif>Hapus</button>
                                            </div>
                                            <select name="obat_id[]" class="form-select select2 obat-select w-100" required>
                                                <option value="" disabled>Pilih Obat</option>
                                                @foreach ($obats as $obat)
                                                    <option value="{{ $obat->id_obat }}" 
                                                        data-harga="{{ $obat->harga_obat }}" 
                                                        data-stok="{{ $obat->stok_obat }}"
                                                        {{ $obat->id_obat == $obat_id ? 'selected' : '' }}>
                                                        {{ $obat->nama_obat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="number" name="jumlah[]" class="form-control mt-2 obat-jumlah" placeholder="Jumlah" required min="1" value="{{ $rawat_jalan_data['jumlah'][$index] ?? '' }}">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="mb-3 obat-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="obat_id" class="form-label">Pilih Obat</label>
                                            <button type="button" class="btn btn-danger btn-sm hapus-obat" style="display: none;">Hapus</button>
                                        </div>
                                        <select name="obat_id[]" class="form-select select2 obat-select w-100" id="obat_id" data-live-search="true" required>
                                            <option value="" disabled selected>Pilih Obat</option>
                                            @foreach ($obats as $obat)
                                                <option value="{{ $obat->id_obat }}" data-harga="{{ $obat->harga_obat }}" data-stok="{{ $obat->stok_obat }}">{{ $obat->nama_obat }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="jumlah[]" class="form-control mt-2 obat-jumlah" placeholder="Jumlah" required min="1">
                                    </div>
                                @endif
                            </div>

                            <button type="button" class="btn btn-secondary mt-2" id="tambah-obat">Tambah Obat</button>

                            
                            <div id="ringkasan_obat" class="mt-3">
                                <h5>Ringkasan Obat</h5>
                                <ul id="daftar-obat"></ul>
                                <p id="total-harga">Total: Rp 0</p>
                            </div>

                            <div class="form-group mb-2">
                                <label for="total_biaya">{{ __('Total Biaya') }}</label>
                                <input type="number" name="total_biaya" id="total_biaya" class="form-control" value="{{ old('total_biaya', $rawat_jalan_data['total_biaya'] ?? '') }}" required readonly>
                            </div>

                        @elseif ($step == 3)
                            <div class="form-group mb-2">
                                <label for="total_biaya">{{ __('Total Biaya') }}</label>
                                <input type="number" name="total_biaya" id="total_biaya" class="form-control" value="{{ old('total_biaya', $rawat_jalan_data['total_biaya'] ?? '') }}" required readonly>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            @if ($step > 1)
                                <button type="submit" name="action" value="previous" class="btn btn-secondary">{{ __('Sebelumnya') }}</button>
                            @endif
                            @if ($step < 3)
                                <button type="submit" name="action" value="next" class="btn btn-primary">{{ __('Selanjutnya') }}</button>
                            @endif
                            @if ($step == 3)
                                <button type="submit" name="action" value="finish" class="btn btn-success">{{ __('Simpan Rawat Jalan') }}</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @php
                        $pendaftaranData = $rawatJalanSession->where('step', '1');
                        $pemeriksaanData = $rawatJalanSession->where('step', '2');
                        $pembayaranData = $rawatJalanSession->where('step', '3');
                    @endphp

                    @if($rawatJalanSession->count() > 0)
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Pemeriksaan</th>
                                    <th>Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rawatJalanSession as $entry)
                                    <tr>
                                        <td>
                                            @if($pemeriksaanData->contains($entry))
                                            <a href="{{ route('rawat-jalan.index', ['id' => $entry->id]) }}" data-id="{{ $entry->id }}">
                                                {{ $entry->pasien->nama_lengkap }}
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pembayaranData->contains($entry))
                                            <a href="{{ route('rawat-jalan.index', ['id' => $entry->id]) }}" data-id="{{ $entry->id }}">
                                                {{ $entry->pasien->nama_lengkap }}
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Tidak ada data yang ditemukan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('.clickable-row');

        rows.forEach(row => {
            row.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                fetch(`/rawat-jalan/${id}`) 
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });

    $(document).ready(function() {

    $('.select2').select2();

    
    $('#tambah-obat').click(function() {
        let newObatItem = `
            <div class="mb-3 obat-item">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="obat_id" class="form-label">Pilih Obat</label>
                    <button type="button" class="btn btn-danger btn-sm hapus-obat">Hapus</button>
                </div>
                <select name="obat_id[]" class="form-select select2 obat-select w-100" required>
                    <option value="" disabled selected>Pilih Obat</option>
                    @foreach ($obats as $obat)
                        <option value="{{ $obat->id_obat }}" data-harga="{{ $obat->harga_obat }}" data-stok="{{ $obat->stok_obat }}">{{ $obat->nama_obat }}</option>
                    @endforeach
                </select>
                <input type="number" name="jumlah[]" class="form-control mt-2 obat-jumlah" placeholder="Jumlah" required min="1">
            </div>
        `;
        $('#obat-container').append(newObatItem);
        $('.select2').select2(); 
    });

    $('#obat-container').on('click', '.hapus-obat', function() {
        $(this).closest('.obat-item').remove();
        updateRingkasanObat();
    });

    $('#obat-container').on('change', '.obat-jumlah, .obat-select', function() {
        updateRingkasanObat();
    });

    function updateRingkasanObat() {
    let total = 0;
    $('#daftar-obat').empty();
    $('.obat-item').each(function() {
        let obat = $(this).find('.obat-select option:selected').text();
        let harga = parseFloat($(this).find('.obat-select option:selected').data('harga')) || 0;
        let jumlah = parseInt($(this).find('.obat-jumlah').val()) || 0;
        let subtotal = harga * jumlah;
        total += subtotal;
        $('#daftar-obat').append(`<li>${obat} - ${jumlah} x Rp ${harga.toFixed(2)} = Rp ${subtotal.toFixed(2)}</li>`);
    });
    $('#total-harga').text(`Total: Rp ${total.toFixed(2)}`);
    $('#total_biaya').val(total);
}

    function toggleFirstHapusButton() {
        let obatItems = $('.obat-item');
        if (obatItems.length > 1) {
            obatItems.first().find('.hapus-obat').show();
        } else {
            obatItems.first().find('.hapus-obat').hide();
        }
    }

    $('#tambah-obat').click(toggleFirstHapusButton);
    $('#obat-container').on('click', '.hapus-obat', toggleFirstHapusButton);

    toggleFirstHapusButton();
});
</script>

@endsection
