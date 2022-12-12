<?php

namespace App\Controllers;

use App\Models\MesModel;
use CodeIgniter\Controller;

use App\Models\PagoModel;
use App\Models\PersonalModel;
use App\Models\PlanillaModel;

class Pagos extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modPago     = new PagoModel();
        $this->modPersonal = new PersonalModel();
        $this->modPlanilla = new PlanillaModel();
        $this->modMes      = new MesModel();
    }

    public function index()
    {
        $personales = $this->modPersonal->getAllActive();
        $planillas = $this->modPlanilla->getAllActive();
        $meses = $this->modMes->getAllActive();
        $data = [
            'personales' => $personales,
            'planillas'  => $planillas,
            'meses'      => $meses
        ];
        return $this->ViewData('modules/pago', $data);
    }

    public function list_pagos()
    {
        if ($this->request->isAjax()) {
            $pagos = $this->modPago->mdListarPagos();;
            $data = ['pagos' => $pagos];
            return json_encode($data['pagos']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_pago()
    {
        if ($this->request->isAjax()) {
            $pago = $this->modPago->update($_POST['item'], ['estado_pago' => 0]);
            if (!$pago) {
                return json_encode(['status' => 400, 'delete' => $pago, 'msg' => 'Hubo un error al intentar eliminar el pago']);
            }
            return json_encode(['status' => 200, 'delete' => $pago, 'msg' => 'Pago eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_pago()
    {
        if ($this->request->isAjax()) {
            $pago = $this->modPago->find($_POST['item']);
            if ($pago['estado_pago'] == 1) {
                $pago = $this->modPago->update($_POST['item'], ['estado_pago' => 2]);
                return json_encode(['status' => 200, 'disable' => $pago, 'msg' => 'Pago desactivado con exito']);
            } else {
                $pago = $this->modPago->update($_POST['item'], ['estado_pago' => 1]);
                return json_encode(['status' => 200, 'disable' => $pago, 'msg' => 'Pago activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $pago, 'msg' => 'Hubo un error al intentar deshabilidtar el pago']);
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
            'id_mes'       => 'required',
            'id_personal'  => 'required',
            'id_planilla'  => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_pago']) && !empty($_POST['id_pago'])) {
                $datos = [
                    'id_pago'        => $_POST['id_pago'],
                    'id_personal'    => $_POST['id_personal'],
                    'id_planilla'    => $_POST['id_planilla'],
                    'id_mes'         => $_POST['id_mes'],
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    'id_personal'  => $_POST['id_personal'],
                    'id_planilla'  => $_POST['id_planilla'],
                    'id_mes'       => $_POST['id_mes'],
                    'fecha_creacion' => date('Y-m-d H:i:s')
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_pago()
    {
        if ($this->request->isAjax()) {
            $pago = $this->modPago->find($_POST['item']);
            if (!$pago) {
                return json_encode(['status' => 400, 'edit' => $pago, 'msg' => 'Hubo un error al intentar obtener la pago']);
            }
            return json_encode(['status' => 200, 'edit' => $pago, 'msg' => 'Pago eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modPago->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar la pago']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Pago registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modPago->update($_POST['id_pago'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar la pago']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Pago actualizado con exito']);
    }

}
