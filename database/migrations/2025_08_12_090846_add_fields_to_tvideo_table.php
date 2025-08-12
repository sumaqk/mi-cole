<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tvideo', function (Blueprint $table) {
            // NO tocar title ni description si ya existen - pueden tener datos
            if (!Schema::hasColumn('tvideo', 'video_path')) {
                $table->string('video_path')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'thumbnail')) {
                $table->string('thumbnail')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'youtube_url')) {
                $table->string('youtube_url')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'category')) {
                $table->string('category', 100)->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'status')) {
                $table->boolean('status')->default(true);
            }
            if (!Schema::hasColumn('tvideo', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
            if (!Schema::hasColumn('tvideo', 'created_by')) {
                $table->integer('created_by')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('tvideo', function (Blueprint $table) {
            $columnsToCheck = [
                'video_path', 'thumbnail', 'youtube_url',
                'category', 'status', 'sort_order', 'created_by'
            ];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('tvideo', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};