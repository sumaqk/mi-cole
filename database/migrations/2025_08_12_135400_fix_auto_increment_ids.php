<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // --- TVIDEO ---
        // 1) Asegura que no existan ids 0 o NULL antes de poner AUTO_INCREMENT
        DB::statement("SET @max := (SELECT COALESCE(MAX(id),0) FROM tvideo)");
        DB::statement("UPDATE tvideo SET id = (@max := @max + 1) WHERE id IS NULL OR id <= 0");

        // 2) Ahora sí, convierte la columna a AUTO_INCREMENT de forma segura
        DB::statement("ALTER TABLE tvideo MODIFY id INT UNSIGNED NOT NULL AUTO_INCREMENT");

        // --- TCONTENT ---
        DB::statement("SET @max := (SELECT COALESCE(MAX(id),0) FROM tcontent)");
        DB::statement("UPDATE tcontent SET id = (@max := @max + 1) WHERE id IS NULL OR id <= 0");

        DB::statement("ALTER TABLE tcontent MODIFY id INT UNSIGNED NOT NULL AUTO_INCREMENT");
    }

    public function down(): void
    {
        // Revertir AUTO_INCREMENT (opcional)
        DB::statement("ALTER TABLE tvideo MODIFY id INT UNSIGNED NOT NULL");
        DB::statement("ALTER TABLE tcontent MODIFY id INT UNSIGNED NOT NULL");
    }
};
