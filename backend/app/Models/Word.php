<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;
    protected $table = 'words';
    protected $fillable=[
        'name'
    ];

    public function deckWordWord()
    {
        return $this->hasOne(DeckWord::class, 'fk_word');
    }

    public function deckWordTranslation()
    {
        return $this->hasOne(DeckWord::class, 'fk_translation');
    }
}