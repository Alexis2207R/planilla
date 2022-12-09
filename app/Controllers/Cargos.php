<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\CargoModel;

class Cargos extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modCargo = new CargoModel();
    }

    public function index()
    {
        return $this->ViewData('modules/cargo', []);
    }

    public function list_cargos()
    {
        if ($this->request->isAjax()) {
            $cargos = $this->modCargo->mdListarCargos();;
            $data = ['cargos' => $cargos];
            return json_encode($data['cargos']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_cargo()
    {
        if ($this->request->isAjax()) {
            $cargo = $this->modCargo->update($_POST['item'], ['estado_cargo' => 0]);
            if (!$cargo) {
                return json_encode(['status' => 400, 'delete' => $cargo, 'msg' => 'Hubo un error al intentar eliminar el cargo laboral']);
            }
            return json_encode(['status' => 200, 'delete' => $cargo, 'msg' => 'Cargo laboral eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_cargo()
    {
        if ($this->request->isAjax()) {
            $cargo = $this->modCargo->find($_POST['item']);
            if ($cargo['estado_cargo'] == 1) {
                $cargo = $this->modCargo->update($_POST['item'], ['estado_cargo' => 2]);
                return json_encode(['status' => 200, 'disable' => $cargo, 'msg' => 'Cargo laboral desactivado con exito']);
            } else {
                $cargo = $this->modCargo->update($_POST['item'], ['estado_cargo' => 1]);
                return json_encode(['status' => 200, 'disable' => $cargo, 'msg' => 'Cargo laboral activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $cargo, 'msg' => 'Hubo un error al intentar deshabilidtar el cargo laboral']);
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
            'nombre_cargo' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_cargo']) && !empty($_POST['id_cargo'])) {
                $datos = [
                    "nombre_cargo" => strtoupper($_POST['nombre_cargo'])
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    "nombre_cargo" => strtoupper($_POST['nombre_cargo'])
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_cargo()
    {
        if ($this->request->isAjax()) {
            $cargo = $this->modCargo->find($_POST['item']);
            if (!$cargo) {
                return json_encode(['status' => 400, 'edit' => $cargo, 'msg' => 'Hubo un error al intentar obtener el cargo']);
            }
            return json_encode(['status' => 200, 'edit' => $cargo, 'msg' => 'Cargo eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modCargo->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar el cargo laboral']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Cargo laboral registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modCargo->update($_POST['id_cargo'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar el cargo laboral']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Cargo laboral actualizado con exito']);
    }

}
