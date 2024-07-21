<?php

namespace App\Services;

use GuzzleHttp\Client;

class LambdaService
{
	protected $client;
	protected $host;
	protected $port;

	public function __construct()
	{
		$this->client = new Client();
		$this->host   = env('LAMBDA_HOST', 'localhost');
		$this->port   = env('LAMBDA_PORT', '9001');
	}

	public function invoke($functionName, $payload)
	{
		//  dd(json_encode($payload));
		$response = $this->client->post("http://{$this->host}:{$this->port}/2015-03-31/functions/{$functionName}/invocations", [
			'body' => json_encode($payload),
		]);

		return json_decode($response->getBody(), true);
	}
}
