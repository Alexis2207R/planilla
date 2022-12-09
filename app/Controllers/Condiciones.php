<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\CondicionModel;

class Condiciones extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modCondicion = new CondicionModel();
    }

    public function index()
    {
        return $this->ViewData('modules/condicion', []);
    }

    public function list_condiciones()
    {
        if ($this->request->isAjax()) {
            $condiciones = $this->modCondicion->mdListarCondiciones();;
            $data = ['condiciones' => $condiciones];
            return json_encode($data['condiciones']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_condicion()
    {
        if ($this->request->isAjax()) {
            $condicion = $this->modCondicion->update($_POST['item'], ['estado_condicion' => 0]);
            if (!$condicion) {
                return json_encode(['status' => 400, 'delete' => $condicion, 'msg' => 'Hubo un error al intentar eliminar la condición laboral']);
            }
            return json_encode(['status' => 200, 'delete' => $condicion, 'msg' => 'Condición laboral eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_condicion()
    {
        if ($this->request->isAjax()) {
            $condicion = $this->modCondicion->find($_POST['item']);
            if ($condicion['estado_condicion'] == 1) {
                $condicion = $this->modCondicion->update($_POST['item'], ['estado_condicion' => 2]);
                return json_encode(['status' => 200, 'disable' => $condicion, 'msg' => 'Condición laboral desactivado con exito']);
            } else {
                $condicion = $this->modCondicion->update($_POST['item'], ['estado_condicion' => 1]);
                return json_encode(['status' => 200, 'disable' => $condicion, 'msg' => 'Condición laboral activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $condicion, 'msg' => 'Hubo un error al intentar deshabilidtar el condición laboral']);
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
            'nombre_condicion' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_condicion']) && !empty($_POST['id_condicion'])) {
                $datos = [
                    "condicion" => strtoupper($_POST['nombre_condicion'])
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    "condicion" => strtoupper($_POST['nombre_condicion']),
                    'creacion_condicion' => date('Y-m-d H:i:s')
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_condicion()
    {
        if ($this->request->isAjax()) {
            $condicion = $this->modCondicion->find($_POST['item']);
            if (!$condicion) {
                return json_encode(['status' => 400, 'edit' => $condicion, 'msg' => 'Hubo un error al intentar obtener la condicion']);
            }
            return json_encode(['status' => 200, 'edit' => $condicion, 'msg' => 'Condicion eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modCondicion->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar la condición laboral']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Condición laboral registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modCondicion->update($_POST['id_condicion'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar la condición laboral']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Condición laboral actualizado con exito']);
    }
}
