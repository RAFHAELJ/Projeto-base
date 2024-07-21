<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Imports\TarefasImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportTarefasJob implements ShouldQueue
{
	use Dispatchable;
	use InteractsWithQueue;
	use Queueable;
	use SerializesModels;

	protected $filePath;
	protected $userId;

	/**
	 * Create a new job instance.
	 *
	 * @param string $filePath
	 * @return void
	 */
	public function __construct($filePath, $userId)
	{
		$this->filePath = $filePath;
		$this->userId   = $userId;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		// Verifique se o arquivo existe
		if (!Storage::exists($this->filePath)) {
			throw new \Exception('Arquivo não encontrado: ' . $this->filePath);
		}

		try {
			Excel::import(new TarefasImport($this->userId), storage_path('app/' . $this->filePath));
		} catch (\Exception $e) {
			throw $e;  // Re-throw para que o job falhe corretamente
		}

		// Remover o arquivo temporário
		Storage::delete($this->filePath);
	}
}
