<?php

namespace App\Listeners;

use App\Events\TarefaAtrasadaEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EnviarNotificacaoListener
{
	public function __construct()
	{
		//
	}

	public function handle(TarefaAtrasadaEvent $event)
	{
		// Enviar notificação via Pusher
		broadcast(new TarefaAtrasadaEvent($event->userId, $event->message));
	}
}
