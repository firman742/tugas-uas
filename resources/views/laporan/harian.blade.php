@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-5 text-gray-800">Laporan Harian</h2>

        <div class="card shadow mb-3">
            <div class="card-body">
                @if (auth()->user()->role !== 'nasabah')
                    <form method="GET" class="mb-3" id="filterForm">
                        <div class="row">
                            <div class="col">
                                <label>Tanggal : {{ request('tanggal', $tanggal) }}</label> <br>
                                {{-- <input type="date" name="tanggal" value="{{ request('tanggal', $tanggal) }}" onchange="document.getElementById('filterForm').submit();"> --}}
                            </div>
                            <div class="col">
                                <label>User:</label>
                                <select class="form-control" name="user_id"
                                    onchange="document.getElementById('filterForm').submit();">
                                    <option value="">Semua User</option>
                                    @foreach (\App\Models\User::all() as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                @else
                    <p>Tanggal: <strong>{{ $tanggal }}</strong></p>
                @endif
            </div>
        </div>

        <div class="card shadow mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $row)
                                <tr>
                                    <td>{{ $row->user->name ?? '-' }}</td>
                                    <td>{{ $row->total }}</td>
                                    <td>Normal</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
