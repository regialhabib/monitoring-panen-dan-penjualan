<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    /** @use HasFactory<\Database\Factories\PanenFactory> */
    use HasFactory;

    protected $table = 'panens';

    protected $fillable = [
        'tanggal_panen',
        'jumlah_panen',
        'keterangan',
        'id_jenis',
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisJeruk::class, 'id_jenis');
    }

    public function stok()
    {
        return $this->hasOne(Stok::class, 'id_jenis');
    }
}
