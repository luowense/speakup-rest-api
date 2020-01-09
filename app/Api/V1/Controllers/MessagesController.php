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
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        return auth()
            ->user()
            ->messages()
            ->where(function ($query) {
                $query->bySender(request()->input('sender_id'))
                    ->byReceiver(auth()->user()->id);
            })
            ->orWhere(function ($query) {
                $query->bySender(auth()->user()->id)
                    ->byReceiver(request()->input('sender_id'));
            })
            ->get();
}

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $message = Message::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => Auth::user()->id,
            'message' => $request->input('message'),
            'ticket_id' => $request->input('ticket_id'),
        ]);
        $user = Auth::user()->getAuthIdentifier();
        $m = new MessageSent($message, $user);
        $m->broadcastOn();

        return $message->fresh();
    }
}
