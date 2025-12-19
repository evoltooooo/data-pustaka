<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ManajemenPeminjamanController extends Controller
{
    public function index(){
        $peminjaman = Peminjaman::with([
        'user',
        'details.buku'
    ])
    ->orderBy('tanggal_pinjam', 'DESC')
    ->get()
    ->groupBy('no_peminjaman'); 

    
    $pending = $peminjaman->filter(function ($group) {
        return $group->first()->status === 'pending';
    });

    $non_pending = $peminjaman->filter(function ($group) {
        return in_array($group->first()->status, ['dipinjam', 'ditolak', 'dikembalikan']);
    });

        return view('admin.peminjaman', compact('pending','non_pending'));
    }

    public function terima($id_peminjaman)
    {
        // Ambil data peminjaman berdasarkan nomor transaksi
        $peminjaman = Peminjaman::where('idPeminjaman', $id_peminjaman)->get();

        if ($peminjaman->isEmpty()) {
            return back()->with('failed', 'Data peminjaman tidak ditemukan.');
        }

        // Update status menjadi dipinjam
        Peminjaman::where('idPeminjaman', $id_peminjaman)
            ->update(['status' => 'dipinjam']);

        // Kurangi stok semua buku yang terkait
        foreach ($peminjaman as $p) {
            foreach ($p->details as $d) {
                $buku = Buku::find($d->idBuku);
                if ($buku && $buku->stok > 0) {
                    $buku->stok -= 1;
                    $buku->save();
                }
            }
        }

        toastr()->success('Permintaan peminjaman berhasil diterima.');
        return redirect()->route('manajemen.index');
    }

    public function tolak($id_peminjaman)
    {
        // Ambil data peminjaman
        $peminjaman = Peminjaman::where('idPeminjaman', $id_peminjaman)->first();

        if (!$peminjaman) {
            return back()->with('failed', 'Data peminjaman tidak ditemukan.');
        }

        // Ubah status menjadi ditolak
        $peminjaman->update(['status' => 'ditolak']);

        // Stok buku TIDAK berubah
        toastr()->success('Permintaan peminjaman berhasil ditolak.');
        return redirect()->route('manajemen.index');
    }
}
