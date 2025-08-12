<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tcontent', function (Blueprint $table) {
            if (!Schema::hasColumn('tcontent', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('content_file');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tcontent', function (Blueprint $table) {
            if (Schema::hasColumn('tcontent', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
        });
    }
};
