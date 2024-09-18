@extends('layouts.user_type.admin') 

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form id="multiStepForm" action="{{ route('rawat-jalan.store') }}" method="POST">
                @csrf
                {{-- <input type="hidden" name="id_rawat_jalan" value="{{ $rawatJalan->id ?? '' }}"> --}}
                <div class="tab-content">
                    <!-- Step 1: Pendaftaran -->
                    <div class="tab-pane fade show active" id="step1">
                        <div class="mb-3">
                            <label for="pasien_id" class="form-label">Cari Pasien</label>
                            <select name="pasien_id" class="form-control mt-2 select2" id="pasien_id" required>
                                <option value="" selected>Pilih Pasien</option>
                                @foreach ($pasiens as $pasien)
                                    <option value="{{ $pasien->id }}">{{ $pasien->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dokter_id" class="form-label">Pilih Dokter</label>
                            <select name="dokter_id" class="form-select select2" id="dokter_id" required>
                                <option value="" selected>Pilih Dokter</option>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}">{{ $dokter->nama_dokter }} - {{ $dokter->spesialis }} - {{ $dokter->nama_spesialis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary next-step" data-step="step1">Next</button>
                    </div>
        
                    <!-- Step 2: Pemeriksaan -->
                    <div class="tab-pane fade" id="step2">
                        <div id="obat-container">
                            <div class="mb-3 obat-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="obat_id" class="form-label">Pilih Obat</label>
                                    <button type="button" class="btn btn-danger btn-sm hapus-obat" style="display: none;">Hapus</button>
                                </div>
                                <select name="obat_id[]" class="form-select select2 obat-select w-100" id="obat_id" data-live-search="true" required>
                                    <option value="" disabled selected>Pilih Obatsss</option>
                                    @foreach ($obats as $obat)
                                        <option value="{{ $obat->id_obat }}" data-harga="{{ $obat->harga_obat }}" data-stok="{{ $obat->stok_obat }}">{{ $obat->nama_obat }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="jumlah[]" class="form-control mt-2 obat-jumlah" placeholder="Jumlah" required min="1">
                            </div>
                        </div>                        
        
                        <button type="button" class="btn btn-secondary mt-2" id="tambah-obat">Tambah Obat</button>
        
                        <!-- Ringkasan Obat -->
                        <div id="ringkasan_obat" class="mt-3">
                            <h5>Ringkasan Obat</h5>
                            <ul id="daftar-obat"></ul>
                            <p id="total-harga">Total: Rp 0</p>
                        </div>
        
                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary prev-step" data-step="step2">Previous</button>
                            <button type="button" class="btn btn-primary next-step" data-step="step2">Next</button>
                        </div>
                    </div>
        
                    <!-- Step 3: Pembayaran -->
                    <div class="tab-pane fade" id="step3">
                        <div class="mb-3">
                            <label for="invoice_total" class="form-label">Total Biaya</label>
                            <input type="text" name="invoice_total" class="form-control" id="invoice_total" readonly>
                        </div>
                        <button type="button" class="btn btn-secondary prev-step" data-step="step3">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-body">
            <h5>Daftar Pasien Menunggu</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Pasien</th>
                        <th>Dokter</th>
                        <th>Progres</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rawatJalan as $entry)
                        <tr>
                            <td>{{ $entry->pasien->nama_lengkap }}</td>
                            <td>{{ $entry->dokter->nama_dokter }}</td>
                            <td>
                                @if($entry->step === 'step1')
                                    Pendaftaran
                                @elseif($entry->step === 'step2')
                                    Pemeriksaan
                                @elseif($entry->step === 'step3')
                                    Pembayaran
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('rawat-jalan.show', $entry->id) }}" class="btn btn-primary">Lanjutkan Proses</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</div>
@endsection

@section('search-filter')

<script>
   $(document).ready(function() {
    $('.select2').select2();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle Next and Previous buttons
    $('.next-step').click(function() {
        let step = $(this).data('step');
        submitStep(step);
    });

    $('.prev-step').click(function() {
        let step = $(this).data('step');
        showStep(step);
    });

    $('#tambah-obat').click(function() {
        let newObatItem = `
            <div class="mb-3 obat-item">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="obat_id" class="form-label">Pilih Obat</label>
                    <button type="button" class="btn btn-danger btn-sm hapus-obat">Hapus</button>
                </div>
                <select name="obat_id[]" class="form-select select2 obat-select" required>
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
    });

    
    $('#obat-container').on('change', '.obat-jumlah, .obat-select', function() {
        updateRingkasanObat();
    });

    function updateRingkasanObat() {
        let total = 0;
        $('#daftar-obat').empty();
        $('.obat-item').each(function() {
            let obat = $(this).find('.obat-select option:selected').text();
            let harga = $(this).find('.obat-select option:selected').data('harga');
            let jumlah = $(this).find('.obat-jumlah').val();
            let subtotal = harga * jumlah;
            total += subtotal;
            $('#daftar-obat').append(`<li>${obat} - ${jumlah} x Rp ${harga} = Rp ${subtotal}</li>`);
        });
        $('#total-harga').text(`Total: Rp ${total}`);
        $('#invoice_total').val(total);
    }

    function submitStep(step) {
        let url = '';
        let method = '';
        
        if (step === 'step1') {
            url = '{{ route('rawat-jalan.step1') }}';
            method = 'POST';
        } else if (step === 'step2') {
            url = '{{ route('rawat-jalan.step2') }}';
            method = 'PUT';
        } else if (step === 'step3') {
            url = '{{ route('rawat-jalan.step3') }}';
            method = 'PUT';
        }

        let formData = new FormData($('#multiStepForm')[0]);
        
        formData.append('current_step', step);

        if (step === 'step2' || step === 'step3') {
            let rawatJalanId = localStorage.getItem('id_rawat_jalan');
            if (rawatJalanId) {
                formData.append('id_rawat_jalan', rawatJalanId);
            }
        }

        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            type: method,
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Success Response:', response);
                if (response.success) {
                    if (step === 'step1') {
                        if (response.id_rawat_jalan) {
                            localStorage.setItem('id_rawat_jalan', response.id_rawat_jalan);
                        }
                        showStep('step2');
                    } else if (step === 'step2') {
                        showStep('step3');
                    } else if (step === 'step3') {
                        $('#multiStepForm')[0].reset();
                        localStorage.removeItem('id_rawat_jalan');
                        alert('Form submitted successfully!');
                    }
                } else {
                    alert('Terjadi kesalahan: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error Response:', xhr.responseText);
                let errorMessage = 'Terjadi kesalahan: ';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    for (let field in xhr.responseJSON.errors) {
                        errorMessage += xhr.responseJSON.errors[field].join(', ') + '\n';
                    }
                } else {
                    errorMessage += error;
                }
                alert(errorMessage);
            }
        });
    }
    function showStep(step) {
        $('.tab-pane').removeClass('show active');
        let stepElement = $(`#${step}`);
        if (stepElement.length) {
            stepElement.addClass('show active');
        } else {
            console.error(`Step element #${step} not found`);
        }
    }
});
</script>


@endsection
<x-rawat-jalan />
