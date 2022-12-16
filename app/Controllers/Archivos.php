<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\ArchivoModel;
use CodeIgniter\Files\File;

class Archivos extends Controller
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->modArchivo = new ArchivoModel();
    }

    public function index()
    {
        return $this->ViewData('modules/archivo', []);
    }

    public function list_archivos()
    {
        if ($this->request->isAjax()) {
            $archivos = $this->modArchivo->mdListarArchivos();;
            $data = ['archivos' => $archivos];
            return json_encode($data['archivos']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function delete_archivo()
    {
        if ($this->request->isAjax()) {
            $archivo = $this->modArchivo->update($_POST['item'], ['estado_archivo' => 0]);
            if (!$archivo) {
                return json_encode(['status' => 400, 'delete' => $archivo, 'msg' => 'Hubo un error al intentar eliminar el archivo']);
            }
            return json_encode(['status' => 200, 'delete' => $archivo, 'msg' => 'Archivo eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function disabled_archivo()
    {
        if ($this->request->isAjax()) {
            $archivo = $this->modArchivo->find($_POST['item']);
            if ($archivo['estado_archivo'] == 1) {
                $archivo = $this->modArchivo->update($_POST['item'], ['estado_archivo' => 2]);
                return json_encode(['status' => 200, 'disable' => $archivo, 'msg' => 'Archivo desactivado con exito']);
            } else {
                $archivo = $this->modArchivo->update($_POST['item'], ['estado_archivo' => 1]);
                return json_encode(['status' => 200, 'disable' => $archivo, 'msg' => 'Archivo activado con exito']);
            }
            return json_encode(['status' => 400, 'disable' => $archivo, 'msg' => 'Hubo un error al intentar deshabilidtar el archivo']);
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
            'nombre_archivo' => 'required'
        ]);
        $this->validation->withRequest($this->request)->run();
        if (!$this->validation->getErrors()) {
            if (isset($_POST['id_archivo']) && !empty($_POST['id_archivo'])) {
                $archivo = $this->request->getFile('archivo');
                if (!$archivo->isValid())
                {
                    $datos = [
                        "nombre_archivo"   =>  $_POST['nombre_archivo'],
                        'fecha_archivo'    =>  $_POST['fecha_archivo']
                    ];
                    $update = $this->update($datos);
                    return $update;
                }
                $nombre = $_POST['nombre_archivo'];
                if ($nombre == '')
                    $nombre = $archivo->getName();
                $datos = [
                    "nombre_archivo"   => strtoupper($nombre),
                    'fecha_archivo'    => $_POST['fecha_archivo'],
                    'ruta_archivo'     => $archivo->store()
                ];
                $update = $this->update($datos);
                return $update;
            } else {
                $archivo = $this->request->getFile('archivo');
                $nombre = $_POST['nombre_archivo'];
                if ($nombre == '')
                    $nombre = $archivo->getName();
                $datos = [
                    'nombre_archivo'   => strtoupper($nombre),
                    'fecha_archivo'    => $_POST['fecha_archivo'],
                    'ruta_archivo'     => $archivo->store(),
                    'creacion_archivo' => date('Y-m-d H:i:s')
                ];
                $insert = $this->register($datos);
                return $insert;
            }
        } else {
            $errors = $this->validation->getErrors();
            return json_encode(['status' => 400, 'errors' => $errors, 'msg' => 'Complete los campos requeridos con la información requerida']);
        }
    }

    public function edit_archivo()
    {
        if ($this->request->isAjax()) {
            $archivo = $this->modArchivo->find($_POST['item']);
            if (!$archivo) {
                return json_encode(['status' => 400, 'edit' => $archivo, 'msg' => 'Hubo un error al intentar obtener el archivo']);
            }
            return json_encode(['status' => 200, 'edit' => $archivo, 'msg' => 'Archivo eliminado con exito']);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function register($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $insert = $this->modArchivo->insert($datos);
        if (!$insert) {
            return json_encode(['status' => 400, 'insert' => $insert, 'msg' => 'Hubo un error al intentar registrar el archivo ']);
        }
        return json_encode(['status' => 200, 'insert' => $insert, 'msg' => 'Archivo  registrado con exito']);
    }

    public function update($datos)
    {
        if ($this->request->getMethod() != 'post') {
            return redirect()->to(base_url());
        }
        $update = $this->modArchivo->update($_POST['id_archivo'], $datos);
        if (!$update) {
            return json_encode(['status' => 400, 'update' => $update, 'msg' => 'Hubo un error al intentar actaulizar el archivo ']);
        }
        return json_encode(['status' => 200, 'update' => $update, 'msg' => 'Archivo  actualizado con exito']);
    }

    public function download_archivo($id)
    {
        $data = $this->modArchivo->find($id);
        $ruta = WRITEPATH . 'uploads/' . $data['ruta_archivo'];
        $archivo = new File($ruta);
        return $this->response->download($ruta, null)->setFileName($archivo->getBasename());
    }

}
