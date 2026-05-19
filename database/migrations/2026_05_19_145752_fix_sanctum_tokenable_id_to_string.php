<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE personal_access_tokens MODIFY tokenable_id VARCHAR(255) NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE personal_access_tokens MODIFY tokenable_id BIGINT(20) UNSIGNED NOT NULL');
    }
};
