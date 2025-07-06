<x-app-layout>
    @section('content')

    <h1 class="mb-5 text-gray-800">Ranking Setoran</h1>
    <!-- Pesan sukses -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="chart-container">
        <canvas id="pieChart" width="200" height="200"></canvas>
    </div>


    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('setorans.create') }}" class="btn btn-primary mt-3 rounded rounded-4"><i
                class="bi bi-plus-square"></i> Tambah Setoran</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Ranking</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($setorans as $setoran)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $setoran->nama }}</td>
                                <td>{{ $setoran->jumlah ?? '-' }}</td>
                                <td class="text-center">
                                    <!-- Tombol Show -->
                                    <a href="{{ route('setorans.edit', $setoran->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <!-- Tombol Delete -->
                                    <form action="{{ route('setorans.destroy', $setoran->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
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