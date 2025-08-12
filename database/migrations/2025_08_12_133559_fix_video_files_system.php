<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tvideo', function (Blueprint $table) {
            if (!Schema::hasColumn('tvideo', 'video_file')) {
                $table->string('video_file')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'file_type')) {
                $table->string('file_type', 10)->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'file_size')) {
                $table->integer('file_size')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('tvideo', function (Blueprint $table) {
            if (Schema::hasColumn('tvideo', 'video_file')) {
                $table->dropColumn('video_file');
            }
            if (Schema::hasColumn('tvideo', 'file_type')) {
                $table->dropColumn('file_type');
            }
            if (Schema::hasColumn('tvideo', 'file_size')) {
                $table->dropColumn('file_size');
            }
        });
    }
};