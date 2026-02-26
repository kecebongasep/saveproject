<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    use HasFactory;
    protected $table = 'penulis';
    protected $primaryKey = 'id_penulis';

    protected $fillable = ['nama', 'asal_negara'];

    public function buku()
    {
        return $this->hasMany(Penulis::class, 'id_penulis');
    }
}
