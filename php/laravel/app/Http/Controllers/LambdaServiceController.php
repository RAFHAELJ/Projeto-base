<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LambdaService;
use Illuminate\Support\Facades\Log;
use App\Repositories\InvokeLambdaRepository;

class LambdaServiceController extends Controller
{
	protected $lambdaService;

	public function __construct(InvokeLambdaRepository $invokeLambdaRepository)
	{
		$this->invokeLambdaRepository = $invokeLambdaRepository;
	}

	public function invokeLambdaFunction(Request $request)
    {        
        $response = $this->invokeLambdaRepository->invokeLambdaFunction($request);
        
        return response()->json($response);
    }
}
