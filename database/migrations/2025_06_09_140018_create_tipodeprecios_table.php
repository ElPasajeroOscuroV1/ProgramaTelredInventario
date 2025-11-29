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
        Schema::create('tipodeprecios', function (Blueprint $table) {
            $table->id();
            $table->string('preciodecompra');
            $table->string('precioventamayor');
            $table->string('preciotecnico');
            $table->string('psf');
            $table->string('ps');
            $table->unsignedBigInteger('precio_id')->nullable();
            $table->foreign('precio_id')->references('id')->on('precios')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipodeprecios');
    }
};
