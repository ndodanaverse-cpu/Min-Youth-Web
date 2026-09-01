<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('success_stories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->unsignedTinyInteger('age')->nullable();
            $table->foreignUuid('province_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('programme_id')->nullable()->constrained()->nullOnDelete();
            $table->string('role', 160)->nullable();
            $table->string('photo', 500)->nullable();
            $table->text('testimonial');
            $table->string('status', 20)->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'is_featured', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('success_stories');
    }
};
