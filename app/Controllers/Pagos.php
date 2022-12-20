<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\MesModel;
use App\Models\PagoModel;
use App\Models\PersonalModel;
use App\Models\PlanillaModel;
use App\Models\BonificacionModel;
use App\Models\DescuentoModel;
use App\Models\PagoBonificacionModel;
use App\Models\PagoDescuentoModel;

class Pagos extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modPago             = new PagoModel();
        $this->modPersonal         = new PersonalModel();
        $this->modPlanilla         = new PlanillaModel();
        $this->modMes              = new MesModel();
        $this->modBonificacion     = new BonificacionModel();
        $this->modDescuento        = new DescuentoModel();
        $this->modPagoBonificacion = new PagoBonificacionModel();
        $this->modPagoDescuento    = new PagoDescuentoModel();
    }

    public function index()
    {
        $personales = $this->modPersonal->getAllActive();
        $planillas = $this->modPlanilla->getAllActive();
        $meses = $this->modMes->getAllActive();
        $bonificaciones = $this->modBonificacion->getAllActive();
        $descuentos = $this->modDescuento->getAllActive();
        $data = [
            'personales'     => $personales,
            'planillas'      => $planillas,
            'meses'          => $meses,
            'bonificaciones' => $bonificaciones,
            'descuentos'     => $descuentos
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
            $descuentos      = explode(',', $_POST['descuentos']);
            $cdescuentos     = explode(',', $_POST['cdescuentos']);
            $bonificaciones  = explode(',', $_POST['bonificaciones']);
            $cbonificaciones = explode(',', $_POST['cbonificaciones']);
            $totalIngreso = $this->getTotalIngreso($cbonificaciones);
            $totalEgreso  = $this->getTotalEgreso($cdescuentos);

            if (isset($_POST['id_pago']) && !empty($_POST['id_pago'])) {
                $datos = [
                    'id_pago'         => $_POST['id_pago'],
                    'id_personal'     => $_POST['id_personal'],
                    'id_planilla'     => $_POST['id_planilla'],
                    'id_mes'          => $_POST['id_mes'],
                    'total_ingreso'   => $totalIngreso,
                    'total_egreso'    => $totalEgreso,
                    'total_neto'      => $totalIngreso - $totalEgreso,
                    'descuentos'      => $descuentos,
                    'cdescuentos'     => $cdescuentos,
                    'bonificaciones'  => $bonificaciones,
                    'cbonificaciones' => $cbonificaciones

                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    'id_personal'     => $_POST['id_personal'],
                    'id_planilla'     => $_POST['id_planilla'],
                    'id_mes'          => $_POST['id_mes'],
                    'total_ingreso'   => $totalIngreso,
                    'total_egreso'    => $totalEgreso,
                    'total_neto'      => $totalIngreso - $totalEgreso,
                    'fecha_creacion'  => date('Y-m-d H:i:s'),
                    'descuentos'      => $descuentos,
                    'cdescuentos'     => $cdescuentos,
                    'bonificaciones'  => $bonificaciones,
                    'cbonificaciones' => $cbonificaciones
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
            $bonificaciones = $this->modPagoBonificacion->mdVerDePago($_POST['item']);
            $descuentos = $this->modPagoDescuento->mdVerDePago($_POST['item']);
            $data = [
                'pago'           => $pago,
                'bonificaciones' => $bonificaciones,
                'descuentos'     => $descuentos
            ];
            if (!$pago) {
                return json_encode(['status' => 400, 'edit' => $pago, 'msg' => 'Hubo un error al intentar obtener la pago']);
            }
            return json_encode(['status' => 200, 'edit' => $data, 'msg' => 'Pago eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $descuentos      = $datos['descuentos'];
        $cdescuentos     = $datos['cdescuentos'];
        $bonificaciones  = $datos['bonificaciones'];
        $cbonificaciones = $datos['cbonificaciones'];
        unset($datos['descuentos']);
        unset($datos['cdescuentos']);
        unset($datos['bonificaciones']);
        unset($datos['cbonificaciones']);
        $insert = $this->modPago->insert($datos);
        $this->insertPagoBonificacion($insert, $bonificaciones, $cbonificaciones);
        $this->insertPagoDescuento($insert, $descuentos, $cdescuentos);
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
        $descuentos      = $datos['descuentos'];
        $cdescuentos     = $datos['cdescuentos'];
        $bonificaciones  = $datos['bonificaciones'];
        $cbonificaciones = $datos['cbonificaciones'];
        unset($datos['descuentos']);
        unset($datos['cdescuentos']);
        unset($datos['bonificaciones']);
        unset($datos['cbonificaciones']);

        $update = $this->modPago->update($_POST['id_pago'], $datos);

        // Para editar las relaciones entre pago y descuentos - bonificaciones, elimino sus anteriores :D
        $this->banPagoDescuento($_POST['id_pago']);
        $this->banPagoBonificacion($_POST['id_pago']);
        $this->insertPagoBonificacion($_POST['id_pago'], $bonificaciones, $cbonificaciones);
        $this->insertPagoDescuento($_POST['id_pago'], $descuentos, $cdescuentos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar la pago']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Pago actualizado con exito']);
    }

    private function getTotalIngreso($bonificaciones)
    {
        $ingreso = 0.0;
        foreach ($bonificaciones as $bonificacion) {
            $ingreso += $bonificacion;
        }
        return $ingreso;
    }

    private function getTotalEgreso($descuentos)
    {
        $egreso = 0.0;
        foreach ($descuentos as $descuento) {
            $egreso += $descuento;
        }
        return $egreso;
    }

    private function insertPagoBonificacion($idPago, $bonificaciones, $cbonificaciones)
    {
        for ($i = 0; $i < count($bonificaciones); $i++)
        {
            $id       = $bonificaciones[$i];
            $cantidad = $cbonificaciones[$i];
            $data = [
                'id_pago'                    => $idPago,
                'id_bonificacion'            => $id,
                'cantidad_pago_bonificacion' => $cantidad
            ];
            $this->modPagoBonificacion->insert($data);
        }
    }

    private function insertPagoDescuento($idPago, $descuentos, $cdescuentos)
    {
        for ($i = 0; $i < count($descuentos); $i++) {
            $id       = $descuentos[$i];
            $cantidad = $cdescuentos[$i];
            $data = [
                'id_pago'                 => $idPago,
                'id_descuento'            => $id,
                'cantidad_pago_descuento' => $cantidad
            ];
            $this->modPagoDescuento->insert($data);
        }
    }

    private function banPagoBonificacion($idPago)
    {
        $this->modPagoBonificacion->banFromPago($idPago);
    }

    private function banPagoDescuento($idPago)
    {
        $this->modPagoDescuento->banFromPago($idPago);
    }


}
