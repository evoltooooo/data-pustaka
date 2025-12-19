<div class="search-result-info">
    Ditemukan <strong>{{ $jumlah }}</strong> hasil pencarian
</div>

<div class="koleksi-container {{ $mode }}-view">
    @foreach($buku as $b)
        @include('layouts.partials.koleksi_items_single', ['b' => $b])
    @endforeach
</div>
