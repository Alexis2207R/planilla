<?php

namespace App\Controllers;

use App\Models\BonificacionModel;
use App\Models\DescuentoModel;
use App\Models\PersonalModel;
use CodeIgniter\Controller;

class PorPersonas extends Controller
{
    public function __construct()
    {
        $this->modPersonal = new PersonalModel();
        $this->modBonificacion = new BonificacionModel();
        $this->modDescuento = new DescuentoModel();
    }

    public function index()
    {
        $personales = $this->modPersonal->getAllActive();
        $bonificaciones = $this->modBonificacion->getAllActive();
        $descuentos = $this->modDescuento->getAllActive();
        $data = [
            'personales'     => $personales,
            'bonificaciones' => $bonificaciones,
            'descuentos'     => $descuentos
        ];
        return $this->ViewData('modules/porpersona', $data);
    }


}
