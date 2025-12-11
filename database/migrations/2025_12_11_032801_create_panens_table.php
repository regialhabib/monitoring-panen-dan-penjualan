<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('panens', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_panen');
            $table->decimal('jumlah_panen', 8, 2);
            $table->string('keterangan');
            $table->foreignId('id_jeruk')->constrained('jenis_jeruks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panens');
    }
};
