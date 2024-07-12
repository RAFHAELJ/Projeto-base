<?php

namespace App\Repositories;

use Redirect;
use Illuminate\Http\Request;
use App\Models\Usuario;


class UsersRepository{
  
    public function index(){
        $usuarios = Usuario::get();
        
        return $usuarios;
    }

    public function new(){
        return view('usuarios.form');
    }

    public function add(Request $request){
       
        $usuario = new Usuario;
        $usuario = $usuario->create($request->all());
        return $usuario;
    }

    public function edit($id){
        $usuario= Usuario::find($id);
        return $usuario;
    }

    public function update($id, Request $request){
        $usuario= Usuario::find($id);
        $usuario = $usuario->update($request->all());
        return $usuario;
    }

    public function delete($id){
        $usuario= Usuario::find($id);
        $usuario -> delete();
        return $usuario;
    }
}
