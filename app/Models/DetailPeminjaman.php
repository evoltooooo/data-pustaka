<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'idDetail';

    protected $fillable = [
        'idPeminjaman',
        'idBuku',
        'no_peminjaman'
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'idBuku', 'idBuku');
    }

    public function peminjaman() {
        return $this->belongsTo(Peminjaman::class, 'idPeminjaman');
    }
}
