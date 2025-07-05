<x-app-layout>
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
                        <td class="border p-2">{{ $s->jenis_sampah }}</td>
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
</x-app-layout>
