@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pengaturan Aplikasi</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_aplikasi">Nama Aplikasi</label>
            <input type="text" class="form-control" id="nama_aplikasi" name="nama_aplikasi" value="{{ $pengaturan['nama_aplikasi'] }}">
        </div>

        <div class="form-group">
            <label for="logo">Logo Aplikasi</label>
            <input type="file" class="form-control-file" id="logo" name="logo">
            @if($pengaturan['logo_aplikasi'])
                <img src="{{ asset('storage/' . $pengaturan['logo_aplikasi']) }}" alt="Logo Aplikasi" class="mt-2" style="max-width: 200px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
    </form>
</div>
@endsection
