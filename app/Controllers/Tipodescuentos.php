<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\TipoDescuentoModel;

class Tipodescuentos extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modTipodescuento = new TipoDescuentoModel();
    }

    public function index()
    {
        return $this->ViewData('modules/tipodescuentos', []);
    }

    public function list_tipodescuentos()
    {
        if ($this->request->isAjax()) {
            $tipodescuentos = $this->modTipodescuento->getAllActive();;
            $data = ['tipodescuentos' => $tipodescuentos];
            return json_encode($data['tipodescuentos']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_tipodescuento()
    {
        if ($this->request->isAjax()) {
            $tipodescuento = $this->modTipodescuento->update($_POST['item'], ['estado_tipo_descuento' => 0]);
            if (!$tipodescuento) {
                return json_encode(['status' => 400, 'delete' => $tipodescuento, 'msg' => 'Hubo un error al intentar eliminar el tipo de descuento']);
            }
            return json_encode(['status' => 200, 'delete' => $tipodescuento, 'msg' => 'Tipo de descuento eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_tipodescuento()
    {
        if ($this->request->isAjax()) {
            $tipodescuento = $this->modTipodescuento->find($_POST['item']);
            if ($tipodescuento['estado_tipo_descuento'] == 1) {
                $tipodescuento = $this->modTipodescuento->update($_POST['item'], ['estado_tipo_descuento' => 2]);
                return json_encode(['status' => 200, 'disable' => $tipodescuento, 'msg' => 'Tipo de descuento desactivado con exito']);
            } else {
                $tipodescuento = $this->modTipodescuento->update($_POST['item'], ['estado_tipo_descuento' => 1]);
                return json_encode(['status' => 200, 'disable' => $tipodescuento, 'msg' => 'Tipo de descuento activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $tipodescuento, 'msg' => 'Hubo un error al intentar deshabilidtar el tipo de descuento']);
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
            'nombre_tipo_descuento' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_tipo_descuento']) && !empty($_POST['id_tipo_descuento'])) {
                $datos = [
                    "nombre_tipo_descuento" => strtoupper($_POST['nombre_tipo_descuento'])
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    "nombre_tipo_descuento" => strtoupper($_POST['nombre_tipo_descuento'])
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_tipodescuento()
    {
        if ($this->request->isAjax()) {
            $tipodescuento = $this->modTipodescuento->find($_POST['item']);
            if (!$tipodescuento) {
                return json_encode(['status' => 400, 'edit' => $tipodescuento, 'msg' => 'Hubo un error al intentar obtener el tipo de descuento']);
            }
            return json_encode(['status' => 200, 'edit' => $tipodescuento, 'msg' => 'Tipo de descuento eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modTipodescuento->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar el tipo de descuento']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Tipo de descuento registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modTipodescuento->update($_POST['id_tipo_descuento'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actualizar el tipo de descuento']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Tipo de descuento actualizado con exito']);
    }






}
