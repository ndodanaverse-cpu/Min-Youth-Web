<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type', 40);
            $table->boolean('is_flagship')->default(false);
            $table->text('summary');
            $table->longText('content')->nullable();
            $table->string('hero_image', 500)->nullable();
            $table->json('stats')->nullable();
            $table->json('videos')->nullable();
            $table->json('support_services')->nullable();
            $table->json('emergency_contacts')->nullable();
            $table->string('status', 20)->default('draft');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'is_flagship', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
