<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeckWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_word',
        'fk_translation',
        'fk_deck',
    ];

    public function word(){
        return $this->belongsTo(User::class,'fk_word');
    }

    public function translation(){
        return $this->belongsTo(Deck::class, 'fk_translation');
    }

    public function deck(){
        return $this->belongsTo(Deck::class, 'fk_deck');
    }

    public static function getDeckWordByIdAndUser($idDeckWord, $userId){
        $deckWord = self::where('id',$idDeckWord)->whereHas('owner',function($query) use ($userId){
            $query->where('fk_user', $userId);
        })->firstOrFail();
        return $deckWord;
    }

    public static function getDeckWordByFkWordAndUser($fkwordDeckWord, $userId){
        $deckWord = self::where('fk_word',$fkwordDeckWord)->whereHas('owner',function($query) use ($userId){
            $query->where('fk_user', $userId);
        })->firstOrFail();
        return $deckWord;
    }
}
