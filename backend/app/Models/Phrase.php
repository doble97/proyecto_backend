<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    use HasFactory;
    protected $table = 'phrases';

    protected $fillable = [
        'text',
        'translation',
    ];
    public function phraseDeckWord()
    {
        return $this->hasOne(PhraseDeckWord::class, 'fk_phrases');
    }
}