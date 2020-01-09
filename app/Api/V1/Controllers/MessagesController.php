<?php


namespace App\Api\V1\Controllers;

use App\Api\V1\Events\MessageSent;
use App\Message;
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
            'sender_id'   => Auth::id(),
            'receiver_id' => Auth::id(),
            'message'     => $request->input('message'),
            'ticket_id' => $ticket->id,
        ]);

        $m = new MessageSent($message);
        $m->broadcastOn();

        return $message->fresh();
    }
}
