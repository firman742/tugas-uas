<x-app-layout>
    @section('content')
        <h1 class="mb-5 text-gray-800">Data Penjualan Sampah</h1>

        <!-- Pesan sukses -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">+ Tambah Penjualan</a>
                    </div>
                    <div class="col-6">
                        <form method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="Cari tengkulak...">
                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Tengkulak</th>
                                <th>Jenis Sampah</th>
                                <th>Jumlah (Per KG)</th>
                                <th>Total Penjualan</th>
                                <th>Bukti</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjualans as $penjualan)
                                @php $rowspan = count($penjualan->details); @endphp
                                @foreach ($penjualan->details as $i => $detail)
                                    <tr>
                                        @if ($i === 0)
                                            <td rowspan="{{ $rowspan }}">{{ \Carbon\Carbon::parse($penjualan->tanggal)->translatedFormat('d F Y') }}</td>
                                            <td rowspan="{{ $rowspan }}">{{ $penjualan->nama_tengkulak }}</td>
                                        @endif
                        
                                        <td>{{ $detail->jenisSampah->nama ?? '-' }}</td>
                                        <td>{{ $detail->jumlah }} kg</td>
                                        <td>Rp{{ number_format($detail->total_penjualan, 0, ',', '.') }}</td>
                        
                                        @if ($i === 0)
                                            <td rowspan="{{ $rowspan }}">
                                                @if ($penjualan->bukti)
                                                    <img src="{{ asset('storage/bukti/' . $penjualan->bukti) }}" width="80">
                                                @else
                                                    Tidak ada
                                                @endif
                                            </td>
                                            <td rowspan="{{ $rowspan }}" class="text-center">
                                                <a href="{{ route('sales.edit', $penjualan->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <form action="{{ route('sales.destroy', $penjualan->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
