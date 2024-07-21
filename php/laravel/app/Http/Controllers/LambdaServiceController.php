<?php

namespace App\Http\Controllers;

use App\Services\LambdaService;
use Illuminate\Http\Request;

class LambdaServiceController extends Controller
{
	protected $lambdaService;

	public function __construct(LambdaService $lambdaService)
	{
		$this->lambdaService = $lambdaService;
	}

	public function invokeLambdaFunction()
	{
		$payload  = [];
		$response = $this->lambdaService->invoke('function', $payload);

		// Faça algo com a resposta
		return response()->json($response);
	}
}
