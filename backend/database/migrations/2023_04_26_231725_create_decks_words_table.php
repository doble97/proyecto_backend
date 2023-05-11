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
            $table->foreignId('fk_word')->constrained('words')->onDelete('cascade');
            $table->foreignId('fk_translation')->constrained('words')->onDelete('cascade');
            $table->foreignId('fk_deck')->constrained('decks')->onDelete('cascade');
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
// $table->unsignedBigInteger('fk_word');
// $table->foreign('fk_word')->references('id')->on('words')->onDelete('cascade');
// $table->unsignedBigInteger('fk_translation');
// $table->foreign('fk_translation')->references('id')->on('words')->onDelete('cascade');
// $table->unsignedBigInteger('fk_deck');
// $table->foreign('fk_deck')->references('id')->on('decks')->onDelete('cascade');
//Ultimo comic de alexis que volvio a añadir esto