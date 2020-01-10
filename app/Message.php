<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'message',
        'ticket_id'
    ];

    protected $with = ['sender'];

    public function scopeBySender($q, $sender)
    {
        $q->where('sender_id', $sender);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->select(['id', 'name']);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id')->select(['id', 'name']);
    }
}
