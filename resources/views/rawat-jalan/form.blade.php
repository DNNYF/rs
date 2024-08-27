@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-pills nav-justified mb-3">
                <li class="nav-item">
                    <a class="nav-link active" id="step1-tab" data-bs-toggle="pill" href="#step1">Pendaftaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step2-tab" data-bs-toggle="pill" href="#step2">Step 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step3-tab" data-bs-toggle="pill" href="#step3">Invoice</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <form id="multiStepForm" action="{{ route('rawat-jalan.submit') }}" method="POST">
                @csrf

                <div class="tab-content">
                    <!-- Step 1: Pasien -->
                    <div class="tab-pane fade show active" id="step1">
                        <div class="mb-3">
                            <label for="pasien_id" class="form-label">Cari Pasien</label>
                            <select name="pasien_id" class="form-select select2" id="pasien_id" required>
                                <option value="" selected>Pilih Pasien</option>
                                @foreach ($pasiens as $pasien)
                                    <option value="{{ $pasien->id }}">{{ $pasien->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dokter_id" class="form-label">Pilih Dokter</label>
                            <select name="dokter_id" class="form-select select2" id="dokter_id" data-live-search="true" required>
                                <option value="" selected>Pilih Dokter</option>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}">{{ $dokter->nama_dokter }} - {{ $dokter->spesialis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                    </div>

                    <!-- Step 2: Dokter -->
                    <div class="tab-pane fade" id="step2">
                        <div id="obat-container">
                            <div class="mb-3 obat-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="obat_id" class="form-label">Pilih Obat</label>
                                    <button type="button" class="btn btn-danger btn-sm hapus-obat" style="display: none;">Hapus</button>
                                </div>
                                <select name="obat_id[]" class="form-select select2 obat-select" required>
                                    <option value="" disabled selected>Pilih Obat</option>
                                    @foreach ($obats as $obat)
                                        <option value="{{ $obat->id_obat }}" data-harga="{{ $obat->harga_obat }}" data-stok="{{ $obat->stok_obat }}">{{ $obat->nama_obat }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="jumlah[]" class="form-control mt-2 obat-jumlah" placeholder="Jumlah" required min="1">
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mt-2" id="tambah-obat">Tambah Obat</button>

                        <!-- Step 3: Ringkasan Obat -->
                        <div id="ringkasan_obat" class="mt-3">
                            <h5>Ringkasan Obat</h5>
                            <ul id="daftar-obat"></ul>
                            <p id="total-harga">Total: Rp 0</p>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                            <button type="button" class="btn btn-primary next-step">Next</button>
                        </div>
                    </div>

                    <!-- Step 3: Invoice -->
                    <div class="tab-pane fade" id="step3">
                        <div class="mb-3">
                            <label for="invoice_total" class="form-label">Total Biaya</label>
                            <input type="text" name="invoice_total" class="form-control" id="invoice_total" readonly>
                        </div>
                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>

            <!-- Table to display riwayat pendaftaran data -->
            <div class="mt-5">
                <h4>Riwayat Pendaftaran</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody id="saved-data-table">
                        @if (session()->has('riwayat_pendaftaran'))
                            @foreach (session('riwayat_pendaftaran') as $riwayat)
                                <tr>
                                    <td>{{ $riwayat['nama_lengkap'] }}</td>
                                    <td>{{ $riwayat['dokter_nama'] }}</td>
                                    <td>{!! $riwayat['obat'] !!}</td>
                                    <td>{{ $riwayat['jumlah'] }}</td>
                                    <td>{{ $riwayat['total_harga'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
a
        </div>
    </div>
</div>

@section('search-filter')
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5'
    });

    let totalHarga = 0;

    function updateRingkasanObat() {
        let daftarObat = $('#daftar-obat');
        daftarObat.empty();
        totalHarga = 0;

        $('.obat-item').each(function() {
            let select = $(this).find('.obat-select');
            let jumlah = parseInt($(this).find('.obat-jumlah').val()) || 0;
            let selectedOption = select.find('option:selected');
            let namaObat = selectedOption.text();
            let hargaObat = parseFloat(selectedOption.data('harga')) || 0;
            let stokObat = parseInt(selectedOption.data('stok')) || 0;

            if (namaObat && hargaObat && jumlah) {
                if (jumlah > stokObat) {
                    alert(`Stok ${namaObat} tidak mencukupi. Stok tersedia: ${stokObat}`);
                    $(this).find('.obat-jumlah').val(stokObat);
                    jumlah = stokObat;
                }

                let subtotal = hargaObat * jumlah;
                totalHarga += subtotal;
                daftarObat.append(`${namaObat} - ${jumlah} x Rp ${hargaObat} = Rp ${subtotal}`);
            }
        });

        $('#total-harga').text(`Total: Rp ${totalHarga}`);
        $('#invoice_total').val(totalHarga);
    }

    $(document).on('change', '.obat-select, .obat-jumlah', updateRingkasanObat);

    $('#tambah-obat').click(function() {
        let newObatItem = $('.obat-item').first().clone();
        newObatItem.find('select').val('').select2({
            theme: 'bootstrap-5'
        });
        newObatItem.find('input').val('');
        newObatItem.find('.hapus-obat').show();
        $('#obat-container').append(newObatItem);
        updateTombolHapus();
    });

    $(document).on('click', '.hapus-obat', function() {
        $(this).closest('.obat-item').remove();
        updateRingkasanObat();
        updateTombolHapus();
    });

    function updateTombolHapus() {
        let items = $('.obat-item');
        if (items.length > 1) {
            items.find('.hapus-obat').show();
        } else {
            items.find('.hapus-obat').hide();
        }
    }

    updateTombolHapus();

    $('.next-step').click(function() {
        let currentTab = $(this).closest('.tab-pane');
        let nextTab = currentTab.next('.tab-pane');
        $('.next-step').click(function() {
    let currentTab = $(this).closest('.tab-pane');
    let nextTab = currentTab.next('.tab-pane');

    if (nextTab.length > 0) {
        if (currentTab.attr('id') === 'step1') {
            let pasien = $('#pasien_id option:selected').text();
            let pasienId = $('#pasien_id').val();
            let dokter = $('#dokter_id option:selected').text();
            let dokterId = $('#dokter_id').val();

            $.post("{{ route('rawat-jalan.saveStep1') }}", {
                _token: "{{ csrf_token() }}",
                pasien_id: pasienId,
                nama_lengkap: pasien,
                dokter_id: dokterId,
                nama_dokter: dokter,
            });

            $('#saved-data-table').append(`
                <tr>
                    <td>${pasien}</td>
                    <td>${dokter}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            `);
        } else if (currentTab.attr('id') === 'step2') {
            updateRingkasanObat();
            let obatData = [];

            $('.obat-item').each(function() {
                let obatId = $(this).find('.obat-select').val();
                let namaObat = $(this).find('.obat-select option:selected').text();
                let jumlah = $(this).find('.obat-jumlah').val();
                let harga = $(this).find('.obat-select option:selected').data('harga');
                obatData.push({
                    obat_id: obatId,
                    nama_obat: namaObat,
                    jumlah: jumlah,
                    harga: harga
                });
            });

            $.post("{{ route('rawat-jalan.saveStep2') }}", {
                _token: "{{ csrf_token() }}",
                obats: obatData,
                total_harga: totalHarga,
            });

            $('#saved-data-table tr:last').find('td').eq(2).html($('#daftar-obat').html());
            $('#saved-data-table tr:last').find('td').eq(4).text($('#total-harga').text().replace('Total: Rp ', ''));
        }

        currentTab.removeClass('show active');
        nextTab.addClass('show active');
        $('.nav-pills .nav-link.active').parent().next().find('.nav-link').addClass('active');
        $('.nav-pills .nav-link.active').parent().prev().find('.nav-link').removeClass('active');
    }
});

        if (nextTab.length > 0) {
            // riwayat pendaftaran from current step
            if (currentTab.attr('id') === 'step1') {
                let pasien = $('#pasien_id option:selected').text();
                let dokter = $('#dokter_id option:selected').text();
                $('#saved-data-table').append(`
                    <tr>
                        <td>${pasien}</td>
                        <td>${dokter}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                `);
            } else if (currentTab.attr('id') === 'step2') {
                updateRingkasanObat();
                $('#saved-data-table tr:last').find('td').eq(2).text($('#daftar-obat').html());
                $('#saved-data-table tr:last').find('td').eq(4).text($('#total-harga').text().replace('Total: Rp ', ''));
            }

            // Switch tabs
            currentTab.removeClass('show active');
            nextTab.addClass('show active');
            $('.nav-pills .nav-link.active').parent().next().find('.nav-link').addClass('active');
            $('.nav-pills .nav-link.active').parent().prev().find('.nav-link').removeClass('active');
        }
    });

    $('.prev-step').click(function() {
        let currentTab = $(this).closest('.tab-pane');
        let prevTab = currentTab.prev('.tab-pane');

        if (prevTab.length > 0) {
            currentTab.removeClass('show active');
            prevTab.addClass('show active');
            $('.nav-pills .nav-link.active').parent().prev().find('.nav-link').addClass('active');
            $('.nav-pills .nav-link.active').parent().next().find('.nav-link').removeClass('active');
        }
    });

    $('#multiStepForm').submit(function(e) {
        e.preventDefault();

        let isValid = true;

        if ($('#pasien_id').val() === '') {
            alert('Silakan pilih pasien');
            isValid = false;
        }

        if ($('#dokter_id').val() === '') {
            alert('Silakan pilih dokter');
            isValid = false;
        }

        if ($('.obat-select:first').val() === '') {
            alert('Silakan pilih minimal satu obat');
            isValid = false;
        }

        if (isValid) {
            this.submit();
        }
    });
});
</script>
@endsection

<x-rawat-jalan />

@endsection
