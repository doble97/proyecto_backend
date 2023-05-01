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
        Schema::create('phases_decks_words', function (Blueprint $table) {
            $table->integer('fk_phrases')->constrained('phrases')->onDelete('cascade');
            $table->integer('fk_decks_words')->constrained('decks_words')->onDelete('cascade');
            $table->primary(['fk_phrases', 'fk_decks_words']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phases_decks_words');
    }
};
