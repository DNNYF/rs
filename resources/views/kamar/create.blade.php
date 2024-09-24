@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('kamar.index') }}" class="me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                    </svg>
                </a>
                <h1 class="mb-3">{{ isset($kamar) ? 'Edit' : 'Tambah' }} Kamar</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($kamar) ? route('kamar.update', $kamar->id) : route('kamar.store') }}" method="POST">
                        @csrf
                        @if(isset($kamar))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                            <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" value="{{ isset($kamar) ? $kamar->nomor_kamar : old('nomor_kamar') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="penghuni_kamar" class="form-label">Penghuni Kamar</label>
                            <input type="text" class="form-control" id="penghuni_kamar" name="penghuni_kamar" value="{{ isset($kamar) ? $kamar->penghuni_kamar : old('penghuni_kamar') }}">
                        </div>

                        <div class="mb-3">
                            <label for="dokter_jaga" class="form-label">Dokter Jaga</label>
                            <input type="text" class="form-control" id="dokter_jaga" name="dokter_jaga" value="{{ isset($kamar) ? $kamar->dokter_jaga : old('dokter_jaga') }}">
                        </div>

                        <div class="mb-3">
                            <label for="dokter_spesialis" class="form-label">Dokter Spesialis</label>
                            <input type="text" class="form-control" id="dokter_spesialis" name="dokter_spesialis" value="{{ isset($kamar) ? $kamar->dokter_spesialis : old('dokter_spesialis') }}">
                        </div>

                        <div class="mb-3">
                            <label for="perawat" class="form-label">Perawat</label>
                            <input type="text" class="form-control" id="perawat" name="perawat" value="{{ isset($kamar) ? $kamar->perawat : old('perawat') }}">
                        </div>

                        <div class="mb-3">
                            <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
                            <input type="text" class="form-control" id="tipe_kamar" name="tipe_kamar" value="{{ isset($kamar) ? $kamar->tipe_kamar : old('tipe_kamar') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="kosong" {{ isset($kamar) && $kamar->status == 'kosong' ? 'selected' : '' }}>Kosong</option>
                                <option value="terisi" {{ isset($kamar) && $kamar->status == 'terisi' ? 'selected' : '' }}>Terisi</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ isset($kamar) ? 'Update' : 'Simpan' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
