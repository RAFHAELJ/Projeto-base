<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjetoRequest;
use App\Repositories\ProjetoRepository;
use Illuminate\Support\Facades\Redirect;

class ProjetoController extends Controller
{
	protected $ProjetoRepository;

	public function __construct(ProjetoRepository $ProjetoRepository)
	{
		$this->ProjetoRepository = $ProjetoRepository;
	}

	public function index()
	{
		$projetos = $this->ProjetoRepository->getAll();
		return view('projetos.list', compact('projetos'));
	}

	public function store(ProjetoRequest $request)
	{
		$this->ProjetoRepository->create($request->validated());
		return Redirect::to('/projetos');
	}

	public function new()
	{
		return view('projetos.form');
	}

	public function edit($id)
	{
		$projeto = $this->ProjetoRepository->find($id);
		return view('projetos.form', compact('projeto'));
	}

	public function update(ProjetoRequest $request, $id)
	{
		$this->ProjetoRepository->update($id, $request->validated());
		return Redirect::to('/projetos');
	}

	public function destroy($id)
	{
		$this->ProjetoRepository->delete($id);
		return Redirect::to('/projetos');
	}
}
