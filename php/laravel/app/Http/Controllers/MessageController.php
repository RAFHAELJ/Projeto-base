<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Chat\SendMessage;
use App\Models\HistoricoConversa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Repositories\MessageRepository;
class MessageController extends Controller
{

    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }


    public function index( int $userId)
    {
        
        $messages = $this->messageRepository->index($userId);   
        return response()->json($messages);
    }
    public function unreadCount($userId)
    {
        
        $unreadCount = $this->messageRepository->unreadCount($userId); 
        return response()->json(['unreadCount' => $unreadCount]);
    }

    public function store(Request $request)
    {
        $message = $this->messageRepository->store($request); 
        // Disparar evento
        Event::dispatch(new SendMessage($message,$request->destination_id));
        
        return response()->json($message);
    }

    public function sendMessage(Request $request)
    {
        $message = $this->messageRepository->store($request); 
        

        return response()->json(['status' => 'Message sent!']);
    }
}
