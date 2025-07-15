<x-app-layout>
    @section('content')

    <h1 class="mb-5 text-gray-800">Ranking Setoran</h1>
    <div class="row mb-4">
        <div class="col-md-6">
            <h5 class="text-center">Total Setoran per Jenis Sampah</h5>
            <canvas id="jenisChart" width="200" height="200"></canvas>
        </div>
        <div class="col-md-6">
            <h5 class="text-center">Ranking Nasabah Berdasarkan Total Setoran</h5>
            <canvas id="nasabahChart" width="200" height="200"></canvas>
        </div>
    </div>
    
    <script>
        // Chart 1: Pie chart per jenis sampah
        const jenisCtx = document.getElementById('jenisChart').getContext('2d');
        new Chart(jenisCtx, {
            type: 'pie',
            data: {
                labels: @json($labelsJenis),
                datasets: [{
                    data: @json($valuesJenis),
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
                plugins: {
                    title: {
                        display: true,
                        text: 'Perbandingan Total Setoran per Jenis Sampah'
                    }
                }
            }
        });
    
        // Chart 2: Bar chart per nasabah
        const nasabahCtx = document.getElementById('nasabahChart').getContext('2d');
        new Chart(nasabahCtx, {
            type: 'bar',
            data: {
                labels: @json($labelsNasabah),
                datasets: [{
                    label: 'Total Setoran (Rp)',
                    data: @json($valuesNasabah),
                    backgroundColor: '#3b82f6',
                    borderColor: '#1e40af',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Ranking Nasabah Berdasarkan Total Setoran'
                    }
                }
            }
        });
    </script>
    
    @endsection
</x-app-layout>