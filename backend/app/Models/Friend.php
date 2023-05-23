<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $table = 'friends';
    protected $fillable = [
        'state_request',
    ];

    public function userSendRequest()
    {
        return $this->belongsTo(User::class, 'fk_user_send_request');
    }

    public function userReceiveRequest()
    {
        return $this->belongsTo(User::class, 'fk_user_receive_request');
    }
}