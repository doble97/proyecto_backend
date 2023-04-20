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
        return $this->belongsTo(Language::class, 'fk_language');
    }
}
