<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\BonificacionModel;
use App\Models\DescuentoModel;
use App\Models\PlanillaBonificacionModel;
use App\Models\PlanillaDescuentoModel;
use App\Models\PlanillaModel;
use App\Models\TipoPlanillaModel;
use App\Models\YearModel;

class Planillas extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modPlanilla             = new PlanillaModel();
        $this->modTipoPlanilla         = new TipoPlanillaModel();
        $this->modYear                 = new YearModel();
        $this->modBonificacion         = new BonificacionModel();
        $this->modDescuento            = new DescuentoModel();
        $this->modPlanillaBonificacion = new PlanillaBonificacionModel();
        $this->modPlanillaDescuento    = new PlanillaDescuentoModel();
    }

    public function index()
    {
        $tipoPlanilla = $this->modTipoPlanilla->getAllActive();
        $years = $this->modYear->getAllActive();
        $bonificaciones = $this->modBonificacion->getAllActive();
        $descuentos = $this->modDescuento->getAllActive();
        $data = ['tipoPlanillas'  => $tipoPlanilla,
                 'years'          => $years,
                 'bonificaciones' => $bonificaciones,
                 'descuentos'     => $descuentos];
        return $this->ViewData('modules/planilla', $data);
    }

    public function list_planillas()
    {
        if ($this->request->isAjax()) {
            $planillas = $this->modPlanilla->mdListarPlanillas();;
            $data = ['planillas' => $planillas];
            return json_encode($data['planillas']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_planilla()
    {
        if ($this->request->isAjax()) {
            $planilla = $this->modPlanilla->update($_POST['item'], ['estado_planilla' => 0]);
            if (!$planilla) {
                return json_encode(['status' => 400, 'delete' => $planilla, 'msg' => 'Hubo un error al intentar eliminar el planilla']);
            }
            return json_encode(['status' => 200, 'delete' => $planilla, 'msg' => 'Planilla eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_planilla()
    {
        if ($this->request->isAjax()) {
            $planilla = $this->modPlanilla->find($_POST['item']);
            if ($planilla['estado_planilla'] == 1) {
                $planilla = $this->modPlanilla->update($_POST['item'], ['estado_planilla' => 2]);
                return json_encode(['status' => 200, 'disable' => $planilla, 'msg' => 'Planilla desactivado con exito']);
            } else {
                $planilla = $this->modPlanilla->update($_POST['item'], ['estado_planilla' => 1]);
                return json_encode(['status' => 200, 'disable' => $planilla, 'msg' => 'Planilla activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $planilla, 'msg' => 'Hubo un error al intentar deshabilidtar el planilla']);
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
            'numero_planilla'    => 'required',
            'id_tipo_planilla'   => 'required',
            'id_year_planilla'   => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            $descuentos     = explode(',', $_POST['id_descuentos']);
            $bonificaciones = explode(',', $_POST['id_bonificaciones']);
            if (isset($_POST['id_planilla']) && !empty($_POST['id_planilla'])) {
                $datos = [
                    'id_planilla'       => $_POST['id_planilla'],
                    'numero_planilla'   => strtoupper($_POST['numero_planilla']),
                    'id_tipo_planilla'  => $_POST['id_tipo_planilla'],
                    'id_year_planilla'  => $_POST['id_year_planilla'],
                    'descuentos'        => $descuentos,
                    'bonificaciones'    => $bonificaciones
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    'numero_planilla'   => strtoupper($_POST['numero_planilla']),
                    'id_tipo_planilla'  => $_POST['id_tipo_planilla'],
                    'id_year_planilla'  => $_POST['id_year_planilla'],
                    'descuentos'        => $descuentos,
                    'bonificaciones'    => $bonificaciones
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_planilla()
    {
        if ($this->request->isAjax()) {
            $planilla = $this->modPlanilla->find($_POST['item']);
            if (!$planilla) {
                return json_encode(['status' => 400, 'edit' => $planilla, 'msg' => 'Hubo un error al intentar obtener la planilla']);
            }
            return json_encode(['status' => 200, 'edit' => $planilla, 'msg' => 'Planilla eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $descuentos     = $datos['descuentos'];
        $bonificaciones = $datos['bonificaciones'];
        unset($datos['descuentos']);
        unset($datos['bonificaciones']);
        $insert = $this->modPlanilla->insert($datos);
        $this->insertPlanillaDescuento($insert, $descuentos);
        $this->insertPlanillaBonificacion($insert, $bonificaciones);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar la planilla']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Planilla registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modPlanilla->update($_POST['id_planilla'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar la planilla']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Planilla actualizado con exito']);
    }

    private function insertPlanillaDescuento($idPlanilla, $descuentos)
    {
        foreach ($descuentos as $descuento)
        {
            $data = [
                'id_planilla'  => $idPlanilla,
                'id_descuento' => $descuento
            ];
            $this->modPlanillaDescuento->insert($data);
        }
    }

    private function insertPlanillaBonificacion($idPlanilla, $bonificaciones)
    {
        foreach ($bonificaciones as $bonificacion)
        {
            $data = [
                'id_planilla'  => $idPlanilla,
                'id_bonificacion' => $bonificacion
            ];
            $this->modPlanillaBonificacion->insert($data);
        }
    }

}
