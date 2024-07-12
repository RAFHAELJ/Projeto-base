<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use App\Events\TarefaAtrasadaEvent;

class MensagemController extends Controller
{
    public function enviarMensagem(Request $request)
    {
        $tarefaId = $request->input('tarefa_id');
        $mensagem = $request->input('mensagem');

        // Dispara evento Pusher
        event(new TarefaAtrasadaEvent($tarefaId, $mensagem));

        return response()->json(['status' => 'success', 'message' => 'Mensagem enviada com sucesso via Pusher']);
    }
}
