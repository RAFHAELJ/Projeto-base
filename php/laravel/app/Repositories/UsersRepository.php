<?php

namespace App\Repositories;

use Redirect;
use Illuminate\Http\Request;
use App\Models\User;


class UsersRepository{

    public function indexChat(){
        $usuarios = User::get();
        
        return $usuarios;
    }
  
    public function index(){
        $usuarios = User::get();
        
        return $usuarios;
    }

    public function new(){
        return view('usuarios.form');
    }

    public function add(Request $request){
       
        $usuario = new User;
        $usuario = $usuario->create($request->all());
        return $usuario;
    }

    public function edit($id){
        $usuario= User::find($id);
        return $usuario;
    }

    public function update($id, Request $request){
        $usuario= User::find($id);
        $usuario = $usuario->update($request->all());
        return $usuario;
    }

    public function delete($id){
        $usuario= User::find($id);
        $usuario -> delete();
        return $usuario;
    }
}
