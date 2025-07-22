<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugel', function (Blueprint $table) {
            $table->string('idUgel', 255)->primary();
            $table->string('name');
            $table->string('code', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('status', 50)->default('Activo');
            $table->timestamps();
            
            $table->index('status');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugel');
    }
};