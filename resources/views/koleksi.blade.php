@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/searchbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/koleksi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endpush

@section('title', 'Koleksi Buku')

@section('content')

    {{-- ==================== HERO ==================== --}}
    <div class="content">
        <div class="jumbotron text-center">
            <h1 class="display-4">Temukan Buku Favoritmu</h1>
            <p class="lead">Telusuri koleksi kami dan temukan bacaan baru yang menarik</p>
            <hr class="my-4">

            {{-- SEARCH BAR --}}
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

    {{-- ==================== MAIN WRAPPER ==================== --}}
    <div class="koleksi-wrapper" style="padding-bottom:120px;">
        <div class="koleksi-layout">

            {{-- ==================== SIDEBAR ==================== --}}
            <div class="sidebar-filter">
                <h2>Filter</h2>

                @php
                $selectedKategori = $selectedKategori ?? [];
            @endphp

            {{-- ==================== KATEGORI (ditambah wrapper) ==================== --}}
            <div class="filter-section">
                <label>Kategori</label>

                @foreach($listKategori as $kat)

                @php
                    // Normalisasi request jadi lowercase
                    $reqKategori = collect((array) request()->get('kategori'))
                        ->map(fn($v) => strtolower(trim($v)));

                    $katNormalized = strtolower(trim($kat));
                @endphp

                <div class="form-check">
                    <input 
                        class="form-check-input"
                        type="checkbox"
                        name="kategori[]"
                        value="{{ $kat }}"
                        {{ $reqKategori->contains($katNormalized) ? 'checked' : '' }}>

                    <label class="form-check-label">
                        {{ $kat }}
                    </label>
                </div>

                @endforeach
            </div>
            {{-- ==================== END KATEGORI ==================== --}}

                {{-- Genre --}}
                <div class="filter-section">
                    <label>Genre</label>
                    @foreach ($listGenre as $g)
                        <label>
                            <input type="checkbox" name="genre[]" value="{{ $g }}">
                            {{ $g }}
                        </label>
                    @endforeach
                </div>

                {{-- Bahasa --}}
                <div class="filter-section">
                    <label>Bahasa</label>

                    @php
                        $primaryLangs = [
                            'id' => 'Indonesian',
                            'en' => 'English',
                        ];
                    @endphp

                    {{-- Dua bahasa utama --}}
                    @foreach ($primaryLangs as $code => $lang)
                        <label>
                            <input type="checkbox" name="bahasa[]" value="{{ $code }}">
                            {{ $lang }}
                        </label>
                    @endforeach

                    {{-- Bahasa lain --}}
                    <div class="more-bahasa" style="display:none;">
                        @foreach ($allLanguages as $code => $lang)
                            @if (!array_key_exists($code, $primaryLangs))
                                <label>
                                    <input type="checkbox" name="bahasa[]" value="{{ $code }}">
                                    {{ $lang }}
                                </label>
                            @endif
                        @endforeach
                    </div>

                    <button type="button" class="toggle-bahasa">Lebih Banyak</button>
                </div>

                {{-- Tahun --}}
                <div class="filter-section">
                    <label>Tahun</label>

                    <label>
                        <input type="radio" name="filter_tahun" value="all" checked>
                        Semua Tahun
                    </label>

                    <label>
                        <input type="radio" name="filter_tahun" value="3">
                        3 tahun terakhir
                    </label>

                    <label>
                        <input type="radio" name="filter_tahun" value="5">
                        5 tahun terakhir
                    </label>

                    <label>
                        <input type="radio" name="filter_tahun" value=">5">
                        Lebih dari 5 tahun
                    </label>
                </div>

            </div>

            {{-- ==================== MAIN CONTENT ==================== --}}
            <div class="koleksi-page">

                {{-- TOPBAR --}}
                <div class="koleksi-topbar">

                    {{-- KIRI: Info hasil pencarian --}}
                    <div class="search-info">
                        @if (!empty($q))
                            <p class="mb-0">
                                Ditemukan <strong>{{ $totalHasil }}</strong> dari pencarian anda
                                melalui kata kunci:
                                <span class="text-danger font-weight-bold">{{ $q }}</span>
                            </p>
                        @endif
                    </div>

                    {{-- KANAN: Sort By + Toggle Grid --}}
                    <div class="topbar-actions">

                        <div class="sort-dropdown">
                            <button class="sort-btn" id="sortBtn">
                                <span id="sortLabel">Sort By</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>

                            <div class="sort-panel" id="sortPanel">
                                <div class="sort-item" data-sort="az" data-label="Judul A → Z">Judul A → Z</div>
                                <div class="sort-item" data-sort="za" data-label="Judul Z → A">Judul Z → A</div>
                                <div class="sort-item" data-sort="newest" data-label="Terbaru">Terbaru</div>
                                <div class="sort-item" data-sort="oldest" data-label="Terlama">Terlama</div>
                                <div class="sort-item" data-sort="rating" data-label="Rating Tertinggi">Rating Tertinggi
                                </div>
                            </div>
                        </div>

                        <button id="gridListToggle">
                            <i class="fa fa-th-large"></i>
                        </button>

                    </div>

                </div>

                {{-- HASIL ITEM --}}
                <div id="koleksi-container" class="koleksi-container grid-view">
                    @include('layouts.partials.koleksi_items', [
                        'buku' => $buku,
                    ])
                </div>

                {{-- PAGINATION --}}
                <div class="pagination-wrapper">
                    <button id="prevPage">Prev</button>
                    <span id="pageInfo">1/1</span>
                    <button id="nextPage">Next</button>
                </div>

            </div>

        </div>
    </div>

    {{-- ==================== SCRIPTS ==================== --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {

    /* SEARCH */
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


    /* HELPERS */
    function getChecked(name) {
        return [...document.querySelectorAll(`input[name="${name}[]"]:checked`)]
            .map(i => i.value);
    }
    function getRadio(name) {
        const r = document.querySelector(`input[name="${name}"]:checked`);
        return r ? r.value : null;
    }


    /* GRID / LIST */
    function initGridListToggle() {
        const container = document.getElementById("koleksi-container");
        const btn = document.getElementById("gridListToggle");

        btn.onclick = () => {
            container.classList.toggle("grid-view");
            container.classList.toggle("list-view");

            btn.querySelector("i").className =
                container.classList.contains("list-view")
                ? "fa fa-bars"
                : "fa fa-th-large";
        };
    }


    /* AJAX FILTER & SORT */
    function sendFilter(sortType = null) {
        let params = new URLSearchParams();

        getChecked("kategori").forEach(v => params.append("kategori[]", v));
        getChecked("genre").forEach(v => params.append("genre[]", v));
        getChecked("bahasa").forEach(v => params.append("bahasa[]", v));

        let tahun = getRadio("filter_tahun");
        if (tahun) params.append("filter_tahun", tahun);

        if (sortType) params.append("sort", sortType);

        fetch(`{{ route('koleksi.filter') }}?${params.toString()}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById("koleksi-container").innerHTML = html;
                initPagination();
                initGridListToggle();
            });
    }


    document.querySelectorAll("input[type='checkbox'], input[name='filter_tahun']")
        .forEach(el => el.addEventListener("change", () => sendFilter()));


    /* SORT */
    const sortBtn = document.getElementById("sortBtn");
    const sortPanel = document.getElementById("sortPanel");
    const sortLabel = document.getElementById("sortLabel");

    sortBtn.onclick = () => sortPanel.classList.toggle("active");

    document.addEventListener("click", e => {
        if (!sortPanel.contains(e.target) && !sortBtn.contains(e.target))
            sortPanel.classList.remove("active");
    });

    document.querySelectorAll(".sort-item").forEach(item => {
        item.addEventListener("click", () => {
            sortLabel.textContent = item.dataset.label;
            sendFilter(item.dataset.sort);
        });
    });



    /* PAGINATION */
    function initPagination() {
        const cont = document.getElementById("koleksi-container");
        const items = [...cont.querySelectorAll(".koleksi-item-link")];

        const prev = document.getElementById("prevPage");
        const next = document.getElementById("nextPage");
        const info = document.getElementById("pageInfo");

        if (!prev || !next || !info) return;

        let perPage = 20;
        let page = 1;
        let total = Math.max(1, Math.ceil(items.length / perPage));

        function show(p) {
            let start = (p - 1) * perPage;
            let end = start + perPage;

            items.forEach((el, i) => {
                el.style.display = (i >= start && i < end) ? "" : "none";
            });

            info.textContent = `${p}/${total}`;
            prev.disabled = (p === 1);
            next.disabled = (p === total);
        }

        prev.onclick = () => { if (page > 1) show(--page); };
        next.onclick = () => { if (page < total) show(++page); };

        show(1);
    }


    /* BAHASA TOGGLE */
    document.querySelector('.toggle-bahasa').onclick = function() {
        const box = document.querySelector('.more-bahasa');
        const show = box.style.display === "none" || box.style.display === "";
        box.style.display = show ? "block" : "none";
        this.textContent = show ? "Lebih Sedikit" : "Lebih Banyak";
    };


    /* INIT */
    initGridListToggle();
    initPagination();

});
</script>


@endpush

@endsection
