<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\DescuentoModel;
use App\Models\TipoDescuentoModel;

class Descuentos extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modDescuento = new DescuentoModel();
        $this->modTipoDescuento = new TipoDescuentoModel();
    }

    public function index()
    {
        $tipoDescuento = $this->modTipoDescuento->getAllActive();
        $data = ['tipoDescuentos' => $tipoDescuento];
        return $this->ViewData('modules/descuento', $data);
    }

    public function list_descuentos()
    {
        if ($this->request->isAjax()) {
            $descuentos = $this->modDescuento->mdListarDescuentos();;
            $data = ['descuentos' => $descuentos];
            return json_encode($data['descuentos']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_descuento()
    {
        if ($this->request->isAjax()) {
            $descuento = $this->modDescuento->update($_POST['item'], ['estado_descuento' => 0]);
            if (!$descuento) {
                return json_encode(['status' => 400, 'delete' => $descuento, 'msg' => 'Hubo un error al intentar eliminar el descuento']);
            }
            return json_encode(['status' => 200, 'delete' => $descuento, 'msg' => 'Descuento eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_descuento()
    {
        if ($this->request->isAjax()) {
            $descuento = $this->modDescuento->find($_POST['item']);
            if ($descuento['estado_descuento'] == 1) {
                $descuento = $this->modDescuento->update($_POST['item'], ['estado_descuento' => 2]);
                return json_encode(['status' => 200, 'disable' => $descuento, 'msg' => 'Descuento desactivado con exito']);
            } else {
                $descuento = $this->modDescuento->update($_POST['item'], ['estado_descuento' => 1]);
                return json_encode(['status' => 200, 'disable' => $descuento, 'msg' => 'Descuento activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $descuento, 'msg' => 'Hubo un error al intentar deshabilidtar el descuento']);
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
            'nombre_descuento'    => 'required',
            'id_tipo_descuento'   => 'required',
            'cantidad_descuento'  => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_descuento']) && !empty($_POST['id_descuento'])) {
                $datos = [
                    "id_descuento"       => $_POST['id_descuento'],
                    "nombre_descuento"   => strtoupper($_POST['nombre_descuento']),
                    "id_tipo_descuento"  => $_POST['id_tipo_descuento'],
                    "cantidad_descuento" => $_POST['cantidad_descuento'],
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    "nombre_descuento"   => strtoupper($_POST['nombre_descuento']),
                    "id_tipo_descuento"  => $_POST['id_tipo_descuento'],
                    "cantidad_descuento" => $_POST['cantidad_descuento'],
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_descuento()
    {
        if ($this->request->isAjax()) {
            $descuento = $this->modDescuento->find($_POST['item']);
            if (!$descuento) {
                return json_encode(['status' => 400, 'edit' => $descuento, 'msg' => 'Hubo un error al intentar obtener la descuento']);
            }
            return json_encode(['status' => 200, 'edit' => $descuento, 'msg' => 'Descuento eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modDescuento->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar la descuento']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Descuento registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modDescuento->update($_POST['id_descuento'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar la descuento']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Descuento actualizado con exito']);
    }
}
