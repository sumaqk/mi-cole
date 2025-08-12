<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTcontentTable extends Migration
{
    public function up()
    {
        Schema::table('tcontent', function (Blueprint $table) {
            // Campos básicos del contenido
            $table->string('title')->after('id');
            $table->text('excerpt')->nullable()->after('title'); // resumen corto
            $table->longText('content')->after('excerpt'); // contenido completo
            $table->string('featured_image')->nullable()->after('content'); // imagen principal
            $table->string('slug')->unique()->after('featured_image'); // URL amigable
            
            // Campos de organización
            $table->string('category', 50)->nullable()->after('slug');
            $table->string('subcategory', 50)->nullable()->after('category');
            $table->string('tags')->nullable()->after('subcategory');
            $table->boolean('is_featured')->default(false)->after('tags');
            $table->boolean('status')->default(true)->after('is_featured');
            
            // SEO y metadata
            $table->string('meta_title')->nullable()->after('status');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            
            // Campos de orden y publicación
            $table->integer('sort_order')->default(0)->after('meta_keywords');
            $table->integer('views_count')->default(0)->after('sort_order');
            $table->timestamp('published_at')->nullable()->after('views_count');
            
            // Usuario que lo creó
            $table->integer('created_by')->nullable()->after('published_at');
        });
    }

    public function down()
    {
        Schema::table('tcontent', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'excerpt', 'content', 'featured_image', 'slug',
                'category', 'subcategory', 'tags', 'is_featured', 'status',
                'meta_title', 'meta_description', 'meta_keywords',
                'sort_order', 'views_count', 'published_at', 'created_by'
            ]);
        });
    }
}