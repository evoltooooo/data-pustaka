<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangItem extends Model
{
    protected $table = 'keranjang_items';
    protected $primaryKey = 'idCartItem';

    protected $fillable = [
        'idCart',
        'idBuku'
    ];

    public function cart()
    {
        return $this->belongsTo(Keranjang::class, 'idCart', 'idCart');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'idBuku', 'idBuku');
    }
}
