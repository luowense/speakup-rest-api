<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'id',
        'channelId'
    ];

    /**
     * Users associated to the ticket
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Messages in the ticket
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
