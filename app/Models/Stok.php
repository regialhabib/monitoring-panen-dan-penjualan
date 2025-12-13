<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    /** @use HasFactory<\Database\Factories\StokFactory> */
    use HasFactory;
    protected $table = 'stoks';
    protected $fillable = ['id_jenis', 'jumlah_stok'];

    public function jenis()
    {
        return $this->belongsTo(JenisJeruk::class, 'id_jenis');
    }

    public function panen()
    {
        return $this->belongsTo(Panen::class, 'id_jenis');
    }
}
