<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Home extends Controller{
    public function index(){
        $data = [];
        return $this->ViewData('index', $data);
    }
}
