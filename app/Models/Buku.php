<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\BukuRating;
use Illuminate\Support\Facades\Auth;

class Buku extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'buku';
    protected $guarded = ['idBuku'];
    protected $primaryKey = 'idBuku';
    public $timestamps = true;
    
    public function ratings()
    {
        return $this->hasMany(BukuRating::class, 'idBuku', 'idBuku');
    }

    public function getUserRatingAttribute()
    {
        if (!Auth::check()) {
            return null;
        }

        return $this->ratings()->where('idUser', Auth::id())->first();
    }

    public function getDeskripsiAttribute($value)
    {
        return $value ?: 'Tidak ada deskripsi';
    }


    public function getRouteKeyName()
    {
        return 'idBuku';
    }
}

