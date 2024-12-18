<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TasksModel;
use App\Models\UsuariosModel;
use CodeIgniter\HTTP\ResponseInterface;

class Main extends BaseController
{
    public function index()
    {
        // echo "Olá mundo!";

        // usuarios
        // $model_usuarios = new UsuariosModel();
        // $usuarios = $model_usuarios->findAll();
        // dd($usuarios);

        // tasks
        $model_tasks = new TasksModel();
        $tasks = $model_tasks->findAll();
        dd($tasks);
    }
}
