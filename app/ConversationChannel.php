<?php

namespace App;

use App\Ticket;

class ConversationChannel
{
    /**
     *Authenticate the user's access to the channel
     *
     * @param User $user
     * @param Ticket $ticket
     *
     * @return array|bool
     */
    public function join(User $user, Ticket $ticket)
    {
        return $ticket->users->contains($user);
    }
}
