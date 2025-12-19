@extends ('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">

<style>
    .book-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .book-card-link:hover .book-card-collection {
        transform: scale(1.03);
        transition: 0.2s;
    }
</style>
@endpush

@section('content')

    <div class="content">
        <div class="jumbotron text-center">
            <h1 class="display-4">Selamat Datang</h1>
            <p class="lead">Akses ribuan buku dimana saja dan kapan saja</p>
            <hr class="my-4">

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">

                            <div class="search-wrapper">
                                <form id="searchForm" action="{{ route('search.do') }}" method="GET">
                                    <div class="mx-auto position-relative" style="max-width: 500px;">
                                        <div class="input-group" id="search-wrapper">
                                            <input type="text" id="searchInput" name="q" class="form-control"
                                                placeholder="Cari judul buku...">

                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="searchSuggest" class="list-group"
                                            style="z-index: 1050; max-height: 150px; overflow-y:auto;">
                                        </div>

                                        <div id="searchHistory" class="list-group"
                                            style="z-index: 1049; max-height: 250px; overflow-y:auto;">
                                        </div>
                                    </div>

                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

{{-- ==================== KATEGORI ==================== --}}

@include('layouts.partials.home-kategori')

{{-- ====================== POPULER ====================== --}}
<div class="container my-5 text-center section-spacing">
    <h3 class="fw-bold mb-2">Yang populer di antara koleksi kami</h3>
    <p class="text-muted mb-4">
        Koleksi-koleksi kami yang dibaca oleh banyak pengunjung perpustakaan.
    </p>

        <div class="container my-4">
            <div class="row justify-content-center text-center g-3">

            @foreach($populer as $b)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">

                <a href="{{ route('detail', $b->idBuku) }}" class="book-card-link">
                    <div class="book-card-collection">
                        <div class="cover-wrapper">
                            <img src="{{ url('uploads/cover/thumbnail/thumb_' . $b->cover . '.webp') }}"
                                 alt="{{ $b->judul }}">
                        </div>

                        <div class="info">
                            <h6 class="title line-clamp-2">{{ $b->judul }}</h6>
                            <p class="author">{{ $b->penulis ?? '' }}</p>

                            <div class="rating">
                                <i class="fa fa-star text-warning"></i>
                                <span>{{ number_format($b->ratings_avg_rating ?? 0, 1) }}</span>
                            </div>

                        </div>
                    </div>
                </a>

            </div>
            @endforeach

        </div>
    </div>
</div>

{{-- ====================== BARU ====================== --}}
<div class="container my-5 text-center section-spacing">
    <h3 class="fw-bold mb-2">Koleksi terbaru</h3>
    <p class="text-muted mb-4">
        Koleksi kami yang terakhir ditambahkan.
    </p>

    <div class="container my-4">
        <div class="row justify-content-center text-center g-3">

            @foreach($baru as $b)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">

                <a href="{{ route('detail', $b->idBuku) }}" class="book-card-link">
                    <div class="book-card-collection">
                        <div class="cover-wrapper">
                            <img src="{{ url('uploads/cover/thumbnail/thumb_' . $b->cover . '.webp') }}"
                                 alt="{{ $b->judul }}">
                        </div>

                        <div class="info">
                            <h6 class="title line-clamp-2">{{ $b->judul }}</h6>
                            <p class="author">{{ $b->penulis ?? '-' }}</p>

                            <div class="rating">
                                <i class="fa-solid fa-star text-warning"></i>
                                <span>{{ number_format($b->ratings_avg_rating ?? 0, 1) }}</span>
                            </div>

                        </div>
                    </div>
                </a>

            </div>
            @endforeach

        </div>
    </div>
</div>


@endsection
