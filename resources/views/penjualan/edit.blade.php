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
                                <th>Jumlah (Per KG)</th>
                                <th>Total Penjualan (Rupiah)</th>
                                <th>
                                    <button type="button" class="btn btn-sm btn-success" id="addRow">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan->details as $detail)
                                <tr>
                                    <td>
                                        <select name="jenis_sampah[]" class="form-control" required>
                                            <option value="" disabled>-- Pilih Jenis --</option>
                                            @foreach ($jenisSampahList as $jenis)
                                                <option value="{{ $jenis->id }}" data-harga="{{ $jenis->harga_per_kg }}"
                                                    {{ $detail->jenis_sampah_id == $jenis->id ? 'selected' : '' }}>
                                                    {{ $jenis->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control jumlah-format"
                                            value="{{ number_format($detail->jumlah, 0, ',', '.') }}" required>
                                        <input type="hidden" name="jumlah[]" class="jumlah-hidden"
                                            value="{{ $detail->jumlah }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control total-format"
                                            value="Rp{{ number_format($detail->total_penjualan, 0, ',', '.') }}" readonly>
                                        <input type="hidden" name="total_penjualan[]" class="total-hidden"
                                            value="{{ $detail->total_penjualan }}">
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger removeRow">x</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <label>Total Keseluruhan:</label>
                        <input type="text" id="totalKeseluruhan" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary mt-3">Batal</a>
                </form>
            </div>
        </div>

        <script>
            const hargaSampahMap = {};
            document.querySelectorAll('select[name="jenis_sampah[]"] option').forEach(opt => {
                if (opt.value) {
                    hargaSampahMap[opt.value] = parseFloat(opt.getAttribute('data-harga')) || 0;
                }
            });

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);
            }

            function parseRupiah(str) {
                return parseInt((str || '').toString().replace(/[^0-9]/g, '')) || 0;
            }

            function hitungTotal(row) {
                const jenisSelect = row.querySelector('select[name="jenis_sampah[]"]');
                const jumlahInput = row.querySelector('.jumlah-format');
                const jumlahHidden = row.querySelector('.jumlah-hidden');
                const totalFormat = row.querySelector('.total-format');
                const totalHidden = row.querySelector('.total-hidden');

                const jenisId = jenisSelect?.value;
                const harga = hargaSampahMap[jenisId] || 0;

                const jumlah = parseRupiah(jumlahInput.value);
                const total = jumlah * harga;

                jumlahHidden.value = jumlah;
                totalHidden.value = total;
                totalFormat.value = formatRupiah(total);
            }

            function updateTotalKeseluruhan() {
                let totalKeseluruhan = 0;
                document.querySelectorAll('.total-hidden').forEach(input => {
                    totalKeseluruhan += parseInt(input.value) || 0;
                });

                const totalField = document.getElementById('totalKeseluruhan');
                if (totalField) {
                    totalField.value = formatRupiah(totalKeseluruhan);
                }
            }

            document.addEventListener('input', function(e) {
                if (
                    e.target.matches('select[name="jenis_sampah[]"]') ||
                    e.target.matches('.jumlah-format')
                ) {
                    const row = e.target.closest('tr');
                    if (row) {
                        hitungTotal(row);
                        updateTotalKeseluruhan();
                    }
                }
            });

            document.getElementById('addRow').addEventListener('click', function() {
                const tableBody = document.querySelector('#sampahTable tbody');
                const newRow = tableBody.rows[0].cloneNode(true);

                // reset values
                newRow.querySelectorAll('input').forEach(input => {
                    input.value = '';
                });

                const select = newRow.querySelector('select');
                if (select) select.selectedIndex = 0;

                tableBody.appendChild(newRow);
            });

            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    const rows = document.querySelectorAll('#sampahTable tbody tr');
                    if (rows.length > 1) row.remove();
                    updateTotalKeseluruhan();
                }
            });

            window.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('#sampahTable tbody tr').forEach(row => {
                    hitungTotal(row);
                });
                updateTotalKeseluruhan();
            });
        </script>
    @endsection
</x-app-layout>
