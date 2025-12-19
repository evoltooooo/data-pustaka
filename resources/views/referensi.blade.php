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
                        Layanan Referensi
                    </h1>

                    <img src="{{ asset('images/modernlibrary.jpeg') }}" alt="Layanan Koleksi Khusus" class="layanan-image">

                    <span class="layanan-isi">
                        Layanan Referensi di Perpustakaan ini dirancang untuk membantu pemustaka
                        dalam menemukan sumber informasi yang beragam serta mendalam dalam mendukung implementasi
                        pelaksanaan program Tri Dharma Perguruan Tinggi.
                    </span>

                </div>
            </div>

        </div>
    </section>
@endsection
