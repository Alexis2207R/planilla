<?php

namespace App\Controllers;

use App\Models\RemuneracionModel;
use CodeIgniter\Controller;

class Nivelremunerativo extends Controller
{
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->modRemuneracion = new RemuneracionModel();
    }

    public function index()
    {
        return $this->ViewData('modules/remuneracion', []);
    }

    public function list_remuneraciones()
    {
        if ($this->request->isAjax()) {
            $remuneraciones = $this->modRemuneracion->mdListarRemuneraciones();
            $data = ['remuneraciones' => $remuneraciones];
            return json_encode($data['remuneraciones']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_remuneracion()
    {
        if ($this->request->isAjax()) {
            $remuneracion = $this->modRemuneracion->update($_POST['item'], ['estado_nivel' => 0]);
            if (!$remuneracion) {
                return json_encode(['status' => 400, 'delete' => $remuneracion, 'msg' => 'Hubo un error al intentar eliminar el nivel remunerativo']);
            }
            return json_encode(['status' => 200, 'delete' => $remuneracion, 'msg' => 'Nivel Remunerativo eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_remuneracion()
    {
        if ($this->request->isAjax()) {
            $remuneracion = $this->modRemuneracion->find($_POST['item']);
            if ($remuneracion['estado_nivel'] == 1) {
                $remuneracion = $this->modRemuneracion->update($_POST['item'], ['estado_nivel' => 2]);
                return json_encode(['status' => 200, 'disable' => $remuneracion, 'msg' => 'Nivel Remunerativo desactivado con exito']);
            } else {
                $remuneracion = $this->modRemuneracion->update($_POST['item'], ['estado_nivel' => 1]);
                return json_encode(['status' => 200, 'disable' => $remuneracion, 'msg' => 'Nivel Remunerativo activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $remuneracion, 'msg' => 'Hubo un error al intentar deshabilidtar el Nivel Remunerativo']);
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
            'nivel' => 'required',
            'fecha_registro' => 'required',
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_remuneracion']) && !empty($_POST['id_remuneracion'])) {
                $datos = [
                    "id_remuneracion" => $_POST['id_remuneracion'],
                    "nivel" => strtoupper($_POST['nivel']),
                    "fecha_registro" => $_POST['fecha_registro'],
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    "nivel" => strtoupper($_POST['nivel']),
                    "fecha_registro" => $_POST['fecha_registro'],
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modRemuneracion->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar el Nivel Remunerativo']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Nivel Remunerativo registrado con exito']);
    }

    public function edit_remuneracion()
    {
        if ($this->request->isAjax()) {
            $remuneracion = $this->modRemuneracion->find($_POST['item']);
            if (!$remuneracion) {
                return json_encode(['status' => 400, 'edit' => $remuneracion, 'msg' => 'Hubo un error al intentar obtener el Nivel Remunerativo']);
            }
            return json_encode(['status' => 200, 'edit' => $remuneracion, 'msg' => 'Nivel Remunerativo eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }


    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modRemuneracion->update($_POST['id_remuneracion'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actualizar el Nivel Remunerativo']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Nivel Remunerativo actualizado con exito']);
    }


}
