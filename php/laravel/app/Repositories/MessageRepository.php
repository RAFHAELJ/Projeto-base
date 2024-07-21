<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Events\Chat\SendMessage;
use App\Models\HistoricoConversa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class MessageRepository
{
	public function index(int $userId)
	{
		$messages = HistoricoConversa::where(function ($query) use ($userId) {
			$query->where('user_id', Auth::id())->where('destination_id', $userId);
		})->orWhere(function ($query) use ($userId) {
			$query->where('user_id', $userId)->where('destination_id', Auth::id());
		})->get();

		foreach ($messages as $message) {
			if ($message->destination_id == Auth::id() && $message->unread) {
				$message->unread = false;
				$message->save();
			}
		}

		return $messages;
	}

	public function unreadCount(int $userId)
	{
		$unreadCount = HistoricoConversa::where('user_id', $userId)
			->where('unread', true)
			->count();

		return  $unreadCount;
	}

	public function store(Request $request)
	{
		if (!empty($request->user_id_py)) {
			$usrId = $request->user_id_py;
		} else {
			$usrId = Auth::id();
		}
		$message                 = new HistoricoConversa();
		$message->user_id        = intval($usrId);
		$message->destination_id = intval($request->destination_id);
		$message->message        = $request->message;
		$message->unread         = true;
		$message->save();

		return $message;
	}

	public function sendMessage(Request $request)
	{
		$message = $request->input('content');

		// Disparar evento

		return Event::dispatch(new SendMessage($message, $request->id));
	}
}
