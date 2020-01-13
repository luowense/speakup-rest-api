<?php


namespace App\Api\V1\Controllers;

use App\Api\V1\Events\MessageSent;
use App\Message;
use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $messages = Message::all();
        $idMessages = [];
        foreach($messages as $message) {
            if($message->ticket_id == $id){
                array_push($idMessages, $message);
            }
            elseif(empty($idMessages)) {
                return 'No data found';
            }
        }
        return $idMessages;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, $id)
    {
        $message = Message::create([
            'sender_id' => Auth::user()->id,
            'message' => $request->input('message'),
            'ticket_id' => $id,
        ]);

        $user = Auth::user();
        $m = new MessageSent($message, $user);
        $m->broadcastOn();

        return $message->fresh();
    }
}
