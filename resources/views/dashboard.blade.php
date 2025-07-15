<x-app-layout>
    @section('content')
        <div class="container mt-4">
            <h1>Selamat Datang Di Bank Sampah, {{ auth()->user()->name }}</h1>

            <a href="" class="btn btn-primary">
                Lihat Selengapnya
            </a>
        </div>
    @endsection
</x-app-layout>
