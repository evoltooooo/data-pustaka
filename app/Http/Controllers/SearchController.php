<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Buku;

class SearchController extends Controller
{
    public function index()
    {
        return view('search-demo');
    }

    public function search(Request $request)
    {
        $q           = $request->get('q');
        $kategori    = $request->get('kategori', []);
        $genre       = $request->get('genre', []);
        $bahasa      = $request->get('bahasa', []);
        $filterTahun = $request->get('filter_tahun');

        $query = Buku::query();


        $query->when($q, function ($qBuilder) use ($q) {
            $qBuilder->where('judul', 'like', "%{$q}%");
        });


        $query->when(!empty($kategori), function ($qBuilder) use ($kategori) {

            $qBuilder->whereIn('kategori', $kategori);
        });


        $query->when(!empty($genre), function ($qBuilder) use ($genre) {
            $qBuilder->whereIn('genre', $genre);
        });


        $query->when(!empty($bahasa), function ($qBuilder) use ($bahasa) {
            $qBuilder->whereIn('bahasa', $bahasa);
        });


        $query->when($filterTahun && $filterTahun !== 'all', function ($qBuilder) use ($filterTahun) {

            $currentYear = now()->year;

            if ($filterTahun == '3') {

                $minYear = $currentYear - 2;
                $qBuilder->where('tahun_terbit', '>=', $minYear);
            } elseif ($filterTahun == '5') {

                $minYear = $currentYear - 4;
                $qBuilder->where('tahun_terbit', '>=', $minYear);
            } elseif ($filterTahun == '>5') {

                $maxYear = $currentYear - 5;
                $qBuilder->where('tahun_terbit', '<=', $maxYear);
            }
        });

        $buku = $query->get();
        $totalHasil = $buku->count();

        if (Schema::hasTable('search_histories') && Auth::check() && $q) {
            SearchHistory::create([
                'user_id' => Auth::id(),
                'keyword' => $q,
            ]);
        }

        $listKategori = Buku::select('jenis')
            ->whereNotNull('jenis')
            ->distinct()
            ->pluck('jenis');

        $listGenre = Buku::select('genre')
            ->whereNotNull('genre')
            ->distinct()
            ->pluck('genre');

        $allLanguages = Buku::select('bahasa')
            ->whereNotNull('bahasa')
            ->distinct()
            ->pluck('bahasa', 'bahasa');

        return view('koleksi', [
            'buku'         => $buku,
            'q'            => $q,
            'totalHasil'   => $totalHasil,
            'listKategori' => $listKategori,
            'listGenre'    => $listGenre,
            'allLanguages' => $allLanguages,
            'filterTahun'  => $filterTahun,
            'selectedKategori' => $kategori,
            'selectedGenre'    => $genre,
            'selectedBahasa'   => $bahasa,
        ]);
    }

    public function suggest(Request $request)
    {
        $q = $request->get('q');

        if (!$q) {
            return response()->json([]);
        }

        $items = Buku::where('judul', 'like', "%{$q}%")
            ->orderBy('judul')
            ->limit(10)
            ->get([
                'idBuku',
                'judul',
                'cover'
            ]);

        return response()->json($items);
    }


    public function history(Request $request)
    {
        if (!Schema::hasTable('search_histories') || !Auth::check()) {
            return response()->json([]);
        }

        $items = SearchHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get(['id', 'keyword'])
            ->unique('keyword')
            ->values();

        return response()->json($items);
    }


    public function clearHistory()
    {
        $userId = Auth::id();

        SearchHistory::where('user_id', $userId)->delete();

        return response()->json(['status' => 'ok']);
    }

    public function deleteHistory($id)
    {
        $userId = Auth::id();

        SearchHistory::where('user_id', $userId)
            ->where('id', $id)
            ->delete();

        return response()->json(['status' => 'ok']);
    }
}
