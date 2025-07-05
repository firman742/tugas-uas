<x-app-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Form Input Setoran Sampah</h2>

        @if(session('success'))
            <div class="text-green-600">{{ session('success') }}</div>
        @endif

        <form action="{{ route('setoran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Nasabah -->
            <div>
                <label>Nasabah</label>
                <select name="user_id" required class="w-full border p-2">
                    <option value="">-- Pilih Nasabah --</option>
                    @foreach($nasabahs as $nasabah)
                        <option value="{{ $nasabah->id }}">{{ $nasabah->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label>Tanggal Setor</label>
                <input type="date" name="tanggal_setor" required class="w-full border p-2">
            </div>

            <!-- Jenis Sampah -->
            <div>
                <label for="jenis_sampah">Jenis Sampah</label>
                <select name="jenis_sampah" id="jenis_sampah" class="w-full border p-2" onchange="setHarga()" required>
                    <option value="">-- Pilih --</option>
                    @foreach($jenisSampahs as $item)
                        <option value="{{ $item->id }}" data-harga="{{ $item->harga_per_kg }}">
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Berat -->
            <div>
                <label for="berat">Berat (kg)</label>
                <input type="number" step="0.1" min="0.1" name="berat" id="berat" class="w-full border p-2" oninput="hitungTotal()" required>
            </div>

            <!-- Harga per kg -->
            <div>
                <label for="harga">Harga per Kg</label>
                <input type="number" name="harga_per_kg" id="harga" class="w-full border p-2 bg-gray-100" readonly required>
            </div>

            <!-- Total -->
            <div>
                <label for="total">Total</label>
                <input type="number" name="total" id="total" class="w-full border p-2 bg-gray-100" readonly required>
            </div>

            <!-- Upload Foto -->
            <div>
                <label>Upload Foto Bukti (opsional)</label>
                <input type="file" name="foto_bukti" accept="image/*" class="w-full border p-2">
            </div>

            <!-- Submit -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>

        <!-- Script JS -->
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
        </script>
    </div>
</x-app-layout>
