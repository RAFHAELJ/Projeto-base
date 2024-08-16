<?php

namespace App\Repositories;

use App\Services\LambdaService;
use Illuminate\Support\Facades\Log;

class InvokeLambdaRepository 
{
    protected $lambdaService;

    public function __construct(LambdaService $lambdaService)
    {
        $this->lambdaService = $lambdaService;
    }

    public function invokeLambdaFunction($payload)
    {
        // Registre o payload como uma string JSON
       

        // Chame o serviço Lambda
        $response = $this->lambdaService->invoke('function', $payload);
        Log::info('Payload: ' . json_encode($response));
        // Retorne a resposta
        return $response;
    }
}
