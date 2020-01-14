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
    public function join($ticketId)
    {
        $ticket = Ticket::find($ticketId);
         Auth::user()->tickets()->attach($ticket->id);
         return response()->json('channel created', 201);
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

    /**
     * Form evaluation at the end of the chat
     * @param Request $request
     */
    public function formEvaluationStore()
    {

    }
}
