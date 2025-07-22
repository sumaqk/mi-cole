<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tugel', function (Blueprint $table) {
            if (!Schema::hasColumn('tugel', 'name')) {
                $table->string('name', 255)->after('idUgel');
            }
            
            if (!Schema::hasColumn('tugel', 'code')) {
                $table->string('code', 50)->after('name');
            }
            
            if (!Schema::hasColumn('tugel', 'idProvince')) {
                $table->string('idProvince', 255)->after('code');
            }
            
            if (!Schema::hasColumn('tugel', 'idDistrict')) {
                $table->string('idDistrict', 255)->after('idProvince');
            }
            
            if (!Schema::hasColumn('tugel', 'address')) {
                $table->text('address')->nullable()->after('idDistrict');
            }
            
            if (!Schema::hasColumn('tugel', 'phone')) {
                $table->string('phone', 20)->nullable()->after('address');
            }
            
            if (!Schema::hasColumn('tugel', 'email')) {
                $table->string('email', 100)->nullable()->after('phone');
            }
            
            if (!Schema::hasColumn('tugel', 'director')) {
                $table->string('director', 255)->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('tugel', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('director');
            }
        });

        try {
            DB::statement('ALTER TABLE tugel ADD UNIQUE INDEX tugel_code_unique (code)');
        } catch (\Exception $e) {
        }

        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_NAME = 'tugel' 
            AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ");

        $existingForeignKeys = collect($foreignKeys)->pluck('CONSTRAINT_NAME')->toArray();

        if (!in_array('tugel_idprovince_foreign', $existingForeignKeys)) {
            try {
                DB::statement('
                    ALTER TABLE tugel 
                    ADD CONSTRAINT tugel_idprovince_foreign 
                    FOREIGN KEY (idProvince) 
                    REFERENCES tprovince(idProvince) 
                    ON DELETE RESTRICT 
                    ON UPDATE CASCADE
                ');
            } catch (\Exception $e) {
            }
        }

        if (!in_array('tugel_iddistrict_foreign', $existingForeignKeys)) {
            try {
                DB::statement('
                    ALTER TABLE tugel 
                    ADD CONSTRAINT tugel_iddistrict_foreign 
                    FOREIGN KEY (idDistrict) 
                    REFERENCES tdistrict(idDistrict) 
                    ON DELETE RESTRICT 
                    ON UPDATE CASCADE
                ');
            } catch (\Exception $e) {
            }
        }
    }

    public function down(): void
    {
        Schema::table('tugel', function (Blueprint $table) {
            try {
                $table->dropForeign(['idProvince']);
            } catch (\Exception $e) {
            }
            
            try {
                $table->dropForeign(['idDistrict']);
            } catch (\Exception $e) {
            }

            $columns = ['name', 'code', 'idProvince', 'idDistrict', 'address', 'phone', 'email', 'director', 'is_active'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('tugel', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};