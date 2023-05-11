<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhraseDeckWord extends Model
{
    use HasFactory;

    protected $table='phrases_decks_words';

    public function fk_phrases(){
        return $this->belongsTo(User::class,'fk_phrases');
    }

    public function fk_decks_words(){
        return $this->belongsTo(User::class,'fk_decks_words');
    }
}