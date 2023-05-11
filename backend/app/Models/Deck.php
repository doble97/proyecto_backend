<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'fk_languages'
    ];

    public function language(){
        //dice que el modelo deck tiene la foranea de langugage
        return $this->belongsTo(Language::class, 'fk_language');
    }


    public function owner()
    {
        //dice que el modelo DeckOwner tiene la primary key de Deck
        return $this->hasOne(DeckOwner::class, 'fk_deck');
    }


    public static function getDeckByIdAndUser($idDeck, $userId){
        $deck = self::where('id',$idDeck)->whereHas('owner',function($query) use ($userId){
            $query->where('fk_user', $userId);
        })->firstOrFail();
        return $deck;
    }
    public function words()
{
    return $this->belongsToMany(Word::class, 'decks_words', 'fk_deck', 'fk_word');
}

}
