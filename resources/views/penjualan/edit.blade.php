<x-app-layout>
    @section('content')
        <h1 class="mb-4 text-gray-800">Edit Penjualan Sampah</h1>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('sales.update', $penjualan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $penjualan->tanggal }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Nama Tengkulak</label>
                        <input type="text" name="nama_tengkulak" class="form-control"
                            value="{{ $penjualan->nama_tengkulak }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Ganti Bukti Foto (kosongkan jika tidak diganti)</label>
                        <input type="file" name="bukti" class="form-control" accept="image/*">
                        <br>
                        @if ($penjualan->bukti)
                            <img src="{{ asset('storage/bukti/' . $penjualan->bukti) }}" width="100">
                        @endif
                    </div>

                    <table class="table" id="sampahTable">
                        <thead>
                            <tr>
                                <th>Jenis Sampah</th>
                                <th>Jumlah</th>
                                <th>Total Penjualan</th>
                                <th><button type="button" class="btn btn-sm btn-success" id="addRow">+</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan->details as $detail)
                                <tr>
                                    <td>
                                        <select name="jenis_sampah[]" class="form-control" required>
                                            <option value="" disabled>-- Pilih Jenis --</option>
                                            @foreach (['kardus', 'botol', 'logam', 'kertas hvs', 'kertas duplex', 'tembaga', 'ban motor'] as $jenis)
                                                <option value="{{ $jenis }}"
                                                    {{ $detail->jenis_sampah == $jenis ? 'selected' : '' }}>
                                                    {{ ucfirst($jenis) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="jumlah[]" class="form-control"
                                            value="{{ $detail->jumlah }}" required></td>
                                    <td><input type="number" name="total_penjualan[]" class="form-control"
                                            value="{{ $detail->total_penjualan }}" readonly></td>
                                    <td><button type="button" class="btn btn-sm btn-danger removeRow">x</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>

        <script>
            const hargaSampah = {
                kardus: 1500,
                botol: 2000,
                logam: 4500,
                "kertas hvs": 900,
                "kertas duplex": 1200,
                tembaga: 7500,
                "ban motor": 700
            };

            function hitungTotal(row) {
                const jenis = row.querySelector('select[name="jenis_sampah[]"]').value;
                const jumlah = parseFloat(row.querySelector('input[name="jumlah[]"]').value) || 0;
                const harga = hargaSampah[jenis] || 0;
                row.querySelector('input[name="total_penjualan[]"]').value = jumlah * harga;
            }

            document.addEventListener('input', function(e) {
                if (
                    e.target.matches('select[name="jenis_sampah[]"]') ||
                    e.target.matches('input[name="jumlah[]"]')
                ) {
                    const row = e.target.closest('tr');
                    hitungTotal(row);
                }
            });

            document.getElementById('addRow').addEventListener('click', function() {
                const tableBody = document.querySelector('#sampahTable tbody');
                const newRow = tableBody.rows[0].cloneNode(true);
                newRow.querySelectorAll('input').forEach(input => input.value = '');
                newRow.querySelector('select').selectedIndex = 0;
                tableBody.appendChild(newRow);
            });

            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    const rows = document.querySelectorAll('#sampahTable tbody tr');
                    if (rows.length > 1) row.remove();
                }
            });
        </script>
    @endsection
</x-app-layout>
