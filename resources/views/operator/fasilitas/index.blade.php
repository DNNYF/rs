@extends('layouts.user_type.admin')
@section('content')

<h1>Daftar Fasilitas</h1>
    <a href="{{ route('operator.fasilitas.create') }}" class="btn btn-primary">Tambah Fasilitas Baru</a>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="card mb-2">
    <div class="card-body">
        <form id="filterForm" action="{{ route('operator.fasilitas.index') }}" method="GET">
            <div class="row g-3 align-items-center mb-3">
                <div class="col-2">
                    <select class="form-select" id="statusFilter" name="status">
                        <option value="" >Status</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-sm">
                    <div class="input-group">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="searchInput" name="search" value="{{ request('search') }}">
                        <button class="btn btn-outline-primary my-sm-0" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th class="col-1" >#</th>
                    <th class="col">Fasilitas</th>
                    <th class="col">Deskripsi</th>
                    <th class="col">Status</th>
                    <th class="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = $fasilitas->firstItem(); @endphp
                @foreach($fasilitas as $fs)
                    <tr>
                        <td class="col">{{ $no++ }}</td>
                        <td>{{ $fs->fasilitas }}</td>
                        <td>{{ $fs->deskripsi }}</td>
                        <td>{{ $fs->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                        <td>
                            <a href="{{ route('operator.fasilitas.edit', $fs->id) }}" class="btn btn-warning">Edit</a>

                            <form action="{{ route('operator.fasilitas.destroy', $fs->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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