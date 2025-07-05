<x-app-layout>
    @section('content')
        <h1 class="mb-5 text-gray-800">Manajemen Pengguna</h1>
        <!-- Pesan sukses -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('users.create') }}" class="btn btn-primary mt-3 rounded rounded-4"><i
                    class="bi bi-plus-square"></i> Tambah Pengguna</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nomor Telpon</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Peran</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->address ?? '-' }}</td>
                                    <td>{{ ($user->role ?? '-') }}</td>
                                    <td>
                                        @if ($user->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Tombol Show -->
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if (auth()->user()->role === 'superadmin')
                                            <!-- Tombol Delete -->
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
