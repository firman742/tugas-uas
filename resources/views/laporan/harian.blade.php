@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Laporan Harian</h2>

    @if(auth()->user()?->is_admin)
    <form method="GET" class="mb-3" id="filterForm">
        <label>Tanggal : {{ request('tanggal', $tanggal) }}</label> <br>
        {{-- <input type="date" name="tanggal" value="{{ request('tanggal', $tanggal) }}" onchange="document.getElementById('filterForm').submit();"> --}}
        <label>User:</label>
        <select name="user_id" onchange="document.getElementById('filterForm').submit();">
            <option value="">Semua User</option>
            @foreach(\App\Models\User::all() as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </form>
    @else
    <p>Tanggal: <strong>{{ $tanggal }}</strong></p>
    @endif

    <table class="table">
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
                <tr><td colspan="3">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
