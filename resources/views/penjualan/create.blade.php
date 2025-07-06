<x-app-layout>
    @section('content')
        <div class="container mt-4">
            <h1 class="mb-4 text-gray-800">Tambah Penjualan Sampah</h1>

            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_tengkulak">Nama Tengkulak</label>
                            <input type="text" name="nama_tengkulak" class="form-control @error('nama_tengkulak') is-invalid @enderror" required>
                            @error('nama_tengkulak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bukti">Bukti</label>
                            <input type="file" name="bukti" class="form-control @error('bukti') is-invalid @enderror">
                            @error('bukti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                <tr>
                                    <td>
                                        <select name="jenis_sampah[]" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih Jenis Sampah --</option>
                                            <option value="kardus">Kardus</option>
                                            <option value="botol">Botol</option>
                                            <option value="logam">Logam</option>
                                            <option value="kertas hvs">Kertas HVS</option>
                                            <option value="kertas duplex">Kertas Duplex</option>
                                            <option value="tembaga">Tembaga</option>
                                            <option value="ban motor">Ban Motor</option>
                                        </select>
                                    </td>
                                    <td><input type="number" name="jumlah[]" class="form-control" required></td>
                                    <td><input type="number" name="total_penjualan[]" class="form-control" readonly></td>
                                    <td><button type="button" class="btn btn-sm btn-danger removeRow">x</button></td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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

                //otomatis hitung
                function hitungTotal(row) {
                    const jenis = row.querySelector('select[name="jenis_sampah[]"]').value;
                    const jumlah = parseFloat(row.querySelector('input[name="jumlah[]"]').value) || 0;
                    const harga = hargaSampah[jenis] || 0;
                    const total = jumlah * harga;
                    row.querySelector('input[name="total_penjualan[]"]').value = total;
                }

                //trigger otomatis saat pilih jenis atau jumlah
                document.addEventListener('input', function(e) {
                    if (
                        e.target.matches('select[name="jenis_sampah[]"]') ||
                        e.target.matches('input[name="jumlah[]"]')
                    ) {
                        const row = e.target.closest('tr');
                        hitungTotal(row);
                    }
                });
            </script>
        </div>

        <script>
            document.getElementById('addRow').addEventListener('click', function() {
                const tableBody = document.querySelector('#sampahTable tbody');
                const newRow = tableBody.rows[0].cloneNode(true);
                newRow.querySelectorAll('input').forEach(input => input.value = '');
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
