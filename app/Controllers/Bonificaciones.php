<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\BonificacionModel;
use App\Models\TipoBonificacionModel;

class Bonificaciones extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modBonificacion = new BonificacionModel();
        $this->modTipoBonificacion = new TipoBonificacionModel();
    }

    public function index()
    {
        $tipoBonificacion = $this->modTipoBonificacion->getAllActive();
        $data = ['tipoBonificaciones' => $tipoBonificacion];
        return $this->ViewData('modules/bonificacion', $data);
    }

    public function list_bonificaciones()
    {
        if ($this->request->isAjax()) {
            $bonificaciones = $this->modBonificacion->mdListarBonificaciones();;
            $data = ['bonificaciones' => $bonificaciones];
            return json_encode($data['bonificaciones']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_bonificacion()
    {
        if ($this->request->isAjax()) {
            $bonificacion = $this->modBonificacion->update($_POST['item'], ['estado_bonificacion' => 0]);
            if (!$bonificacion) {
                return json_encode(['status' => 400, 'delete' => $bonificacion, 'msg' => 'Hubo un error al intentar eliminar la bonificación']);
            }
            return json_encode(['status' => 200, 'delete' => $bonificacion, 'msg' => 'Bonificación eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_bonificacion()
    {
        if ($this->request->isAjax()) {
            $bonificacion = $this->modBonificacion->find($_POST['item']);
            if ($bonificacion['estado_bonificacion'] == 1) {
                $bonificacion = $this->modBonificacion->update($_POST['item'], ['estado_bonificacion' => 2]);
                return json_encode(['status' => 200, 'disable' => $bonificacion, 'msg' => 'Bonificacion desactivado con exito']);
            } else {
                $bonificacion = $this->modBonificacion->update($_POST['item'], ['estado_bonificacion' => 1]);
                return json_encode(['status' => 200, 'disable' => $bonificacion, 'msg' => 'Bonificacion activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $bonificacion, 'msg' => 'Hubo un error al intentar deshabilidtar al bonificacion']);
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
            'nombre_bonificacion'    => 'required',
            'id_tipo_bonificacion'   => 'required',
            'cantidad_bonificacion'  => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_bonificacion']) && !empty($_POST['id_bonificacion'])) {
                $datos = [
                    "id_bonificacion"       => $_POST['id_bonificacion'],
                    "nombre_bonificacion"   => strtoupper($_POST['nombre_bonificacion']),
                    "id_tipo_bonificacion"  => $_POST['id_tipo_bonificacion'],
                    "cantidad_bonificacion" => $_POST['cantidad_bonificacion'],
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    "nombre_bonificacion"   => strtoupper($_POST['nombre_bonificacion']),
                    "id_tipo_bonificacion"  => $_POST['id_tipo_bonificacion'],
                    "cantidad_bonificacion" => $_POST['cantidad_bonificacion'],
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_bonificacion()
    {
        if ($this->request->isAjax()) {
            $bonificacion = $this->modBonificacion->find($_POST['item']);
            if (!$bonificacion) {
                return json_encode(['status' => 400, 'edit' => $bonificacion, 'msg' => 'Hubo un error al intentar obtener la bonificación']);
            }
            return json_encode(['status' => 200, 'edit' => $bonificacion, 'msg' => 'Bonificación eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modBonificacion->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar la bonificación']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Bonificación registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modBonificacion->update($_POST['id_bonificacion'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar la bonificación']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Bonificación actualizado con exito']);
    }

}
