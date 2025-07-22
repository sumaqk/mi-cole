<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tinstitution', 'idUgel')) {
            Schema::table('tinstitution', function (Blueprint $table) {
                $table->string('idUgel', 255)
                      ->nullable()
                      ->after('idDistrict')
                      ->charset('utf8mb4')
                      ->collation('utf8mb4_unicode_ci');
                
                // Crear índice
                $table->index('idUgel');
            });
        }

        $foreignExists = DB::select("
            SELECT COUNT(*) as count 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE CONSTRAINT_NAME = 'tinstitution_idugel_foreign'
            AND TABLE_NAME = 'tinstitution'
        ");

        if ($foreignExists[0]->count == 0) {
            $tugelColumn = DB::select("
                SELECT DATA_TYPE, CHARACTER_SET_NAME, COLLATION_NAME 
                FROM information_schema.COLUMNS 
                WHERE TABLE_NAME = 'tugel' AND COLUMN_NAME = 'idUgel'
            ")[0];

            $tinstitutionColumn = DB::select("
                SELECT DATA_TYPE, CHARACTER_SET_NAME, COLLATION_NAME 
                FROM information_schema.COLUMNS 
                WHERE TABLE_NAME = 'tinstitution' AND COLUMN_NAME = 'idUgel'
            ")[0];

            if ($tugelColumn->CHARACTER_SET_NAME === $tinstitutionColumn->CHARACTER_SET_NAME &&
                $tugelColumn->COLLATION_NAME === $tinstitutionColumn->COLLATION_NAME) {
                
                Schema::table('tinstitution', function (Blueprint $table) {
                    $table->foreign('idUgel')
                        ->references('idUgel')
                        ->on('tugel')
                        ->onDelete('set null')
                        ->onUpdate('cascade');
                });
            }
        }
    }

    public function down(): void
    {
        Schema::table('tinstitution', function (Blueprint $table) {
            
            $foreignExists = DB::select("
                SELECT COUNT(*) as count 
                FROM information_schema.TABLE_CONSTRAINTS 
                WHERE CONSTRAINT_NAME = 'tinstitution_idugel_foreign'
                AND TABLE_NAME = 'tinstitution'
            ");

            if ($foreignExists[0]->count > 0) {
                $table->dropForeign(['idUgel']);
            }


            if (Schema::hasColumn('tinstitution', 'idUgel')) {
                $table->dropIndex(['idUgel']);
                $table->dropColumn('idUgel');
            }
        });
    }
};