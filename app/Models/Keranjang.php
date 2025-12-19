<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'idCart';

    protected $fillable = [
        'idUser'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function items()
    {
        return $this->hasMany(KeranjangItem::class, 'idCart', 'idCart');
    }
}
