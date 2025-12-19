<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;


class KeranjangController extends Controller
{
    // Menampilkan isi keranjang user
    public function index()
    {
        $cart = Keranjang::firstOrCreate(['idUser' => Auth::id()], ['idUser' => Auth::id()]);
        $items = $cart->items()->with('buku')->get();
        $user = User::where('role','user')->get();
        $item_count = $cart->items()->with('buku')->count();

        return view('peminjaman', compact('items', 'user', 'item_count'));
    }

    
    public function add(Request $request)
    {
        $request->validate([
            'idBuku' => 'required|exists:buku,idBuku'
        ]);

        // Ambil atau buat keranjang user
        $cart = Keranjang::firstOrCreate(['idUser' => Auth::id()]);

        // Cek apakah buku sudah ada di keranjang
        $item = KeranjangItem::where('idCart', $cart->idCart)
                        ->where('idBuku', $request->idBuku)
                        ->first();

        if ($item) {
            $item->jumlah += 1;
            $item->save();
        } else {
            KeranjangItem::create([
                'idCart' => $cart->idCart,
                'idBuku' => $request->idBuku
            ]);
        }

        toastr()->error('Gagal mengupdate buku');
    }

    // Menghapus 1 item dari keranjang
    public function remove($idCartItem)
    {
        KeranjangItem::where('idCartItem', $idCartItem)->delete();

        return redirect()->route('peminjaman.index');
    }

    // Mengosongkan seluruh keranjang
    public function clear()
    {
        $cart = Keranjang::where('idUser', Auth::id())->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return response()->json(['message' => 'Keranjang dikosongkan']);
    }
}
