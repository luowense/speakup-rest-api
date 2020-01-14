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
        $userId = Auth::user()->id;
        $userTickets = User::find($userId)->tickets;

        foreach($userTickets as $userTicket) {
            if($userTicket->id == $ticket->id){
                Broadcast::channel('channel.{ticketId}', function($ticket){
                   $ticketId = $ticket->id;
                   return $ticketId;
                });
                return response()->json('channel created', 201);
            }
            else {
                abort(403, 'The user is not authorized');
            }
        }
    }

    /**
     * Check completed tickets by psy
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkTicketByPsy($id)
    {
        if(Auth::user()->role_id != 2) {
            abort(403, 'not authorized');
        }
        $user = User::find($id);
        if(!$user){
            abort(404, 'user not found');
        }
        return response()->json($user->tickets);
    }
}
