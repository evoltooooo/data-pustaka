{{-- =====================
     LIST DATA BUKU
====================== --}}
@foreach ($buku as $b)

<a href="{{ route('detail', $b->idBuku) }}" 
   class="koleksi-item-link"
   style="text-decoration:none;color:inherit;">

    <div class="koleksi-item">

        {{-- COVER --}}
        <img src="{{ url('uploads/cover/thumbnail/thumb_' . $b->cover . '.webp') }}"
             alt="{{ $b->judul }}">

        {{-- INFO WRAPPER --}}
        <div class="koleksi-info">

            {{-- JUDUL --}}
            <h3 class="judul">{{ $b->judul }}</h3>

            <td>{{ $b->penulis ?: '-' }}</td>



            {{-- DESKRIPSI --}}
            <p class="deskripsi mt-3">
                {{ $b->deskripsi ?: 'Tidak ada deskripsi' }}
            </p>
            <br>



            {{-- RATING --}}
            <div class="rating-box">
                <span class="rating-star">⭐</span>
                <span class="rating-number">
                    {{ number_format($b->ratings()->avg('rating') ?? 0, 1) }}
                </span>
            </div>
            

            {{-- DETAIL KHUSUS LIST VIEW --}}
            <div class="list-detail-wrapper">
                <table class="detail-table">
                    <tr><td><strong>Kategori</strong></td><td>{{ $b->jenis }}</td></tr>
                    <tr><td><strong>Genre</strong></td><td>{{ $b->genre }}</td></tr>
                </table>
            </div>

        </div>

    </div>

</a>

@endforeach
