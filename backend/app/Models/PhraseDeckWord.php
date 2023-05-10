<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhraseDeckWord extends Model
{
    use HasFactory;
    protected $table = 'phrases_decks_words';

    public function phrase(){
        return $this->belongsTo(Phrase::class,'fk_phrases');
    }

    public function deckWord(){
        return $this->belongsTo(DeckWord::class,'fk_decks_words');
    }
}