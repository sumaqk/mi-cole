<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tvideo', function (Blueprint $table) {
            if (!Schema::hasColumn('tvideo', 'title')) {
                $table->string('title')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'category')) {
                $table->string('category', 100)->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'youtube_url')) {
                $table->string('youtube_url')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'status')) {
                $table->tinyInteger('status')->default(1);
            }
            if (!Schema::hasColumn('tvideo', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
            if (!Schema::hasColumn('tvideo', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'video_file')) {
                $table->string('video_file')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'file_type')) {
                $table->string('file_type', 20)->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'mime_type')) {
                $table->string('mime_type', 100)->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'file_size')) {
                $table->unsignedBigInteger('file_size')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'thumbnail')) {
                $table->string('thumbnail')->nullable();
            }
            if (!Schema::hasColumns('tvideo', ['created_at', 'updated_at'])) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tvideo', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'description', 'category', 'youtube_url',
                'status', 'sort_order', 'created_by', 'video_file',
                'file_type', 'mime_type', 'file_size', 'thumbnail',
                'created_at', 'updated_at'
            ]);
        });
    }
};
