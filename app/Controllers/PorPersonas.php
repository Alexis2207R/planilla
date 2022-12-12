<?php

namespace App\Controllers;

use App\Models\BonificacionModel;
use App\Models\DescuentoModel;
use App\Models\PagoModel;
use App\Models\PersonalModel;
use App\Models\PlanillaBonificacionModel;
use App\Models\PlanillaDescuentoModel;
use App\Models\YearModel;
use CodeIgniter\Controller;

class PorPersonas extends Controller
{
    public function __construct()
    {
        $this->modPersonal = new PersonalModel();
        $this->modBonificacion = new BonificacionModel();
        $this->modDescuento = new DescuentoModel();
        $this->modYear = new YearModel();
        $this->modPago = new PagoModel();
        $this->modPlanillaDescuento = new PlanillaDescuentoModel();
        $this->modPlanillaBonificacion = new PlanillaBonificacionModel();
    }

    public function index()
    {
        $personales = $this->modPersonal->getAllActive();
        $bonificaciones = $this->modBonificacion->getAllActive();
        $descuentos = $this->modDescuento->getAllActive();
        $years = $this->modYear->getAllActive();
        $data = [
            'personales'     => $personales,
            'bonificaciones' => $bonificaciones,
            'descuentos'     => $descuentos,
            'years'           => $years
        ];
        return $this->ViewData('modules/porpersona', $data);
    }

    public function search_porpersona()
    {
        if ($this->request->isAjax()) {
            // $pagos = $this->modPago->mdListarDePersona($_POST['id_personal']); // Todos los anios
            $pagos = $this->modPago->mdListarDePersonaPorAnio($_POST['id_personal'], $_POST['id_year']);
            $bonificaciones = $this->modBonificacion->getAllActive();
            $descuentos = $this->modDescuento->getAllActive();

            $reporte = [];
            foreach ($pagos as $data)
            {
                $realData = [
                    'nombre_mes'      => $data['nombre_mes'],
                    'numero_planilla' => $data['numero_planilla'],
                    'dias'            => $data['dias'],
                    'nombre_year'     => $data['nombre_year'],
                    'id_planilla'     => $data['id_planilla'],
                    'total_egreso'    => $data['total_egreso'],
                    'total_ingreso'   => $data['total_ingreso'],
                    'total_neto'      => $data['total_neto'],
                ];

                foreach ($bonificaciones as $bonificacion)
                    $realData[$bonificacion['nombre_bonificacion']] = '';
                foreach ($descuentos as $descuento)
                    $realData[$descuento['nombre_descuento']] = '';

                $actualDescuentos = $this->modPlanillaDescuento->mdVerDePlanilla($data['id_planilla']);
                foreach ($actualDescuentos as $actual)
                    $realData[$actual['nombre_descuento']] = $actual['cantidad_descuento'];

                $actualBonificaciones = $this->modPlanillaBonificacion->mdVerDePlanilla($data['id_planilla']);
                foreach ($actualBonificaciones as $actual)
                    $realData[$actual['nombre_bonificacion']] = $actual['cantidad_bonificacion'];

                array_push($reporte, $realData);
            }

            return json_encode(['reporte' => $reporte, 'bonificaciones' => $bonificaciones, 'descuentos' => $descuentos]);
        } else {
            return redirect()->to(base_url());
        }
    }
}
