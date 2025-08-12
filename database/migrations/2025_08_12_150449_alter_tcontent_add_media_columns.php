<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tcontent', function (Blueprint $table) {
            if (!Schema::hasColumn('tcontent', 'content_file')) {
                $table->string('content_file')->nullable()->after('tags');
            }
            if (!Schema::hasColumn('tcontent', 'file_type')) {
                $table->string('file_type', 20)->nullable()->after('content_file');
            }
            if (!Schema::hasColumn('tcontent', 'mime_type')) {
                $table->string('mime_type', 100)->nullable()->after('file_type');
            }
            if (!Schema::hasColumn('tcontent', 'file_size')) {
                $table->unsignedBigInteger('file_size')->nullable()->after('mime_type');
            }
            // si quieres timestamps y NO existen
            if (!Schema::hasColumn('tcontent', 'created_at')) {
                $table->timestamps(); // crea created_at y updated_at
            }
        });
    }

    public function down(): void
    {
        Schema::table('tcontent', function (Blueprint $table) {
            if (Schema::hasColumn('tcontent', 'content_file')) $table->dropColumn('content_file');
            if (Schema::hasColumn('tcontent', 'file_type'))    $table->dropColumn('file_type');
            if (Schema::hasColumn('tcontent', 'mime_type'))    $table->dropColumn('mime_type');
            if (Schema::hasColumn('tcontent', 'file_size'))    $table->dropColumn('file_size');
            if (Schema::hasColumn('tcontent', 'created_at'))   $table->dropTimestamps();
        });
    }
};

