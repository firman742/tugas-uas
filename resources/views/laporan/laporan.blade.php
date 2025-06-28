@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Laporan Harian & Bulanan</h2>

    @if(auth()->check())
        <p>Login sebagai: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->is_admin ? 'Admin' : 'User' }})</p>
    @endif

    <form method="GET" class="mb-3" id="filterForm">
        <label>Tanggal:</label>
        <input type="date" name="tanggal" value="{{ request('tanggal') }}" onchange="document.getElementById('filterForm').submit();">

        <label>Bulan:</label>
        <select name="bulan" onchange="document.getElementById('filterForm').submit();">
            <option value="">-- Semua Bulan --</option>
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                </option>
            @endfor
        </select>

        @if(auth()->user()?->is_admin)
            <label>User:</label>
            <select name="user_id" onchange="document.getElementById('filterForm').submit();">
                <option value="">-- Semua User --</option>
                @foreach(\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        @endif
    </form>

    <form method="POST" action="{{ route('laporan.store') }}">
        @csrf
        <div>
            <input type="date" name="tanggal" required>
            <input type="text" name="jenis_barang" placeholder="Jenis Barang" required>
            <input type="number" name="jumlah_barang" placeholder="Jumlah" required>
            @if(auth()->user()?->is_admin)
                <select name="user_id" required>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            @else
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            @endif
            <button type="submit">Tambah</button>
        </div>
    </form>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama User</th>
                <th>Jenis Barang</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Verifikasi</th>
                @if(auth()->user()?->is_admin)
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $row)
                <tr>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->user->name ?? '-' }}</td>
                    <td>{{ $row->jenis_barang }}</td>
                    <td>{{ $row->jumlah_barang }}</td>
                    <td>{{ $row->status ? 'Bermasalah' : 'Normal' }}</td>
                    <td>{{ $row->verifikasi ? '✔' : '✘' }}</td>
                    @if(auth()->user()?->is_admin)
                        <td>
                            @if(!$row->verifikasi)
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
@endsection
