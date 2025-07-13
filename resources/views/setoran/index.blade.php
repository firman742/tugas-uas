<x-app-layout>
    @section('content')
        <h2 class="text-xl font-bold mb-4">Riwayat Buku Kecil (Setoran)</h2>

        <div class="card shadow mb-2">
            <div class="card-body">
                <form method="GET" action="{{ route('setoran.index') }}" class="mb-4 space-x-2">
                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="border p-2 rounded"
                        placeholder="Dari">
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="border p-2 rounded"
                        placeholder="Sampai">
                    <input type="text" name="jenis" value="{{ request('jenis') }}" placeholder="Jenis Sampah"
                        class="border p-2 rounded">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('setoran.create') }}" class="btn btn-primary mb-3">+ Tambah Setoran</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="bg-gray-100">
                                @if (auth()->user()->role !== 'nasabah')
                                    <th>Nama Nasabah</th>
                                @endif
                                <th>Tanggal</th>
                                <th>Jenis Sampah</th>
                                <th>Berat (kg)</th>
                                <th>Harga/kg</th>
                                <th>Total</th>
                                <th>Bukti Foto</th>
                                <th>Status</th>
                                <th>Verifikasi</th>
                                @if (auth()->user()->role !== 'nasabah')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($setorans as $s)
                                <tr>
                                    @if (auth()->user()->role !== 'nasabah')
                                        <td>{{ $s->user->name }}</td>
                                    @endif
                                    <td>{{ $s->tanggal_setor }}</td>
                                    <td>{{ $s->jenisSampah->nama ?? 'Tidak Diketahui' }}</td>
                                    <td>{{ $s->berat }}</td>
                                    <td>Rp{{ number_format($s->harga_per_kg) }}</td>
                                    <td>Rp{{ number_format($s->total) }}</td>
                                    <td>
                                        @if ($s->foto_bukti)
                                            <a href="{{ asset('storage/' . $s->foto_bukti) }}" target="_blank">Lihat Foto</a>
                                        @else
                                            Tidak Ada
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="px-2 py-1 rounded text-xs font-semibold
                                            {{ $s->status === 'Terjual' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                            {{ $s->status }}
                                        </span>
                                    </td>
            
                                    @if (auth()->user()->role !== 'nasabah')
                                        <td>
                                            @if ($s->status === 'Belum')
                                                <form action="{{ route('setoran.updateStatus', $s->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Terjual">
                                                    <button type="submit" class="btn btn-danger">Tandai
                                                        Terjual</button>
                                                </form>
                                            @else
                                                <form action="{{ route('setoran.updateStatus', $s->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Belum">
                                                    <button type="submit" class="btn btn-sm btn-danger">Kembalikan ke
                                                        Belum</button>
                                                </form>
                                            @endif
                                        </td>
                                    @endif
            
                                    @if (auth()->user()->role !== 'nasabah')
                                        <td style="width: 150px">
                                            <a href="{{ route('setoran.edit', $s->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('setoran.destroy', $s->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin hapus data ini?')"
                                                    class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    @endif
            
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-2">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <script>
            const ctx = document.getElementById('pieChart').getContext('2d');
            const pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Jumlah Setoran',
                        data: @json($values),
                        backgroundColor: [
                            '#f94144', '#f3722c', '#f8961e',
                            '#f9844a', '#43aa8b', '#577590',
                            '#90be6d', '#277da1', '#e76f51', '#a8dadc'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Perbandingan Setoran per Nama'
                        }
                    }
                }
            });
        </script>

    @endsection
</x-app-layout>
