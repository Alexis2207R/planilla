<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\CargoModel;
use App\Models\CondicionModel;
use App\Models\PersonalModel;
use App\Models\RegimenModel;
use App\Models\RemuneracionModel;

class Personales extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modPersonal     = new PersonalModel();
        $this->modCargo        = new CargoModel();
        $this->modRemuneracion = new RemuneracionModel();
        $this->modCondicion    = new CondicionModel();
        $this->modRegimen      = new RegimenModel();
    }

    public function index()
    {
        $cargos = $this->modCargo->getAllActive();
        $remuneraciones = $this->modRemuneracion->getAllActive();
        $condiciones = $this->modCondicion->getAllActive();
        $regimenes = $this->modRegimen->getAllActive();

        $data = [
            'cargos'         => $cargos,
            'remuneraciones' => $remuneraciones,
            'condiciones'    => $condiciones,
            'regimenes'      => $regimenes
        ];
        return $this->ViewData('modules/personal', $data);
    }

    public function list_personales()
    {
        if ($this->request->isAjax()) {
            $personales = $this->modPersonal->mdListarPersonales();;
            $data = ['personales' => $personales];
            return json_encode($data['personales']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_personal()
    {
        if ($this->request->isAjax()) {
            $personal = $this->modPersonal->update($_POST['item'], ['estado_personal' => 0]);
            if (!$personal) {
                return json_encode(['status' => 400, 'delete' => $personal, 'msg' => 'Hubo un error al intentar eliminar el personal']);
            }
            return json_encode(['status' => 200, 'delete' => $personal, 'msg' => 'Personal eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_personal()
    {
        if ($this->request->isAjax()) {
            $personal = $this->modPersonal->find($_POST['item']);
            if ($personal['estado_personal'] == 1) {
                $personal = $this->modPersonal->update($_POST['item'], ['estado_personal' => 2]);
                return json_encode(['status' => 200, 'disable' => $personal, 'msg' => 'Personal desactivado con exito']);
            } else {
                $personal = $this->modPersonal->update($_POST['item'], ['estado_personal' => 1]);
                return json_encode(['status' => 200, 'disable' => $personal, 'msg' => 'Personal activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $personal, 'msg' => 'Hubo un error al intentar deshabilidtar el personal']);
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
            //'dni_personal'       => 'required',
            'nombre_personal'    => 'required',
            'apellido_personal'  => 'required',
            'sexo_personal'      => 'required',
            'id_cargo'           => 'required',
            'id_regimen'         => 'required',
            'id_remuneracion'    => 'required',
            'id_condicion'       => 'required',
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_personal']) && !empty($_POST['id_personal'])) {
                $datos = [
                    'id_personal'         => $_POST['id_personal'],
                    'dni_personal'        => $_POST['dni_personal'],
                    'nombre_personal'     => strtoupper($_POST['nombre_personal']),
                    'apellido_personal'   => strtoupper($_POST['apellido_personal']),
                    'sexo_personal'       => $_POST['sexo_personal'],
                    'id_cargo'            => $_POST['id_cargo'],
                    'id_regimen'          => $_POST['id_regimen'],
                    'id_remuneracion'     => $_POST['id_remuneracion'],
                    'id_condicion'        => $_POST['id_condicion'],
                    'nro_cuenta'          => $_POST['nro_cuenta'],
                    'dias_horas'          => $_POST['dias_horas'],
                    'fecha_actualizacion' => date('Y-m-d H:i:s')
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    'dni_personal'        => $_POST['dni_personal'],
                    'nombre_personal'     => strtoupper($_POST['nombre_personal']),
                    'apellido_personal'   => strtoupper($_POST['apellido_personal']),
                    'sexo_personal'       => $_POST['sexo_personal'],
                    'id_cargo'            => $_POST['id_cargo'],
                    'id_regimen'          => $_POST['id_regimen'],
                    'id_remuneracion'     => $_POST['id_remuneracion'],
                    'id_condicion'        => $_POST['id_condicion'],
                    'nro_cuenta'          => $_POST['nro_cuenta'],
                    'dias_horas'          => $_POST['dias_horas'],
                    'fecha_registro' => date('Y-m-d H:i:s')
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_personal()
    {
        if ($this->request->isAjax()) {
            $personal = $this->modPersonal->find($_POST['item']);
            if (!$personal) {
                return json_encode(['status' => 400, 'edit' => $personal, 'msg' => 'Hubo un error al intentar obtener la personal']);
            }
            return json_encode(['status' => 200, 'edit' => $personal, 'msg' => 'Personal eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modPersonal->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar la personal']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Personal registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modPersonal->update($_POST['id_personal'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar la personal']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Personal actualizado con exito']);
    }

}
