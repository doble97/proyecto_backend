<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeckCollaborator extends Model
{
    use HasFactory;
    protected $table = 'deck_collaborators';

    protected $fillable = [
        'fk_user',
        'fk_deck'
    ];
    public function user(){
        return $this->belongsTo(User::class,'fk_user');
    }

    public function deck(){
        return $this->belongsTo(Deck::class, 'fk_deck');
    }
}