@extends ('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endpush

@section('content')
    <!-- Top -->
    <!-- JUMBOTRON / HERO BANNER -->
    @php
        $base = $buku->cover;
        $exts = ['webp', 'jpg', 'jpeg', 'png'];

        $coverFile = null;

        foreach ($exts as $ext) {
            $path = public_path("uploads/cover/{$base}.{$ext}");
            if (file_exists($path)) {
                $coverFile = asset("uploads/cover/{$base}.{$ext}");
                break;
            }
        }
        if (!$coverFile) {
            $coverFile = asset('img/hero-default.jpg');
        }
    @endphp

    <div class="jumbotron jumbotron-fluid mb-4 text-white book-hero"
        style="
        background-image: linear-gradient(
            rgba(0,0,0,0.55), 
            rgba(0,0,0,0.55)
        ),
        url('{{ $coverFile }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;">

        <div class="container">
            <div class="container mt-7 pt-4">
                <h4 class="mt-5 mb-3">Search</h4>

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

    <div class="container py-4 mt-2">

        <div class="bg-white p-4 shadow-sm rounded">

            <div class="row">

                <div class="col-md-3 mb-4 text-center">

                    <div class="book-cover-wrapper mb-3">
                        <img src="{{ url('uploads/cover/thumbnail/thumb_' . $buku->cover . '.webp') }}" alt="Cover Buku"
                            class="img-fluid shadow-sm book-cover-img">
                    </div>

                    <div class="d-flex justify-content-center">
                        <button class="btn btn-pinjam btn-success d-flex align-items-center">
                            Pinjam Sekarang
                        </button>
                    </div>

                    <div class="mt-2 text-muted">
                        <small>Average rating: <span id="average-rating">{{ number_format($averageRating, 1) }}</span> /
                            5</small>
                    </div>

                    <div id="star-rating" data-current-rating="{{ $userRating->rating ?? 0 }}">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star star" data-value="{{ $i }}"></i>
                        @endfor
                    </div>

                    <div class="mt-2 text-muted">
                        <small>Your rating: <span id="rating-value">{{ $userRating->rating ?? 'None' }}</span></small>
                    </div>
                </div>

                <div class="col-md-9">

                    <div class="mb-3">
                        <span class="badge badge-success px-2 py-1 mr-2">Text</span>
                        <span class="text-muted small">Koleksi</span>
                    </div>

                    <h4 class="mb-1 font-weight-bold">
                        {{ $buku->judul }}
                    </h4>

                    <div class="mb-2">
                        <a href="#" class="text-primary">
                            {{ $buku->penulis }}
                        </a>
                    </div>

                    <div class="text-muted mb-3">
                        {{ $buku->deskripsi }}
                    </div>

                    <hr>

                    <h6 class="font-weight-bold mb-3">Ketersediaan</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Ketersediaan</th>
                                    <th scope="col" style="width: 120px;">No. Panggil</th>
                                    <th scope="col" style="width: 120px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eksemplar as $r)
                                    <tr>
                                        <td>{{ $r->judul }}</td>
                                        <td>{{ $r->no_panggil }}</td>
                                        <td>
                                            @if ($r->stok == 1)
                                                <span class="badge badge-success">Tersedia</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h6 class="font-weight-bold mb-3">Informasi Detail</h6>

                    <div class="row mb-4 book-info-detail">

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">Judul</div>
                        <div class="col-md-8 col-6 mb-2">{{ $buku->judul }}</div>

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">No. Panggil</div>
                        <div class="col-md-8 col-6 mb-2">{{ $buku->no_panggil }}</div>

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">Penulis</div>
                        <div class="col-md-8 col-6 mb-2">{{ $buku->penulis }}</div>

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">Penerbit</div>
                        <div class="col-md-8 col-6 mb-2">{{ $buku->penerbit }}, {{ $ngr }}</div>

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">Deskripsi Fisik</div>
                        <div class="col-md-8 col-6 mb-2">{{ $buku->halaman }} Hlm.</div>

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">Bahasa</div>
                        <div class="col-md-8 col-6 mb-2">{{ $bhs }}</div>

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">ISBN/ISSN</div>
                        <div class="col-md-8 col-6 mb-2">{{ $buku->issn }}</div>

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">Jenis</div>
                        <div class="col-md-8 col-6 mb-2">{{ $buku->jenis }}</div>

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">Volume</div>
                        <div class="col-md-8 col-6 mb-2">{{ $buku->volume }}</div>

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">Tahun Terbit</div>
                        <div class="col-md-8 col-6 mb-2">{{ $buku->tahun_terbit }}</div>

                        <div class="font-weight-bold col-md-4 col-6 mb-2 text-muted">Genre</div>
                        <div class="col-md-8 col-6 mb-2">
                            <a href="#" class="text-primary">{{ $buku->genre }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="pinjamModal" tabindex="-1" aria-labelledby="pinjamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="pinjamModalLabel">Ketersediaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Ketersediaan</th>
                                <th scope="col" style="width: 120px;">No. Panggil</th>
                                <th scope="col" style="width: 120px;">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eksemplar as $r)
                                @php
                                    $cek_keranjang = in_array($r->idBuku, $keranjangItem);
                                @endphp
                                <tr>
                                    <td>{{ $r->judul }}</td>
                                    <td>{{ $r->no_panggil }}</td>
                                    <td>
                                        @if ($r->stok == 1)
                                            <span class="badge badge-success">Tersedia</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a>
                                            @if ($r->stok == 0)
                                                <button
                                                    class="btn btn-secondary d-flex justify-content-center align-items-center disabled">Pinjam</button>
                                            @elseif($cek_keranjang)
                                                <button
                                                    class="btn btn-secondary d-flex justify-content-center align-items-center disabled">Pinjam</button>
                                                <small>(Buku sudah ada di daftar peminjaman.)</small>
                                            @else
                                                <button
                                                    class="btn btn-ask btn-success d-flex justify-content-center align-items-center"
                                                    data-id="{{ $r->id }}"
                                                    data-judul="{{ $r->judul }}"data-cover="{{ $r->cover }}"
                                                    data-idbuku="{{ $r->idBuku }}">
                                                    Pinjam
                                                </button>
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="konfirmModal" tabindex="1" aria-labelledby="konfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="pinjamModalLabel">Konfirmasi Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="book-cover-wrapper mb-3">
                        <img src="" id="konfirmModal-cover" alt="Cover Buku"
                            class="img-fluid shadow-sm book-cover-img">
                    </div>
                    Apakah Anda yakin ingin meminjam buku:
                    <br><strong id="konfirmModal-judul"></strong>?
                </div>

                <div class="modal-footer">
                    <form action="{{ route('detail.add') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="idBuku" id="konfirmModal-idbuku">
                        <button type="submit" class="btn btn-success btn-confirm">Ya</button>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            let current = $("#star-rating").data("current-rating");

            function highlightStars(rating) {
                $(".star").each(function() {
                    let value = $(this).data("value");
                    $(this).toggleClass("selected", value <= rating);
                });
            }

            highlightStars(current);

            // Hover effect
            $(".star").hover(
                function() {
                    highlightStars($(this).data("value"));
                },
                function() {
                    highlightStars(current);
                }
            );

            $(".star").click(function() {
                let rating = $(this).data("value");

                $.ajax({
                    url: "{{ route('rating', $buku->idBuku) }}",
                    method: "POST",
                    data: {
                        rating: rating,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $("#rating-value").text(data.rating);
                        $("#average-rating").text(parseFloat(data.average).toFixed(1));

                        current = data.rating;
                        highlightStars(current);
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            alert("You must be logged in to rate.");
                        } else {
                            console.error(xhr.responseText);
                        }
                    }
                });
            });

            $(".btn-pinjam").click(function() {
                $("#pinjamModal").modal("show");
            });

            $(".btn-ask").click(function() {
                let judul = $(this).data("judul");
                let cover = $(this).data("cover");
                let idbuku = $(this).data("idbuku");

                $("#konfirmModal-judul").text(judul);
                $("#konfirmModal-cover").attr("src", "{{ url('uploads/cover/thumbnail') }}/thumb_" +
                    cover + ".webp");
                $("#konfirmModal-idbuku").val(idbuku);

                $("#konfirmModal").modal("show");
            });
        });
    </script>
    <script>
        window.searchConfig = {
            suggestUrl: "{{ route('search.suggest') }}",
            historyUrl: "{{ route('search.history') }}",
            historyClearUrl: "{{ route('search.history.clear') }}",
            historyDeleteBaseUrl: "{{ url('/search/history') }}",
            csrfToken: "{{ csrf_token() }}",
            detailBaseUrl: "{{ url('koleksi/detail') }}/"
        };
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const input = document.getElementById("searchInput");
            const panel = document.getElementById("searchPanel");
            const dropdown = document.getElementById("searchDropdown");

            if (input && panel) {
                const items = [...dropdown.querySelectorAll("li")];

                input.addEventListener("focus", () => panel.classList.add("show"));

                document.addEventListener("click", e => {
                    if (!panel.contains(e.target) && !input.contains(e.target))
                        panel.classList.remove("show");
                });

                input.addEventListener("input", () => {
                    const q = input.value.toLowerCase();
                    items.forEach(i => {
                        i.style.display = i.textContent.toLowerCase().includes(q) ? "block" : "none";
                    });
                    panel.classList.toggle("show", q.length > 0);
                });
            }
        });
    </script>

    <script src="{{ asset('js/search-demo.js') }}"></script>
@endsection
