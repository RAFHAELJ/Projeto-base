<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Repositories\UsersRepository;

class UsersController extends Controller
{
    public function __construct(UsersRepository $repository){
        $this->repository = $repository;
    }
    public function index(){
        $usuarios =  $this->repository->index();
        
        return \view('usuarios.list', ['usuarios'=>$usuarios]);
    }

    public function new(){
        return view('usuarios.form');
    }

    public function add(Request $request){
        $usuario =  $this->repository->add($request);
        return Redirect::to('/usuarios');
    }

    public function edit($id){
        $usuario =  $this->repository->edit($id);
        return view('usuarios.form', ['usuario'=>$usuario]);
    }

    public function update($id, Request $request){
        $usuario =  $this->repository->add($id,$request);
        return Redirect::to('/usuarios');
    }

    public function delete($id){
        $usuario =  $this->repository->add($id);
        return Redirect::to('/usuarios');
    }
}
