<?php

namespace App\Repositories;

use auth;
use Redirect;
use App\Models\Tarefas;
use App\Models\SubTarefa;
use Illuminate\Http\Request;
use App\Imports\TarefasImport;
use App\Jobs\ImportTarefasJob;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TarefasTemplateExport;
use Illuminate\Support\Facades\Storage;

class TarefasRepository
{
	public function index()
	{
		$usuarios = Tarefas::get();

		return $usuarios;
	}

	public function new()
	{
		return view('usuarios.form');
	}

	public function create(Request $request)
	{
		$data            = $request->all();
		$data['user_id'] = auth()->id();
		$tarefa          = new Tarefas();
		$tarefas         = $tarefa->create($data);
		return $tarefas;
	}

	public function find($id)
	{
		$tarefa= Tarefas::find($id);
		return $tarefa;
	}

	public function edit($id)
	{
		$tarefa = Tarefas::with('subtarefas')->find($id);
		return $tarefa;
	}

	public function update($id, Request $request)
	{
		$tarefa  = Tarefas::find($id);
		$tarefas = $tarefa->update($request->all());
		return $tarefas;
	}

	public function delete($id)
	{
		$tarefas= Tarefas::find($id);
		$tarefas->delete();
		return $tarefas;
	}

	public function generateTemplate()
	{
		return Excel::download(new TarefasTemplateExport(), 'template_tarefas.xlsx');
	}

	public function upload(Request $request)
	{
		// Validar o arquivo
		$request->validate([
			'file' => 'required|mimes:xlsx'
		]);

		// Obter o arquivo
		$file   = $request->file('file');
		$userId = auth()->id(); // Obter o ID do usuário autenticado
		// Salvar o arquivo temporariamente

		$filePath = $file->store('temp');

		// Despachar o job
		ImportTarefasJob::dispatch($filePath, $userId);

		return response()->json(['message' => 'Importação iniciada.'], 200);
	}
}
