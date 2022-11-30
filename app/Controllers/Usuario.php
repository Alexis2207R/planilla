<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsuarioModel;
use App\Models\PerfilModel;



class Usuario extends Controller{
    public function __construct(){
        $this->validation =  \Config\Services::validation();
        $this->modUsuario = new UsuarioModel();
        $this->modPerfil = new PerfilModel();
    }

    public function index(){
        $perfiles = $this->modPerfil->mdlListarPerfiles();
        $data = [ 'Perfiles' => $perfiles ];
        return $this->ViewData('modules/usuario', $data);
    }

    public function list_usuarios(){
		if($this->request->isAjax()) {
            $usuarios = $this->modUsuario->mdlListarPerfiles();
            $data = ['Usuarios' => $usuarios];
            return json_encode($data['Usuarios']);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function single_usuario(){
        if($this->request->isAjax()) {
            $usuario = $this->modUsuario->getUsuario($_POST['item'], null);
            $data = ['Usuario' => $usuario];
            return json_encode($data['Usuario'][0]);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function form(){
        // VALIDAR INGRESO DE POST
        if($this->request->getMethod() != 'post'){
            return redirect()->to(base_url());
        }

        // return json_encode($_POST);die;
        // Validar post
        $this->validation->setRules([
            'dni' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'idperfil_usuario' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if ( isset( $_POST['id_usuario'] ) && !empty(  $_POST['id_usuario'] ) ) {
                $datos = [
                    "id_usuario" => $_POST['id_usuario'],
                    "nombre" => strtoupper( $_POST['nombre'] ),
                    "apellido" => strtoupper( $_POST['apellido'] ),
                    "idperfil_usuario" => $_POST['idperfil_usuario'],
                    "usuario" => $_POST['dni'],
                    "dni" => $_POST['dni']
                ];
                $update = $this->actualizar( $datos );
                return $update;
            }else{
                $datos = [
                    "nombre" => strtoupper( $_POST['nombre'] ),
                    "apellido" => strtoupper( $_POST['apellido'] ),
                    "idperfil_usuario" => $_POST['idperfil_usuario'],
                    "usuario" => $_POST['dni'],
                    "dni" => $_POST['dni'],
                    "clave" => $this->crypCode($_POST['dni'])
                ];
                $insert = $this->register( $datos );
                return $insert;
            }

        }else{
            $errors = $this->validation->getErrors();
            return json_encode( ['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida'] );
        }

    }

    public function register($datos){
        if($this->request->getMethod() != 'post'){
            return redirect()->to(base_url());
        }
        if ($this->modUsuario->getUsuario( null, $datos['dni'] )) {
            return json_encode(['status' => 400, 'msg' => 'El Usuario ya esta registrado']);
        }
        $insert = $this->modUsuario->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar al usuario']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Usuario registrado con exito']);
    }

    public function actualizar($datos){
        if($this->request->getMethod() != 'post'){
            return redirect()->to(base_url());
        }
        $update = $this->modUsuario->update( $_POST['id_usuario'], $datos );
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar el perfil']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Perfil actualizado con exito']);
    }

    public function reset_usuario(){
		if($this->request->isAjax()) {
            if ($_POST['item'] == 1) {
                return json_encode(['status' => 400, 'reset' => 0, 'msg' => 'No se puede restablecer este usuario. Usuario Administrador.']);
            }
            $usuario = $this->modUsuario->find( $_POST['item'] );
            if (!$usuario) {
                return json_encode(false);
            }

            $cryp = $this->crypCode($usuario['dni']);
            $reset = $this->modUsuario->update( $_POST['item'], ['clave' => $cryp] );
            if ( !$reset ) {
                return json_encode(['status' => 400, 'reset' => $reset, 'msg' => 'Hubo un error al intentar restablecer al usuario']);
            }
            return json_encode(['status' => 200, 'reset' => $reset, 'msg' => 'Usuario restablecido con exito']);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function delete_usuario(){
		if($this->request->isAjax()) {
            if ($_POST['item'] == 1) {
                return json_encode(['status' => 400, 'delete' => 0, 'msg' => 'No se puede eliminar este usuario. Usuario Administrador.']);
            }

            $usuario = $this->modUsuario->update( $_POST['item'], ['estado' => 0] );
            if ( !$usuario ) {
                return json_encode(['status' => 400, 'delete' => $usuario, 'msg' => 'Hubo un error al intentar eliminar el usuario']);
            }
            return json_encode(['status' => 200, 'delete' => $usuario, 'msg' => 'usuario eliminado con exito']);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function disabled_usuario(){
		if($this->request->isAjax()) {
            $usuario = $this->modUsuario->find( $_POST['item'] );

            if ($_POST['item'] == 1) {
                return json_encode(['status' => 400, 'disable' => 0, 'msg' => 'No se puede deshabilitar este usuario. Usuario Administrador.']);
            }

            if ( $usuario['estado'] == 1 ) {
                $usuario = $this->modUsuario->update( $_POST['item'], ['estado' => 2] );
                return json_encode(['status' => 200, 'disable' => $usuario, 'msg' => 'Usuario desactivado con exito']);
            }else{
                $usuario = $this->modUsuario->update( $_POST['item'], ['estado' => 1] );
                return json_encode(['status' => 200, 'disable' => $usuario, 'msg' => 'Usuario activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $usuario, 'msg' => 'Hubo un error al intentar deshabilidtar al usuario']);
		}else{
			return redirect()->to(base_url());
		}

    }
}
