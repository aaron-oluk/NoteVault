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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // e.g., 'resource_approved', 'research_work_endorsed', 'new_follower', 'comment', etc.
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable(); // BoxIcons class name
            $table->string('icon_bg_color')->default('blue'); // Tailwind color name
            $table->string('link')->nullable(); // URL to navigate to when clicked
            $table->morphs('notifiable'); // For polymorphic relationship (notifiable_type, notifiable_id)
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'read_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
