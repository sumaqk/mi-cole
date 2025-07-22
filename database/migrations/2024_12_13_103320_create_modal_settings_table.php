<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('modal_settings');
        
        Schema::create('modal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->boolean('is_active')->default(true);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modal_settings');
    }
};