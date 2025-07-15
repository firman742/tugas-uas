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
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                                required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_tengkulak">Nama Tengkulak</label>
                            <input type="text" name="nama_tengkulak"
                                class="form-control @error('nama_tengkulak') is-invalid @enderror" required>
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
                                    <th>Jumlah (Per KG)</th>
                                    <th>Total Penjualan (Rupiah)</th>
                                    <th>
                                        <button type="button" class="btn btn-sm btn-success" id="addRow">+</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="jenis_sampah[]" class="form-control jenis-sampah" required>
                                            <option value="" disabled selected>-- Pilih Jenis Sampah --</option>
                                            @foreach ($jenisSampahList as $jenis)
                                                <option value="{{ $jenis->id }}" data-harga="{{ $jenis->harga_per_kg }}">
                                                    {{ $jenis->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control jumlah-format" required>
                                        <input type="hidden" name="jumlah[]" class="jumlah-hidden">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control total-format" readonly>
                                        <input type="hidden" name="total_penjualan[]" class="total-hidden">
                                    </td>

                                    <td><button type="button" class="btn btn-sm btn-danger removeRow">x</button></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <label>Total Keseluruhan:</label>
                            <input type="text" id="totalKeseluruhan" class="form-control" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </form>
                </div>
            </div>
            <script>
                function formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(angka);
                }

                function parseRupiah(str) {
                    return parseInt(str.replace(/[^0-9]/g, '')) || 0;
                }

                function hitungTotal(row) {
                    const selected = row.querySelector('select[name="jenis_sampah[]"]').selectedOptions[0];
                    const jumlahInput = row.querySelector('.jumlah-format');
                    const jumlahHidden = row.querySelector('.jumlah-hidden');

                    const jumlah = parseRupiah(jumlahInput.value);
                    jumlahHidden.value = jumlah;

                    const harga = parseFloat(selected?.getAttribute('data-harga')) || 0;
                    const total = jumlah * harga;

                    row.querySelector('.total-format').value = formatRupiah(total);
                    row.querySelector('.total-hidden').value = total;
                }

                function updateTotalKeseluruhan() {
                    let total = 0;
                    document.querySelectorAll('.total-hidden').forEach(input => {
                        total += parseInt(input.value) || 0;
                    });
                    document.getElementById('totalKeseluruhan').value = formatRupiah(total);
                }

                document.addEventListener('input', function(e) {
                    if (
                        e.target.matches('select[name="jenis_sampah[]"]') ||
                        e.target.matches('.jumlah-format')
                    ) {
                        const row = e.target.closest('tr');
                        hitungTotal(row);
                        updateTotalKeseluruhan();
                    }
                });

                // Format on blur (optional)
            //     document.addEventListener('blur', function(e) {
            //         if (e.target.matches('.jumlah-format')) {
            //             const val = parseRupiah(e.target.value);
            //             e.target.value = val > 0 ? formatRupiah(val) : '';
            //         }
            //     }, true);
            // </script>

        </div>

        <script>
            document.getElementById('addRow').addEventListener('click', function() {
                const tableBody = document.querySelector('#sampahTable tbody');
                const newRow = tableBody.rows[0].cloneNode(true);

                // Reset inputs
                newRow.querySelectorAll('input').forEach(input => {
                    input.value = '';
                });

                // Optional: reset selected option
                const select = newRow.querySelector('select');
                if (select) select.selectedIndex = 0;

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
