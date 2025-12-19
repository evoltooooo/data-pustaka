<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;

class PeminjamanController extends Controller
{
    public function index(){
        $buku = Buku::all();
        $buku_get = Buku::where('stok', 1)->get();

        return view('peminjaman', compact('buku', 'buku_get'));
    }

    private function generateNoPeminjaman()
    {
        $time = time(); // 10 digit
        $increment = Peminjaman::count() + 1; // auto increment manual

        return $time . $increment;
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam'   => 'required',
            'batas_tanggal_kembali' => 'required',
        ]);

        $userId = Auth::id();

        // Ambil keranjang user
        $cart = Keranjang::where('idUser', $userId)->first();
        if (!$cart) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $items = KeranjangItem::where('idCart', $cart->idCart)->get();
        if ($items->isEmpty()) {
            return back()->with('error', 'Tidak ada buku dalam keranjang.');
        }

        // Generate nomor peminjaman
        $noPeminjaman = $this->generateNoPeminjaman();

        $peminjaman = Peminjaman::create([
        'no_peminjaman'   => $noPeminjaman,
        'idUser'          => $userId,
        'tanggal_pinjam'  => $request->tanggal_pinjam,
        'tanggal_kembali' => null,
        'batas_tanggal_kembali' => $request->batas_tanggal_kembali,
        'status'          => 'pending'
    ]);

        // input detail peminjaman
        foreach ($items as $item) {
            DetailPeminjaman::create([
                'idPeminjaman'  => $peminjaman->idPeminjaman,
                'idBuku'        => $item->idBuku,
                'no_peminjaman' => $noPeminjaman
            ]);
        }

        KeranjangItem::where('idCart', $cart->idCart)->delete();

        toastr()->info('Permintaan peminjaman telah terkirim. Silahkan pergi ke Daftar Peminjaman untuk melihat status permintaan peminjaman.');
        return redirect()->route('peminjaman.index');
    }

    public function return($idPeminjaman)
    {
        $peminjaman = Peminjaman::with('details.buku')->findOrFail($idPeminjaman);

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString()
        ]);

        foreach ($peminjaman->details as $detail) {
            $detail->buku->update([
                'stok' => 1
            ]);
        }

        toastr()->success('Buku berhasil dikembalikan.');
        return back();
    }
}
