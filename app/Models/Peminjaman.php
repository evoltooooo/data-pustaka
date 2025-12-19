<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'idPeminjaman';

    protected $fillable = [
        'no_peminjaman',
        'idUser',
        'tanggal_pinjam',
        'tanggal_kembali',
        'batas_tanggal_kembali',
        'status'
    ];

    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class, 'idPeminjaman', 'idPeminjaman');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}
