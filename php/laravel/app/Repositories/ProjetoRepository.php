<?php

namespace App\Repositories;

use App\Models\Projeto;

class ProjetoRepository
{
    public function getAll()
    {
        return Projeto::all();
    }

    public function find($id)
    {
        return Projeto::findOrFail($id);
    }

    public function create(array $data)
    {
        return Projeto::create($data);
    }

    public function update($id, array $data)
    {
        $projeto = $this->find($id);
        $projeto->update($data);
        return $projeto;
    }

    public function delete($id)
    {
        $projeto = $this->find($id);
        return $projeto->delete();
    }
}
