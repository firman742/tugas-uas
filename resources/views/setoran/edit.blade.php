<x-app-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Edit Setoran</h2>

        <form action="{{ route('setoran.update', $setoran->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label>Nasabah</label>
                <select name="user_id" class="w-full border p-2" required>
                    @foreach($nasabahs as $nasabah)
                        <option value="{{ $nasabah->id }}" {{ $setoran->user_id == $nasabah->id ? 'selected' : '' }}>
                            {{ $nasabah->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Tanggal Setor</label>
                <input type="date" name="tanggal_setor" value="{{ $setoran->tanggal_setor }}" class="w-full border p-2" required>
            </div>

            <div>
                <label>Jenis Sampah</label>
                <select name="jenis_sampah" id="jenis_sampah" class="w-full border p-2" onchange="setHarga()" required>
                    <option value="">-- Pilih --</option>
                    @foreach($jenisSampahs as $item)
                        <option value="{{ $item->id }}" data-harga="{{ $item->harga_per_kg }}"
                            {{ $setoran->jenis_sampah == $item->id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Berat (kg)</label>
                <input type="number" step="0.01" name="berat" id="berat" value="{{ $setoran->berat }}" class="w-full border p-2" required oninput="hitungTotal()">
            </div>

            <div>
                <label>Harga per Kg</label>
                <input type="number" name="harga_per_kg" id="harga" class="w-full border p-2 bg-gray-100" readonly>
            </div>

            <div>
                <label for="total">Total</label>
                <input type="number" name="total" id="total" class="w-full border p-2 bg-gray-100" readonly>
            </div>

            <div>
                <label>Upload Foto Baru (opsional)</label>
                <input type="file" name="foto_bukti" accept="image/*" class="w-full border p-2">
            </div>

            @if($setoran->foto_bukti)
                <div>
                    <p>Foto Lama:</p>
                    <img src="{{ asset('storage/' . $setoran->foto_bukti) }}" class="w-40">
                </div>
            @endif

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </form>
        <script>
            function setHarga() {
                const select = document.getElementById('jenis_sampah');
                const harga = select.options[select.selectedIndex].getAttribute('data-harga');
                document.getElementById('harga').value = harga;
                hitungTotal();
            }

            function hitungTotal() {
                const berat = parseFloat(document.getElementById('berat').value) || 0;
                const harga = parseFloat(document.getElementById('harga').value) || 0;
                const total = berat * harga;
                document.getElementById('total').value = total;
            }

            // Jalankan saat halaman pertama kali dibuka
            document.addEventListener('DOMContentLoaded', function() {
                setHarga(); // ambil harga dari item yang dipilih
            });
        </script>

    </div>
</x-app-layout>
