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
        Schema::create('rencana_panens', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_rencana');

            $table->foreignId('id_jenis')
                ->constrained('jenis_jeruks')
                ->cascadeOnDelete();

            $table->decimal('jumlah_rencana', 10, 1); // kg

            $table->text('catatan')->nullable();

            $table->enum('status', ['planned', 'harvested', 'cancelled'])
                ->default('planned');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencanan_panens');
    }
};
