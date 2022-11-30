<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\PerfilModel;

class Perfil extends Controller{
    public function __construct(){
        $this->validation =  \Config\Services::validation();
        $this->modPerfil = new PerfilModel();
    }

    public function index(){
        $listModulo = $this->modPerfil->mdlListaModulos();
        $data = ['ListModulo' => $listModulo];
        return $this->ViewData('modules/perfiles', $data);
    }

    public function list_perfiles(){
		if($this->request->isAjax()) {
            $perfil = $this->modPerfil->mdlListarPerfiles();
            $data = ['Perfiles' => $perfil];
            return json_encode($data['Perfiles']);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function single_perfil(){
        if($this->request->isAjax()) {
            $perfil = $this->modPerfil->find($_POST['item']);
            $accesos = $this->modPerfil->mdlModulos($_POST['item']);
            $data = ['Perfil' => $perfil, 'Access' => $accesos];
            return json_encode($data);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function list_accesos(){
		if($this->request->isAjax()) {
            $acceso = $this->modPerfil->mdlModulos($_POST['item']);
            if ( !$acceso ) {
                return json_encode(false);
            }
            $data = ['Accesos' => $acceso];
            return json_encode($data);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function form(){
        // VALIDAR INGRESO DE POST
        if($this->request->getMethod() != 'post'){
            return redirect()->to(base_url());
        }

        // return json_encode($_POST);
        // Validar post
        $this->validation->setRules([
            'nombreperfil' => 'required|alpha_numeric_punct'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if ( !isset( $_POST['permisos'] ) ){
                return json_encode( ['status' => 400, 'msg' => 'Seleccione al menos un permiso'] );
            }

            if ( isset( $_POST['id_perfil'] ) && !empty(  $_POST['id_perfil'] ) ) {
                $datos = [
                    "id_perfil" => $_POST['id_perfil'],
                    "nombreperfil" => strtoupper( $_POST['nombreperfil'] ),
                    "Permisos" => $_POST['permisos']
                ];
                $update = $this->actualizar( $datos );
                return $update;
            }else{
                $datos = [
                    "nombreperfil" => strtoupper( $_POST['nombreperfil'] ),
                    "Permisos" => $_POST['permisos']
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
        $insert = $this->modPerfil->insert($datos);
        foreach ($datos['Permisos'] as $key => $p) {
            $datos = [
                'idperfilpermiso' => $insert,
                'idmodulo' => $p
            ];
            $insertPermisos = $this->modPerfil->mdlInsertPermisos( $datos );
        }
        if (!$insert || !$insertPermisos) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar el perfil']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Perfil registrado con exito']);
    }

    public function actualizar($datos){
        if($this->request->getMethod() != 'post'){
            return redirect()->to(base_url());
        }
        $delete = $this->modPerfil->mdlDeletePermisos($_POST['id_perfil']);
        $update = $this->modPerfil->update( $_POST['id_perfil'], $datos );
        foreach ($datos['Permisos'] as $key => $p) {
            $datos = [
                'idperfilpermiso' => $_POST['id_perfil'],
                'idmodulo' => $p
            ];
            $insert = $this->modPerfil->mdlInsertPermisos( $datos );
        }
        if (!$insert || !$delete || !$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar el perfil']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Perfil actualizado con exito']);
    }

    public function delete_perfil(){
		if($this->request->isAjax()) {
            if ($_POST['item'] == 1) {
                return json_encode(['status' => 400, 'delete' => 0, 'msg' => 'No se puede eliminar este perfil. Perfil Administrador.']);
            }

            $perfil = $this->modPerfil->update( $_POST['item'], ['estadoperfil' => 0] );
            if ( !$perfil ) {
                return json_encode(['status' => 400, 'delete' => $perfil, 'msg' => 'Hubo un error al intentar eliminar el perfil']);
            }
            return json_encode(['status' => 200, 'delete' => $perfil, 'msg' => 'Perfil eliminado con exito']);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function disabled_perfil(){
		if($this->request->isAjax()) {
            $perfil = $this->modPerfil->find( $_POST['item'] );

            if ($_POST['item'] == 1) {
                return json_encode(['status' => 400, 'delete' => 0, 'msg' => 'No se puede deshabilitar este perfil. Perfil Administrador.']);
            }

            if ( $perfil['estadoperfil'] == 1 ) {
                $perfil = $this->modPerfil->update( $_POST['item'], ['estadoperfil' => 2] );
                return json_encode(['status' => 200, 'delete' => $perfil, 'msg' => 'Perfil desactivado con exito']);
            }else{
                $perfil = $this->modPerfil->update( $_POST['item'], ['estadoperfil' => 1] );
                return json_encode(['status' => 200, 'delete' => $perfil, 'msg' => 'Perfil activado con exito']);
            }
            return json_encode(['status' => 400, 'delete' => $perfil, 'msg' => 'Hubo un error al intentar deshabilidtar el perfil']);
		}else{
			return redirect()->to(base_url());
		}

    }
}
