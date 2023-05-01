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
        Schema::create('decks_words', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_word')->constrained('word_language')->onDelete('cascade');
            $table->integer('fk_translation')->constrained('word_language')->onDelete('cascade');
            $table->integer('fk_deck')->constrained('decks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decks_words');
    }
};