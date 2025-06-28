@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Laporan Bulanan</h2>

    @if(auth()->user()?->is_admin)
    <form method="GET" class="mb-3" id="filterForm">
        <label>Bulan : {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</label> <br>
        {{-- <select name="bulan">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                </option>
            @endfor
        </select> --}}
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
    <p>Bulan: <strong>{{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</strong></p>
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
