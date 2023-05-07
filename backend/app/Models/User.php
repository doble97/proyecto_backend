<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function decks(){
        return $this->hasManyThrough(
            Deck::class,
            DeckOwner::class,
            'fk_user',
            'id',
            'id',
            'fk_deck'
        );
    }

    public function getDeckById($id){
            $deck = Deck::where('id', $id)
                        ->whereHas('owners', function ($query) {
                            $query->where('fk_user', $this->id);
                        })
                        ->firstOrFail();

            return $deck;
    }

}
