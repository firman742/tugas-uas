<x-app-layout>
    @section('content')
        <div class="container mt-4">
            <h1>Selamat Datang, {{ auth()->user()->name }}</h1>

            <a href="" class="btn btn-primary">
                Lihat Laporan Harian & Bulanan 
                Awang NUB
            </a>
        </div>
    @endsection
</x-app-layout>
