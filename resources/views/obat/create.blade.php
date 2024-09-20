@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="mb-4">Tambah Obat Baru</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Tambah Obat</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('obat.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="biaya_pelayanan" name="harga" placeholder="Rp 0" min="0" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambahkan</button>
                        <a href="{{ route('obat.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const biayaPelayananInput = document.getElementById('biaya_pelayanan');

    biayaPelayananInput.addEventListener('input', function(e) {
        let input = e.target.value;

        input = input.replace(/[^,\d]/g, '');

        if (input === '') {
            e.target.value = '';
            return;
        }

        const formattedInput = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(input);

        e.target.value = formattedInput.replace(/[A-Za-z]{3}/g, 'Rp').trim();
    });
    document.querySelector('form').addEventListener('submit', function(event) {
        let rawValue = biayaPelayananInput.value;

        rawValue = rawValue.replace(/[^,\d]/g, '');

        if (rawValue === '' || rawValue === '0') {
            alert('Biaya Pelayanan tidak boleh Rp 0 atau kosong.');
            event.preventDefault(); 
            return;
        }
        biayaPelayananInput.value = rawValue;
    });
</script>

@endsection
