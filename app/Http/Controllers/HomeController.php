<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class HomeController extends Controller
{
   public function index()
{
    // POPULER: urut berdasarkan rating tertinggi → ambil 5
    $populer = Buku::withAvg('ratings', 'rating')
        ->orderByDesc('ratings_avg_rating')
        ->take(5)
        ->get();

    // TERBARU: urut berdasarkan created_at → ambil 5
    $baru = Buku::withAvg('ratings', 'rating')
        ->orderByDesc('created_at')
        ->take(5)
        ->get();

    return view('home', compact('populer', 'baru'));
}


/* ============================================
   RATING FUNCTION (SAMA PERSIS DENGAN KOLEKSI)
   ============================================ */
public function rating(Request $request, Buku $buku)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5'
    ]);

    $userId = Auth::id();

    $rating = BukuRating::updateOrCreate(
        ['idUser' => $userId, 'idBuku' => $buku->idBuku],
        ['rating' => $request->rating]
    );

    $averageRating = $buku->ratings()->avg('rating') ?? 0;

    return response()->json([
        'success' => true,
        'rating' => $rating->rating,
        'average' => $averageRating
    ]);
}


}
