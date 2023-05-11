<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    public function decks()
    {
        return $this->belongsToMany(Deck::class, 'decks_words', 'fk_word', 'fk_deck');
    }
    
}