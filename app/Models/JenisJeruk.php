<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisJeruk extends Model
{
    /** @use HasFactory<\Database\Factories\JenisJerukFactory> */
    use HasFactory;

    protected $table = 'jenis_jeruks';

    protected $fillable = [
        'jenis_jeruk',
    ];

    public function panen()
    {
        return $this->hasMany(Panen::class, 'id_jenis');
    }

    // JenisJeruk.php
public function rencanaPanens()
{
    return $this->hasMany(RencanaPanen::class, 'id_jenis');
}

}
