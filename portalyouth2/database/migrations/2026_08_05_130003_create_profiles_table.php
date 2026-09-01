<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('national_id')->nullable();
            $table->date('date_of_birth');
            $table->string('gender', 24);
            $table->foreignUuid('province_id')->constrained()->restrictOnDelete();
            $table->foreignUuid('district_id')->constrained()->restrictOnDelete();
            $table->string('education_level', 40)->nullable();
            $table->string('employment_status', 40)->nullable();
            $table->string('occupation')->nullable();
            $table->text('about')->nullable();
            $table->json('interests')->nullable();
            $table->timestamps();

            $table->unique('national_id');
            $table->index('province_id');
            $table->index('district_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
