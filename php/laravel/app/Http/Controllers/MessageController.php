<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Event;
use App\Events\Chat\SendMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = $request->input('message',$request->to);

        // Disparar evento
        Event::dispatch(new sendMessage($message));

        return response()->json(['status' => 'Message sent!']);
    }
}
