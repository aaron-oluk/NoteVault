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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email_domain')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // The users table's institution_id column could not be constrained when users was
        // created, since users is pinned to the earliest possible migration timestamp and
        // institutions did not exist yet. Add the real foreign key now that both tables exist.
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['institution_id']);
        });

        Schema::dropIfExists('institutions');
    }
};
