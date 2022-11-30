<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\PersonalModel;
use App\Models\RemuneracionModel;
use App\Models\CondicionModel;


class Personal extends Controller{
    public function __construct(){
        $this->validation =  \Config\Services::validation();
        $this->modPersonal = new PersonalModel();
        $this->modRemuneracion = new RemuneracionModel();
        $this->modCondicion = new CondicionModel();
    }

    public function index(){
        $personal = $this->modPersonal->mdlListarPersonal();
        $remuneracion = $this->modRemuneracion->mdlListarRemuneracion();
        $condicion = $this->modCondicion->mdlListarCondicion();
        $data = [ 
            'listaPersonal' => $personal,
            'listaRemuneracion' => $remuneracion,
            'listaCondicion' => $condicion
        ];
        return $this->ViewData('modules/personal', $data);
    }

    public function list_personal(){
		if($this->request->isAjax()) {
            $personal = $this->modPersonal->mdlListarPersonal();
            $data = [ 'Personal' => $personal ];
            return json_encode($data['Personal']);
		}else{
			return redirect()->to(base_url());
		}
    }

    public function single_personal(){
        if($this->request->isAjax()) {
            $personal = $this->modPersonal->find($_POST['item']);
            $data = ['Personal' => $personal];
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
            'dni_personal' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if ( isset( $_POST['id_personal'] ) && !empty(  $_POST['id_personal'] ) ) {
                // $datos = [
                //     "condicion" => strtoupper( $_POST['condicion'] )
                // ];
                // $update = $this->actualizar( $datos );
                // return $update;
            }else{
                $datos = [
                    'nombre_personal' => $_POST['nombre_personal'], 
                    'paterno_personal' => $_POST['paterno_personal'], 
                    'materno_personal' => $_POST['materno_personal'], 
                    'dni_personal' => $_POST['dni_personal'], 
                    'sexo_personal' => $_POST['sexo_personal'], 
                    'nivel_remuneracion' => $_POST['nivel_remuneracion'], 
                    'condicion_laboral' => $_POST['condicion_laboral'],
                    'ubicacion_dpt' => $_POST['ubicacion_dpt'], 
                    'ubicacion_prov' => $_POST['ubicacion_prov'], 
                    'ubicacion_dist' => $_POST['ubicacion_dist'], 
                    'direccion_personal' => $_POST['direccion_personal'], 
                    'sueldo_personal' => $_POST['sueldo_personal'], 
                    'incentivo_personal' => $_POST['incentivo_personal'], 
                    'costo_dia' => $_POST['costo_dia'], 
                    'costo_hora' => $_POST['costo_hora'], 
                    'costo_minuto' => $_POST['costo_minuto'], 
                    'fecha_registro' => $this->getDate()
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
        $insert = $this->modPersonal->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar al personal']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Personal registrado con exito']);
    }

    // public function actualizar($datos){
    //     if($this->request->getMethod() != 'post'){
    //         return redirect()->to(base_url());
    //     }
    //     $update = $this->modPersonal->update( $_POST['id_condicion'], $datos );
    //     if (!$update) {
    //         return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actualizar la condición laboral']);
    //     }
    //     return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Condición laboral actualizado con exito']);
    // }

    // public function delete_condicion(){
	// 	if($this->request->isAjax()) {
    //         $personal = $this->modPersonal->update( $_POST['item'], ['estado_condicion' => 0] );
    //         if ( !$personal ) {
    //             return json_encode(['status' => 400, 'delete' => $personal, 'msg' => 'Hubo un error al intentar eliminar la condición']);
    //         }
    //         return json_encode(['status' => 200, 'delete' => $personal, 'msg' => 'Condición laboral eliminado con exito']);
	// 	}else{
	// 		return redirect()->to(base_url());
	// 	}
    // }
}
