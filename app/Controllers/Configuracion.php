<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ConfiguracionModel;

class Configuracion extends Controller{

    public function __construct(){
        $this->validation =  \Config\Services::validation();
        $this->model = new ConfiguracionModel();
    }

    public function index(){
        $data = ["Configuracion" => $this->model->find()];
        return $this->ViewData('modules/configuracion', $data);
    }
}