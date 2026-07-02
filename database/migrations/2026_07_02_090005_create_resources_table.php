<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 36)->unique();
            $table->foreignId('institution_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('file_url')->nullable();
            $table->string('semester')->nullable();
            $table->string('academic_year')->nullable();
            $table->string('status')->default('published');
            $table->boolean('approved')->default(true);
            $table->boolean('is_lecturer_content')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['institution_id', 'created_at']);
            $table->index(['course_unit_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
