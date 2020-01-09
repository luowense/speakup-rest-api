<?php

namespace App\Api\V1\Controllers;

use App\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function start()
    {
        $ticket = new Ticket;
        $ticket->save();
        return response(['ticket_id' => $ticket->id], 201);
    }

    public function index($id)
    {
        $ticketId = Ticket::find($id);
        return response(['ticket_id' => $ticketId], 201);
    }
}
