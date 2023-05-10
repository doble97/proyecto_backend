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
            $table->unsignedBigInteger('fk_word');
            $table->foreign('fk_word')->references('id')->on('words')->onDelete('cascade');
            $table->unsignedBigInteger('fk_translation');
            $table->foreign('fk_translation')->references('id')->on('words')->onDelete('cascade');
            $table->unsignedBigInteger('fk_deck');
            $table->foreign('fk_deck')->references('id')->on('decks')->onDelete('cascade');
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