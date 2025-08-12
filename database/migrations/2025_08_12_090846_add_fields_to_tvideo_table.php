<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTvideoTable extends Migration
{
    public function up()
    {
        Schema::table('tvideo', function (Blueprint $table) {
            // SOLO agregamos campos NUEVOS - NO tocamos los existentes
            if (!Schema::hasColumn('tvideo', 'title')) {
                $table->string('title')->nullable()->after('id');
            }
            if (!Schema::hasColumn('tvideo', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'video_url')) {
                $table->string('video_url')->nullable();
            }
            if (!Schema::hasColumn('tvideo', 'thumbnail')) {
                $table->string('thumbnail')->nullable(); // Imagen preview
            }
            if (!Schema::hasColumn('tvideo', 'video_type')) {
                $table->string('video_type', 20)->default('youtube');
            }
            if (!Schema::hasColumn('tvideo', 'category')) {
                $table->string('category', 50)->nullable();
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
            // Solo eliminamos SI existen
            $columnsToCheck = ['title', 'description', 'video_url', 'thumbnail', 'video_type', 'category', 'status', 'sort_order', 'created_by'];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('tvideo', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}