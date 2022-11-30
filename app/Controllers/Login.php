<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class Login extends Controller{
    public function __construct(){
        $this->modUser = new UsuarioModel();
    }

    public function index(){
        if( !session()->get( 'id_user' ) ){
            return view('login');
        }
        else{
            return redirect()->to(base_url());
        }
    }

    public function auth(){
        if($this->request->isAjax()) {
            if($this->request->getMethod() != 'post'){
                return json_encode(false);
            }
            $valid = $this->modUser->session_valid($_POST['user'], $this->crypCode($_POST['clave']));
            if ( !$valid ) {
                return json_encode(false);
            }

            $modulos = $this->modUser->get_mod($valid[0]['idperfil_usuario']);
            $data = [   
                'id_user' => $valid[0]['id_usuario'],
                'perfil' => $valid[0]['nombreperfil'],
                'idperfil' => $valid[0]['id_perfil'],
                'nombres' => $valid[0]['nombre'].' '.$valid[0]['apellido'],
                'Modulos' => $modulos,
                'user_dni' => $valid[0]['dni'],
                'usuario_user' => $valid[0]['usuario']
            ];
            $session = session();
            $session->set($data);
            return json_encode(true);
        }else{
            return redirect()->to(base_url()."/login");
        }
    }

    public function logout(){
        if($this->request->isAjax()) {
            if($this->request->getMethod() != 'get'){
                return json_encode(false);
            }

            $session = session();
            $session->destroy();
            return json_encode(true);
        }else{
            return redirect()->to(base_url());
        }
    }
}

