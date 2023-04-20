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
        Schema::create('deck_owners', function (Blueprint $table) {
            $table->foreignId('fk_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('fk_deck')->constrained('decks')->onDelete('cascade');
            $table->primary(['fk_user', 'fk_deck']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deck_owners');
    }
};
