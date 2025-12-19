<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth as Auth;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index(){
        $userId = Auth::id();
        $user = Auth::user();

        $peminjaman = Peminjaman::with([
            'details.buku'
        ])
        ->where('idUser', $userId)
        ->orderBy('tanggal_pinjam', 'DESC')
        ->get();

        return view('profil', compact('peminjaman', 'user'));
    }

    public function updateFoto(Request $request)
    {
        $foto = $request->validate([
            'photo' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048'
        ]);

        $user = Auth::user();

        // --- HAPUS FOTO LAMA ---
        if ($user->photo && $user->photo !== 'defaultphoto.png') {
            $oldPath = public_path('uploads/profile/' . $user->photo);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // --- PROSES FOTO BARU ---
        $file = $request->file('photo');

        $path = 'uploads/profile/';


        // nama file awal (sebelum resize)
        $imageName = time() . '.webp';

        // -- RESIZE + CONVERT --
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        // --- RESIZE 700x700 ---
        $image->cover(500, 500);

        // --- SAVE WEBP ---
        $image->toWebp(60)->save(public_path($path . $imageName));

        // --- UPDATE DATABASE ---
        $user->update([
            'photo' => $imageName
        ]);

        toastr()->success('Berhasil mengubah foto proil.');
        return redirect()->back();
    }

    public function updateData(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . Auth::id() . ',idUser',
            'no_telp' => 'nullable|max:20'
        ]);

        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp
        ]);

        toastr()->success('Profil berhasil diperbarui.');
        return redirect()->back();
    }

}
