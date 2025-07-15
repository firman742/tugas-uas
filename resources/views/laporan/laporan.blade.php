<x-app-layout>
    @section('content')
        <div class="container">
            <h2 class="mb-2 text-gray-800">Laporan Harian & Bulanan</h2>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('laporan.store') }}">
                        @csrf
                        <h4>Tambah Laporan</h4>
                        <div class="row">
                            <div class="col">
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="jenis_barang" placeholder="Jenis Barang"
                                    required>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="jumlah_barang" placeholder="Jumlah"
                                    required>
                            </div>
                            <div class="col">
                                @if (auth()->user()->role !== 'nasabah')
                                    <select class="form-control" name="user_id" required>
                                        @foreach (\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="hidden" class="form-control" name="user_id" value="{{ auth()->id() }}">
                                @endif
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-3">
                <div class="card-header">
                    <form method="GET" class="mb-3" id="filterForm">
                        {{-- Filter berdasarkan tanggal dan bulan --}}
                        <div class="row">
                            <div class="col-4">
                                <label>Tanggal:</label>
                                <input class="form-control" type="date" name="tanggal" value="{{ request('tanggal') }}"
                                    onchange="document.getElementById('filterForm').submit();">
                            </div>
                            <div class="col-4">
                                <label>Bulan:</label>
                                <select class="form-control" name="bulan"
                                    onchange="document.getElementById('filterForm').submit();">
                                    <option value="">-- Semua Bulan --</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-4">
                                @if (auth()->user()->role !== 'nasabah')
                                    <label>User:</label>
                                    <select class="form-control" name="user_id"
                                        onchange="document.getElementById('filterForm').submit();">
                                        <option value="">-- Semua User --</option>
                                        @foreach (\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama User</th>
                                    <th>Jenis Barang</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Verifikasi</th>
                                    @if (auth()->user()?->is_admin)
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporan as $row)
                                    <tr>
                                        <td>{{ $row->tanggal }}</td>
                                        <td>{{ $row->user->name ?? '-' }}</td>
                                        <td>{{ $row->jenis_barang }}</td>
                                        <td>{{ $row->jumlah_barang }}</td>
                                        <td>{{ $row->status ? 'Bermasalah' : 'Normal' }}</td>
                                        <td>{{ $row->verifikasi ? '✔' : '✘' }}</td>
                                        @if (auth()->user()?->is_admin)
                                            <td>
                                                @if (!$row->verifikasi)
                                                    <form method="POST" action="{{ route('laporan.verifikasi', $row->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit">Verifikasi</button>
                                                    </form>
                                                @else
                                                    <em>Sudah</em>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
