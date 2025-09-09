<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapScreenshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmap_screenshots', function (Blueprint $table) {
            $table->id();
            $table->string('filename', 255); // Nombre del archivo de imagen
            $table->string('filepath', 500); // Ruta completa del archivo
            $table->date('capture_date'); // Fecha de captura
            $table->integer('year'); // Año de la captura
            $table->integer('month'); // Mes de la captura (1-12)
            $table->string('month_name', 20); // Nombre del mes en español
            $table->boolean('is_automatic')->default(false); // Si fue captura automática del último día del mes
            $table->text('description')->nullable(); // Descripción opcional
            $table->json('metadata')->nullable(); // Datos adicionales (zoom, coordenadas, etc.)
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index(['year', 'month']);
            $table->index('capture_date');
            $table->index('is_automatic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmap_screenshots');
    }
}