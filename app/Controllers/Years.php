<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\YearModel;

class Years extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modYear = new YearModel();
    }

    public function index()
    {
        return $this->ViewData('modules/year', []);
    }

    public function list_years()
    {
        if ($this->request->isAjax()) {
            $years = $this->modYear->mdListarYears();;
            $data = ['years' => $years];
            return json_encode($data['years']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_year()
    {
        if ($this->request->isAjax()) {
            $year = $this->modYear->update($_POST['item'], ['estado_year' => 0]);
            if (!$year) {
                return json_encode(['status' => 400, 'delete' => $year, 'msg' => 'Hubo un error al intentar eliminar el año laboral']);
            }
            return json_encode(['status' => 200, 'delete' => $year, 'msg' => 'Año laboral eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_year()
    {
        if ($this->request->isAjax()) {
            $year = $this->modYear->find($_POST['item']);
            if ($year['estado_year'] == 1) {
                $year = $this->modYear->update($_POST['item'], ['estado_year' => 2]);
                return json_encode(['status' => 200, 'disable' => $year, 'msg' => 'Año laboral desactivado con exito']);
            } else {
                $year = $this->modYear->update($_POST['item'], ['estado_year' => 1]);
                return json_encode(['status' => 200, 'disable' => $year, 'msg' => 'Año laboral activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $year, 'msg' => 'Hubo un error al intentar deshabilidtar el año laboral']);
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
            'nombre_year' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_year']) && !empty($_POST['id_year'])) {
                $datos = [
                    "nombre_year" => strtoupper($_POST['nombre_year'])
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $datos = [
                    "nombre_year" => strtoupper($_POST['nombre_year'])
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_year()
    {
        if ($this->request->isAjax()) {
            $year = $this->modYear->find($_POST['item']);
            if (!$year) {
                return json_encode(['status' => 400, 'edit' => $year, 'msg' => 'Hubo un error al intentar obtener el año']);
            }
            return json_encode(['status' => 200, 'edit' => $year, 'msg' => 'Año eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modYear->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar el año laboral']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Año laboral registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modYear->update($_POST['id_year'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar el año laboral']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Año laboral actualizado con exito']);
    }


}
