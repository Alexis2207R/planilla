<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\TipoBonificacionModel;

class TipoBonificacion extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modTipobonificacion = new TipoBonificacionModel();
    }

    public function index()
    {
        return $this->ViewData('modules/tipobonificaciones', []);
    }

    public function list_tipobonificaciones()
    {
        if ($this->request->isAjax()) {
            $tipobonificaciones = $this->modTipobonificacion->getAllActive();;
            $data = ['tipobonificaciones' => $tipobonificaciones];
            return json_encode($data['tipobonificaciones']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_tipobonificacion()
    {
        if ($this->request->isAjax()) {
            $tipobonificacion = $this->modTipobonificacion->update($_POST['item'], ['estado_tipo_bonificacion' => 0]);
            if (!$tipobonificacion) {
                return json_encode(['status' => 400, 'delete' => $tipobonificacion, 'msg' => 'Hubo un error al intentar eliminar el Tipo de bonificacion']);
            }
            return json_encode(['status' => 200, 'delete' => $tipobonificacion, 'msg' => 'Tipo de bonificacion eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_tipobonificacion()
    {
        if ($this->request->isAjax()) {
            $tipobonificacion = $this->modTipobonificacion->find($_POST['item']);
            if ($tipobonificacion['estado_tipo_bonificacion'] == 1) {
                $tipobonificacion = $this->modTipobonificacion->update($_POST['item'], ['estado_tipo_bonificacion' => 2]);
                return json_encode(['status' => 200, 'disable' => $tipobonificacion, 'msg' => 'Tipo de bonificacion desactivado con exito']);
            } else {
                $tipobonificacion = $this->modTipobonificacion->update($_POST['item'], ['estado_tipo_bonificacion' => 1]);
                return json_encode(['status' => 200, 'disable' => $tipobonificacion, 'msg' => 'Tipo de bonificacion activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $tipobonificacion, 'msg' => 'Hubo un error al intentar deshabilidtar el Tipo de bonificacion']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function form()
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $this->validation->setRules([
            'nombre_tipo_bonificacion' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_tipo_bonificacion']) && !empty($_POST['id_tipo_bonificacion'])) {
                $datos = [
                    "nombre_tipo_bonificacion" => strtoupper($_POST['nombre_tipo_bonificacion'])
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    "nombre_tipo_bonificacion" => strtoupper($_POST['nombre_tipo_bonificacion'])
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_tipobonificacion()
    {
        if ($this->request->isAjax()) {
            $tipobonificacion = $this->modTipobonificacion->find($_POST['item']);
            if (!$tipobonificacion) {
                return json_encode(['status' => 400, 'edit' => $tipobonificacion, 'msg' => 'Hubo un error al intentar obtener el Tipo de bonificacion']);
            }
            return json_encode(['status' => 200, 'edit' => $tipobonificacion, 'msg' => 'Tipo de bonificacion eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modTipobonificacion->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar el Tipo de bonificacion']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Tipo de bonificacion registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modTipobonificacion->update($_POST['id_tipo_bonificacion'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar el Tipo de bonificacion']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Tipo de bonificacion actualizado con exito']);
    }


}
