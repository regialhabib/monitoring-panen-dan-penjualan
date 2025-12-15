<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    /** @use HasFactory<\Database\Factories\PenjualanFactory> */
    use HasFactory;

    protected $fillable = ['tanggal_penjualan', 'jumlah_penjualan', 'harga', 'total_harga','id_jenis','keterangan'];

    public function jenis()
    {
        return $this->belongsTo(JenisJeruk::class, 'id_jenis');
    }
    
}
