<x-app-layout>
    @section('content')
        <h2 class="text-xl font-bold mb-4">Form Input Setoran Sampah</h2>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('setoran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Nasabah -->
                    <div class="mb-2">
                        <label>Nasabah</label>
                        <select name="user_id" required class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">-- Pilih Nasabah --</option>
                            @foreach ($nasabahs as $nasabah)
                                <option value="{{ $nasabah->id }}">{{ $nasabah->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-2">
                        <label>Tanggal Setor</label>
                        <input type="date" name="tanggal_setor" required
                            class="form-control @error('tanggal_setor') is-invalid @enderror">
                        @error('tanggal_setor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Sampah -->
                    <div class="mb-2">
                        <label for="jenis_sampah">Jenis Sampah</label>
                        <select name="jenis_sampah" id="jenis_sampah"
                            class="form-control @error('jenis_sampah') is-invalid @enderror" onchange="setHarga()" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($jenisSampahs as $item)
                                <option value="{{ $item->id }}" data-harga="{{ $item->harga_per_kg }}">
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_sampah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Berat -->
                    <div class="mb-2">
                        <label for="berat">Berat (kg)</label>
                        <input type="number" step="0.1" min="0.1" name="berat" id="berat"
                            class="form-control @error('berat') is-invalid @enderror" oninput="hitungTotal()" required>
                        @error('berat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Harga per kg -->
                    <div class="mb-2">
                        <label for="harga">Harga per Kg</label>
                        <input type="number" name="harga_per_kg" id="harga"
                            class="form-control @error('harga') is-invalid @enderror bg-gray-100" readonly required>
                        @error('harga_per_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Total -->
                    <div class="mb-2">
                        <label for="total">Total</label>
                        <input type="number" name="total" id="total"
                            class="form-control @error('total') is-invalid @enderror bg-gray-100" readonly required>
                        @error('total')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload Foto -->
                    <div class="mb-2">
                        <label>Upload Foto Bukti (opsional)</label>
                        <input type="file" name="foto_bukti" accept="image/*"
                            class="form-control @error('foto_bukti') is-invalid @enderror">
                        @error('foto_bukti')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    <a href="{{ route('setoran.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>

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
    @endsection
</x-app-layout>
