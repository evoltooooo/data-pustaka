<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuRating extends Model
{
    protected $table = 'buku_user_ratings';
    protected $primaryKey = 'idRating';
    protected $fillable = ['idUser', 'idBuku', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function book()
    {
        return $this->belongsTo(Buku::class, 'idBuku', 'idBuku');
    }
}
