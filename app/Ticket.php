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
        return $this->belongToMany(User::class)
            ->using(Ticket::class)
            ->withPivot([
                'created_by',
                'updated_by'
            ]);
    }

    /**
     * Messages in the ticket
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
