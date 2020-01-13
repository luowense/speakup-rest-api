<?php

namespace App\Api\V1\Controllers;

use App\Ticket;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Broadcast;

class TicketController extends Controller
{
    public function start()
    {
        $ticket = new Ticket;
        $ticket->channel_id = uniqid();
        $ticket->save();
        return response(['ticket_id' => $ticket->id], 201);
    }

    public function index($id)
    {
        $ticketId = Ticket::find($id);
        return response(['ticket_id' => $ticketId], 201);
    }

    /**
     *Authenticate the user's access to the channel
     * @param Ticket $ticket
     * @return string
     */
    public function join(Ticket $ticket)
    {
        if(Auth::user()->ticket_id == $ticket->id) {
            Broadcast::channel('channel.{ticketId}', function($ticket){
                $ticketId = $ticket->id;
                return $ticketId;
            });
            return response()->json('channel created');
        }
        else {
            return response()->json('the user is not authorized to connect to the channel');
        }
    }
}
