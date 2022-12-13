<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\RegimenModel;

class Regimenes extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modRegimen = new RegimenModel();
    }

    public function index()
    {
        return $this->ViewData('modules/regimen', []);
    }

    public function list_regimenes()
    {
        if ($this->request->isAjax()) {
            $regimenes = $this->modRegimen->mdListarRegimenes();;
            $data = ['regimenes' => $regimenes];
            return json_encode($data['regimenes']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_regimen()
    {
        if ($this->request->isAjax()) {
            $regimen = $this->modRegimen->update($_POST['item'], ['estado_regimen' => 0]);
            if (!$regimen) {
                return json_encode(['status' => 400, 'delete' => $regimen, 'msg' => 'Hubo un error al intentar eliminar el Regimen Pensional']);
            }
            return json_encode(['status' => 200, 'delete' => $regimen, 'msg' => 'Regimen Pensional eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_regimen()
    {
        if ($this->request->isAjax()) {
            $regimen = $this->modRegimen->find($_POST['item']);
            if ($regimen['estado_regimen'] == 1) {
                $regimen = $this->modRegimen->update($_POST['item'], ['estado_regimen' => 2]);
                return json_encode(['status' => 200, 'disable' => $regimen, 'msg' => 'Regimen Pensional desactivado con exito']);
            } else {
                $regimen = $this->modRegimen->update($_POST['item'], ['estado_regimen' => 1]);
                return json_encode(['status' => 200, 'disable' => $regimen, 'msg' => 'Regimen Pensional activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $regimen, 'msg' => 'Hubo un error al intentar deshabilidtar el Regimen Pensional']);
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
            'nombre_regimen' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_regimen']) && !empty($_POST['id_regimen'])) {
                $datos = [
                    "nombre_regimen" => strtoupper($_POST['nombre_regimen'])
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    "nombre_regimen" => strtoupper($_POST['nombre_regimen']),
                    'creacion_regimen' => date('Y-m-d H:i:s')
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_regimen()
    {
        if ($this->request->isAjax()) {
            $regimen = $this->modRegimen->find($_POST['item']);
            if (!$regimen) {
                return json_encode(['status' => 400, 'edit' => $regimen, 'msg' => 'Hubo un error al intentar obtener la regimen']);
            }
            return json_encode(['status' => 200, 'edit' => $regimen, 'msg' => 'regimen eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modRegimen->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar el Regimen Pensional']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Regimen Pensional registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modRegimen->update($_POST['id_regimen'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar el Regimen Pensional']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Regimen Pensional actualizado con exito']);
    }
}
