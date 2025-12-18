<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaPanen extends Model
{
    /** @use HasFactory<\Database\Factories\RencananPanenFactory> */
    use HasFactory;
    protected $table = 'rencana_panens';
    protected $fillable = [
        'tanggal_rencana',
        'id_jenis',
        'jumlah_rencana',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_rencana' => 'date',
        'jumlah_rencana' => 'decimal:1',
    ];

    // RencanaPanen.php
    public function jenis()
    {
        return $this->belongsTo(JenisJeruk::class, 'id_jenis');
    }

    // ✅ Helper tampilan kg (23 → 23 | 23.5 → 23.5)
    public function getJumlahRencanaFormattedAttribute()
    {
        return rtrim(rtrim(number_format($this->jumlah_rencana, 1, '.', ''), '0'), '.');
    }
}
