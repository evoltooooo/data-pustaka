@extends ('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/layanan.css') }}">
@endpush

@section('content')
    <section class="content">
        <div class="container-fluid">
            <h2 class="layanan-title layanan-title-header" style="text-align: center;">Layanan</h2>
            <div class="card layanan-card">
                <div class="card-body">

                    <h1 class="layanan-title">
                        Peraturan Perpustakaan
                    </h1>

                    <img src="{{ asset('images/modernlibrary.jpeg') }}" alt="Layanan Koleksi Khusus" class="layanan-image">

                    <span class="layanan-isi">
                        <ul>
                            <li>Dilarang meminjam buku melewati jatuh tempo.</li>
                            <li>Dilarang meminjam buku lebih dari 2 buku.</li>
                        </ul>
                    </span>
                </div>
            </div>

        </div>
    </section>
@endsection
