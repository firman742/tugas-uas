@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-5 text-gray-800">Laporan Bulanan</h2>

        <div class="card shadow mb-4">
            <div class="card-body">
                @if (auth()->user()->role !== 'nasabah')
                    <form method="GET" class="mb-3" id="filterForm">
                        <div class="row">
                            <div class="col">
                                <label>Bulan : {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</label>
                                {{-- <select name="bulan">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                    @endfor
                                </select> --}}
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
                    <p>Bulan: <strong>{{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</strong></p>
                @endif
            </div>
        </div>

        <div class="card shadow mb-4">
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
