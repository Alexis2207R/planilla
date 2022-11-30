<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\RemuneracionModel;



class Remuneracion extends Controller{
    public function __construct(){
        $this->validation =  \Config\Services::validation();
        $this->modRemuneracion = new RemuneracionModel();
    }

    public function index(){
        $remuneracion = $this->modRemuneracion->mdlListarRemuneracion();
        $data = [ 'Remuneracion' => $remuneracion ];
        return $this->ViewData('modules/remuneracion', $data);
    }

    public function list_niveles(){
		if($this->request->isAjax()) {
            $remuneracion = $this->modRemuneracion->mdlListarRemuneracion();
            $data = [ 'Remuneracion' => $remuneracion ];
            return json_encode($data['Remuneracion']);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function single_nivel(){
        if($this->request->isAjax()) {
            $remuneracion = $this->modRemuneracion->find($_POST['item']);
            $data = ['Remunerado' => $remuneracion];
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
        // return json_encode($_POST);die;
        // Validar post
        $this->validation->setRules([
            'nivel' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if ( isset( $_POST['id_remuneracion'] ) && !empty(  $_POST['id_remuneracion'] ) ) {
                $datos = [
                    "nivel" => strtoupper( $_POST['nivel'] )
                ];
                $update = $this->actualizar( $datos );
                return $update;
            }else{
                $datos = [
                    "nivel" => strtoupper( $_POST['nivel'] )
                ];
                // return json_encode($datos);die;
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
        $insert = $this->modRemuneracion->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar al usuario']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Nivel remunerativo registrado con exito']);
    }

    public function actualizar($datos){
        if($this->request->getMethod() != 'post'){
            return redirect()->to(base_url());
        }
        $update = $this->modRemuneracion->update( $_POST['id_remuneracion'], $datos );
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actualizar el nivel']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Nivel remunerativo actualizado con exito']);
    }

    public function delete_nivel(){
		if($this->request->isAjax()) {
            $remuneracion = $this->modRemuneracion->update( $_POST['item'], ['estado_nivel' => 0] );
            if ( !$remuneracion ) {
                return json_encode(['status' => 400, 'delete' => $remuneracion, 'msg' => 'Hubo un error al intentar eliminar el nivel']);
            }
            return json_encode(['status' => 200, 'delete' => $remuneracion, 'msg' => 'Nivel renumerativo eliminado con exito']);
		}else{
			return redirect()->to(base_url());
		}
    }
}
