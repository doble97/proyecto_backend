<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeckWord extends Model
{
    use HasFactory;

    protected $table = 'decks_words';

    protected $fillable = [
        'fk_word',
        'fk_translation',
        'fk_deck'
    ];

    public function word(){
        return $this->belongsTo(Word::class,'fk_word');
    }

    public function translation(){
        return $this->belongsTo(Word::class, 'fk_translation');
    }

    public function deck(){
        return $this->belongsTo(Deck::class, 'fk_deck');
    }

    public function phraseDeckWord(){
        return $this->hasOne(PhraseDeckWord::class, 'fk_decks_words');
    }
}
