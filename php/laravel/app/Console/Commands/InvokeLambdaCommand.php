<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\InvokeLambdaRepository;

class InvokeLambdaCommand extends Command
{
    protected $signature = 'lambda:invoke';
    protected $description = 'Send a request to the Lambda function';

    protected $invokeLambdaRepository;

    public function __construct(InvokeLambdaRepository $invokeLambdaRepository)
    {
        parent::__construct();
        $this->invokeLambdaRepository = $invokeLambdaRepository;
    }

    public function handle()
    {
        $payload = ['message' => 'gerenciar']; // Defina o payload que deseja enviar
        
        $response = $this->invokeLambdaRepository->invokeLambdaFunction($payload);

        
    }
}
