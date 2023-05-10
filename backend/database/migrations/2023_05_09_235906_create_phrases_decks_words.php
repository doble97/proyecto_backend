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
        Schema::create('phrases_decks_words', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_phrases');
            $table->foreign('fk_phrases')->references('id')->on('phrases')->onDelete('cascade');
            $table->unsignedBigInteger('fk_decks_words');
            $table->foreign('fk_decks_words')->references('id')->on('decks_words')->onDelete('cascade');
            $table->primary(['fk_phrases', 'fk_decks_words']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phrases_decks_words');
    }
};
