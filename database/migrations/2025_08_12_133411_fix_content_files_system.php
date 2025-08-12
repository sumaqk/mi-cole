<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tcontent', function (Blueprint $table) {
            if (!Schema::hasColumn('tcontent', 'content_file')) {
                $table->string('content_file')->nullable();
            }
            if (!Schema::hasColumn('tcontent', 'file_type')) {
                $table->string('file_type', 10)->nullable();
            }
            if (!Schema::hasColumn('tcontent', 'file_size')) {
                $table->integer('file_size')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('tcontent', function (Blueprint $table) {
            if (Schema::hasColumn('tcontent', 'content_file')) {
                $table->dropColumn('content_file');
            }
            if (Schema::hasColumn('tcontent', 'file_type')) {
                $table->dropColumn('file_type');
            }
            if (Schema::hasColumn('tcontent', 'file_size')) {
                $table->dropColumn('file_size');
            }
        });
    }
};