<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\TipobonificacionModel;


class Tipobonificacion extends Controller{

    public function index(){
        $TipobonificacionModel = new TipobonificacionModel();
        $tipobonificaciones = $TipobonificacionModel -> getTipobonificaciones();
        // var_dump($condiciones); die;
        return view('modules/tipobonificaciones.php', ["tipobonificaciones" => $tipobonificaciones]);
    }

    public function create(){
        $data = array(
                    'condicion'             => $_POST['nombre_condicion'],
                    'creacion_condicion'    => $_POST['creacion_condicion'],
                    );
        // var_dump($data); die;
        $TipobonificacionModel = new TipobonificacionModel();
        $condicion = $TipobonificacionModel -> insert($data);
        return redirect() -> to(base_url().'/condicion');
    }

    public function list_condicion(){
		if($this->request->isAjax()) {
            $condicion = $this->modCondicion->mdlListarCondicion();
            $data = [ 'Condicion' => $condicion ];
            return json_encode($data['Condicion']);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function single_condicion(){
        if($this->request->isAjax()) {
            $condicion = $this->modCondicion->find($_POST['item']);
            $data = ['CondicionSingle' => $condicion];
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
            'condicion' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if ( isset( $_POST['id_condicion'] ) && !empty(  $_POST['id_condicion'] ) ) {
                $datos = [
                    "condicion" => strtoupper( $_POST['condicion'] )
                ];
                $update = $this->actualizar( $datos );
                return $update;
            }else{
                $datos = [
                    "condicion" => strtoupper( $_POST['condicion'] )
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
        $insert = $this->modCondicion->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar la condición laboral']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Condición laboral registrado con exito']);
    }

    public function actualizar($datos){
        if($this->request->getMethod() != 'post'){
            return redirect()->to(base_url());
        }
        $update = $this->modCondicion->update( $_POST['id_condicion'], $datos );
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actualizar la condición laboral']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Condición laboral actualizado con exito']);
    }

    public function delete_condicion(){
		if($this->request->isAjax()) {
            $condicion = $this->modCondicion->update( $_POST['item'], ['estado_condicion' => 0] );
            if ( !$condicion ) {
                return json_encode(['status' => 400, 'delete' => $condicion, 'msg' => 'Hubo un error al intentar eliminar la condición']);
            }
            return json_encode(['status' => 200, 'delete' => $condicion, 'msg' => 'Condición laboral eliminado con exito']);
		}else{
			return redirect()->to(base_url());
		}
    }
}
