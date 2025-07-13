<x-app-layout>
@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Riwayat Buku Kecil (Setoran)</h2>


        <form method="GET" action="{{ route('setoran.index') }}" class="mb-4 space-x-2">
            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="border p-2 rounded" placeholder="Dari">
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="border p-2 rounded" placeholder="Sampai">
            <input type="text" name="jenis" value="{{ request('jenis') }}" placeholder="Jenis Sampah" class="border p-2 rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
        </form>


        <table class="w-full border border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    @if(auth()->user()->role === 'admin')
                        <th class="border p-2">Nama Nasabah</th>
                    @endif
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Jenis Sampah</th>
                    <th class="border p-2">Berat (kg)</th>
                    <th class="border p-2">Harga/kg</th>
                    <th class="border p-2">Total</th>
                    <th class="border p-2">Bukti Foto</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Verifikasi</th>
                    @if(auth()->user()->role === 'admin')
                        <th class="border p-2">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($setorans as $s)
                    <tr>
                        @if(auth()->user()->role === 'admin')
                            <td class="border p-2">{{ $s->user->name }}</td>
                        @endif
                        <td class="border p-2">{{ $s->tanggal_setor }}</td>
                        <td class="border p-2">{{ $s->jenisSampah->nama ?? 'Tidak Diketahui' }}</td>
                        <td class="border p-2">{{ $s->berat }}</td>
                        <td class="border p-2">Rp{{ number_format($s->harga_per_kg) }}</td>
                        <td class="border p-2">Rp{{ number_format($s->total) }}</td>
                        <td class="border p-2">
                            @if($s->foto_bukti)
                                <a href="{{ asset('storage/' . $s->foto_bukti) }}" target="_blank">Lihat Foto</a>
                            @else
                                Tidak Ada
                            @endif
                        </td>
                        <td class="border p-2">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $s->status === 'Terjual' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                {{ $s->status }}
                            </span>
                        </td>

                        @if(auth()->user()->role === 'admin')
                            <td class="border p-2">
                                @if($s->status === 'Belum')
                                    <form action="{{ route('setoran.updateStatus', $s->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Terjual">
                                        <button type="submit" class="text-blue-600 hover:underline">Tandai Terjual</button>
                                    </form>
                                @else
                                    <form action="{{ route('setoran.updateStatus', $s->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Belum">
                                        <button type="submit" class="text-red-600 hover:underline">Kembalikan ke Belum</button>
                                    </form>
                                @endif
                            </td>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <td class="border p-2 space-x-2">
                                <a href="{{ route('setoran.edit', $s->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('setoran.destroy', $s->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus data ini?')" class="text-red-500 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        @endif

                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center p-2">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
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
                    legend: { position: 'top' },
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
