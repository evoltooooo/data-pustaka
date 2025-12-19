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
                        Panduan Peminjaman
                    </h1>

                    <img src="{{ asset('images/modernlibrary1.jpg') }}" alt="Layanan Koleksi Khusus" class="layanan-image">

                    <span class="layanan-isi">
                        <ul>
                            Langkah-langkah Meminjam Buku:
                            
                            <li>Pilih buku yang ingin Anda pinjam.</li>
                            <img src="{{ asset('images/panduan1.png') }}" alt="Layanan Koleksi Khusus" class="layanan-image">
                            <li>Masuk ke halaman <b>Peminjaman</b>. </li>
                            <img src="{{ asset('images/panduan2.png') }}" alt="Layanan Koleksi Khusus" class="layanan-image">
                            <li>Masukkan tanggal peminjaman yang diinginkan.</li>
                            <img src="{{ asset('images/panduan3.png') }}" alt="Layanan Koleksi Khusus" class="layanan-image">
                            <li>Tanggal pengembalian akan terisi otomatis, yaitu dua minggu setelah tanggal peminjaman.</li>
                            <li>Klik tombol "Konfirmasi Peminjaman" untuk menyelesaikan proses.</li>
                            <li>Ambil buku di resepsionis perpustakaan “Data Pustaka” pada hari peminjaman.</li>
                        </ul>
                    </span>

                </div>
            </div>

        </div>
    </section>
@endsection
