<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tcontent', function (Blueprint $table) {
            if (!Schema::hasColumn('tcontent', 'excerpt')) {
                $table->text('excerpt')->nullable();
            }
            if (!Schema::hasColumn('tcontent', 'content')) {
                $table->longText('content')->nullable();
            }
            if (!Schema::hasColumn('tcontent', 'featured_image')) {
                $table->string('featured_image')->nullable();
            }
            if (!Schema::hasColumn('tcontent', 'slug')) {
                $table->string('slug')->nullable();
            }
            if (!Schema::hasColumn('tcontent', 'category')) {
                $table->string('category', 100)->nullable();
            }
            if (!Schema::hasColumn('tcontent', 'subcategory')) {
                $table->string('subcategory', 100)->nullable();
            }
            if (!Schema::hasColumn('tcontent', 'tags')) {
                $table->text('tags')->nullable();
            }
            if (!Schema::hasColumn('tcontent', 'status')) {
                $table->boolean('status')->default(true);
            }
            if (!Schema::hasColumn('tcontent', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
            if (!Schema::hasColumn('tcontent', 'views_count')) {
                $table->integer('views_count')->default(0);
            }
            if (!Schema::hasColumn('tcontent', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
            if (!Schema::hasColumn('tcontent', 'published_at')) {
                $table->timestamp('published_at')->nullable();
            }
            if (!Schema::hasColumn('tcontent', 'created_by')) {
                $table->integer('created_by')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('tcontent', function (Blueprint $table) {
            $columnsToCheck = [
                'excerpt', 'content', 'featured_image', 'slug', 'category',
                'subcategory', 'tags', 'status', 'is_featured', 'views_count',
                'sort_order', 'published_at', 'created_by'
            ];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('tcontent', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};