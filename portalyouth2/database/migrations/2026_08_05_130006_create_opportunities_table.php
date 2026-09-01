<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category', 40);
            $table->text('summary');
            $table->longText('description');
            $table->text('eligibility')->nullable();
            $table->string('funding_amount', 60)->nullable();
            $table->string('organizer', 160)->nullable();
            $table->foreignUuid('province_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('district_id')->nullable()->constrained()->nullOnDelete();
            $table->string('image_url', 500)->nullable();
            $table->string('apply_url', 500)->nullable();
            $table->timestamp('deadline_at')->nullable();
            $table->string('status', 20)->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'deadline_at']);
            $table->index(['category', 'province_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
