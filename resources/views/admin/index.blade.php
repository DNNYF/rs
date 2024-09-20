@extends('layouts.user_type.admin')
@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Daftar User</h1>

    <div class="mb-3">
        <a href="{{ route('admin.create') }}" class="btn btn-primary">Tambah User Baru</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form id="filterForm" action="{{ route('admin.index') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <select class="form-select" id="roleFilter" name="role">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                            <option value="pasien" {{ request('role') == 'pasien' ? 'selected' : '' }}>Pasien</option>
                            <option value="perawat" {{ request('role') == 'perawat' ? 'selected' : '' }}>Perawat</option>
                        </select>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="searchInput" name="search" value="{{ request('search') }}">
                            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($admins->count() > 0)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Role</th>
                            <th scope="col">Email</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $index => $admin)
                            <tr>
                                <td>{{ $admins->firstItem() + $index }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->role }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                    <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $admins->links() }}
                </div>
            @else
                <p class="text-muted">Tidak ada data yang ditemukan.</p>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const roleFilter = $('#roleFilter');
        const searchInput = $('#searchInput');
        const filterForm = $('#filterForm');

        function updateAdminTable() {
            $.ajax({
                url: '{{ route('admin.index') }}',
                method: 'GET',
                data: filterForm.serialize(),
                success: function(response) {
                    $('#adminTableContainer').html($(response).find('#adminTableContainer').html());
                    history.pushState(null, '', '{{ route('admin.index') }}');
                }
            });
        }

        roleFilter.on('change', updateAdminTable);

        let typingTimer;
        const doneTypingInterval = 500; // ms

        searchInput.on('input', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(updateAdminTable, doneTypingInterval);
        });

        filterForm.on('submit', function(e) {
            e.preventDefault();
            updateAdminTable();
        });

        // Initial load
        updateAdminTable();
    });
</script>
@endpush
