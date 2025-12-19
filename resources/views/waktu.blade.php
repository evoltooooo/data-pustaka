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
                        Waktu Layanan
                    </h1>

                    <img src="{{ asset('images/modernlibrary.jpeg') }}" alt="Layanan Koleksi Khusus" class="layanan-image">

                    <span class="layanan-isi">
                        Senin - Jumat: 08.00 - 22.00 WIB <br>
                        Sabtu : 09.00 - 18.00 WIB <br>
                        Minggu : 09.00 - 15.00 WIB
                    </span>

                </div>
            </div>

        </div>
    </section>
@endsection
