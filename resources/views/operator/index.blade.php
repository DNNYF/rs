@extends('layouts.user_type.admin')
@section('content')

<h1>Daftar Pasien</h1>
    <a href="{{ route('operator.create') }}" class="btn btn-primary">Tambah Pasien Baru</a>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('operator.index') }}" method="GET">
            <div class="input-group">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="{{ request('search') }}">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">No. telp</th>
                    <th scope="col">Email</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $operators->firstItem(); @endphp
                @foreach($operators as $op)
                    <tr>
                        <td scope="row">{{ $no++ }}</td>
                        <td>{{ $op->name }}</td>
                        <td>{{ $op->phone }}</td>
                        <td>{{ $op->email }}</td>
                        <td>{{ $op->about_me }}</td>
                        <td>
                            <a href="{{ route('operator.show', $op->id) }}" class="btn btn-info">Lihat</a>
                            <a href="{{ route('operator.edit', $op->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('operator.destroy', $op->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            
        </table>
        
        <!-- Menambahkan kontrol paginasi -->
        {{-- <div class="d-flex justify-content-center">
            {{!! $@case($op)
                
            @break>links() }}
        </div>
         --}}
        
    </div>
</div>
@endsection