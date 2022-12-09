<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\TipoPlanillaModel;

class TipoPlanillas extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modTipoPlanilla = new TipoPlanillaModel();
    }

    public function index()
    {
        return $this->ViewData('modules/tipoPlanilla', []);
    }

    public function list_tipoPlanillas()
    {
        if ($this->request->isAjax()) {
            $tipoPlanillas = $this->modTipoPlanilla->mdListarTipoPlanillas();;
            $data = ['tipoPlanillas' => $tipoPlanillas];
            return json_encode($data['tipoPlanillas']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_tipoPlanilla()
    {
        if ($this->request->isAjax()) {
            $tipoPlanilla = $this->modTipoPlanilla->update($_POST['item'], ['estado_tipoPlanilla' => 0]);
            if (!$tipoPlanilla) {
                return json_encode(['status' => 400, 'delete' => $tipoPlanilla, 'msg' => 'Hubo un error al intentar eliminar el tipo de planilla']);
            }
            return json_encode(['status' => 200, 'delete' => $tipoPlanilla, 'msg' => 'Tipo planilla eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_tipoPlanilla()
    {
        if ($this->request->isAjax()) {
            $tipoPlanilla = $this->modTipoPlanilla->find($_POST['item']);
            if ($tipoPlanilla['estado_tipo_planilla'] == 1) {
                $tipoPlanilla = $this->modTipoPlanilla->update($_POST['item'], ['estado_tipo_planilla' => 2]);
                return json_encode(['status' => 200, 'disable' => $tipoPlanilla, 'msg' => 'Tipo planilla desactivado con exito']);
            } else {
                $tipoPlanilla = $this->modTipoPlanilla->update($_POST['item'], ['estado_tipo_planilla' => 1]);
                return json_encode(['status' => 200, 'disable' => $tipoPlanilla, 'msg' => 'Tipo planilla activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $tipoPlanilla, 'msg' => 'Hubo un error al intentar deshabilidtar el tipo planilla']);
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
            'nombre_tipo_planilla' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_tipo_planilla']) && !empty($_POST['id_tipo_planilla'])) {
                $datos = [
                    "nombre_tipo_planilla" => strtoupper($_POST['nombre_tipo_planilla'])
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    "nombre_tipo_planilla" => strtoupper($_POST['nombre_tipo_planilla'])
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_tipoPlanilla()
    {
        if ($this->request->isAjax()) {
            $tipoPlanilla = $this->modTipoPlanilla->find($_POST['item']);
            if (!$tipoPlanilla) {
                return json_encode(['status' => 400, 'edit' => $tipoPlanilla, 'msg' => 'Hubo un error al intentar obtener el tipo planilla']);
            }
            return json_encode(['status' => 200, 'edit' => $tipoPlanilla, 'msg' => 'Tipo planilla eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modTipoPlanilla->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar el tipo planilla']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Tipo planilla registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modTipoPlanilla->update($_POST['id_tipo_planilla'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar el tipoPlanilla laboral']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Tipo de planilla actualizado con exito']);
    }


}
