<x-app-layout>
@section('content')
        <h2 class="mb-4 text-gray-800">Edit Setoran</h2>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('setoran.update', $setoran->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
        
                    <div class="mb-3">
                        <label>Nasabah</label>
                        <select name="user_id" class="form-control" required>
                            @foreach($nasabahs as $nasabah)
                                <option value="{{ $nasabah->id }}" {{ $setoran->user_id == $nasabah->id ? 'selected' : '' }}>
                                    {{ $nasabah->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="mb-3">
                        <label>Tanggal Setor</label>
                        <input type="date" name="tanggal_setor" value="{{ $setoran->tanggal_setor }}" class="form-control" required>
                    </div>
        
                    <div class="mb-3">
                        <label>Jenis Sampah</label>
                        <select name="jenis_sampah" id="jenis_sampah" class="form-control" onchange="setHarga()" required>
                            <option value="">-- Pilih --</option>
                            @foreach($jenisSampahs as $item)
                                <option value="{{ $item->id }}" data-harga="{{ $item->harga_per_kg }}"
                                    {{ $setoran->jenis_sampah == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="mb-3">
                        <label>Berat (kg)</label>
                        <input type="number" step="0.01" name="berat" id="berat" value="{{ $setoran->berat }}" class="form-control" required oninput="hitungTotal()">
                    </div>
        
                    <div class="mb-3">
                        <label>Harga per Kg</label>
                        <input type="number" name="harga_per_kg" id="harga" class="form-control bg-gray-100" readonly>
                    </div>
        
                    <div class="mb-3">
                        <label for="total">Total</label>
                        <input type="number" name="total" id="total" class="form-control bg-gray-100" readonly>
                    </div>
        
                    <div class="mb-3">
                        <label>Upload Foto Baru (opsional)</label>
                        <input type="file" name="foto_bukti" accept="image/*" class="form-control">
                    </div>
        
                    @if($setoran->foto_bukti)
                        <div class="mb-3">
                            <p>Foto Lama:</p>
                            <img src="{{ asset('storage/' . $setoran->foto_bukti) }}" style="width: 50px">
                        </div>
                    @endif
        
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('setoran.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
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

    @endsection
</x-app-layout>
