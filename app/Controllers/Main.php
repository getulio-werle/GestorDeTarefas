<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use CodeIgniter\HTTP\ResponseInterface;

class Main extends BaseController
{
    public function index()
    {
        // echo "Olá mundo!";

        $model = new UsuariosModel();
        $usuarios = $model->findAll();
        
        dd($usuarios);

    }
}
