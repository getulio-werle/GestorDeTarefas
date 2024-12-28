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
        // main
        $data = [];
        // load tasks from the database and the user in session
        $tasks_model = new TasksModel();
        $data['tasks'] = $tasks_model->where('id_user', session()->id)->findAll();
        $data['datatables'] = true;
        return view('main', $data);
    }

    public function login()
    {
        $data = [];
        // check for validation errors
        $validation_errors = session()->getFlashData('validation_errors');
        if ($validation_errors) {
            $data['validation_errors'] = $validation_errors;
        }
        // check for login errors
        $login_error = session()->getFlashdata('login_error');
        if ($login_error) {
            $data['login_error'] = $login_error;
        }
        return view('login_frm', $data);
    }

    public function login_submit()
    {
        // form validation
        $validation = $this->validate(
            // validation rules
            [
                'text_usuario' => 'required',
                'text_senha' => 'required'
            ],
            // validation errors
            [
                'text_usuario' => ['required' => 'O campo usuário é obrigatório'],
                'text_senha' => ['required' => 'O campo senha é obrigatório']
            ]
        );
        if (!$validation) {
            return redirect()->to('login')->withInput()->with('validation_errors', $this->validator->getErrors());
        }
        // check if login is valid
        $usuario = $this->request->getPost('text_usuario');
        $senha = $this->request->getPost('text_senha');
        $usuario_model = new UsuariosModel();
        $usuario_data = $usuario_model->where('usuario', $usuario)->first();
        // if usuarios is not found
        if (!$usuario_data) {
            return redirect()->to('login')->withInput()->with('login_error', 'Usuário ou senha inválidos');
        }
        // if senha is not valid
        if (!password_verify($senha, $usuario_data->senha)) {
            return redirect()->to('login')->withInput()->with('login_error', 'Usuário ou senha inválidos');
        }
        // login is valid
        $session_data = [
            'id' => $usuario_data->id,
            'usuario' => $usuario_data->usuario
        ];
        session()->set($session_data);
        // redirect to home page
        return redirect()->to('/');
    }

    public function logout()
    {
        // destroy session
        session()->destroy();
        // redirect to main page
        return redirect()->to('/');
    }

    public function new_task()
    {
        $data = [];
        // check for validation errors
        $validation_errors = session()->getFlashdata('validation_errors');
        if ($validation_errors) {
            $data['validation_errors'] = $validation_errors;
        }
        return view('new_task_frm', $data);
    }

    public function new_task_submit()
    {
        // form validation
        $validation = $this->validate([
            'text_tarefa' => [
                'label' => 'Nome da tarefa',
                'rules' => 'required|min_length[5]|max_length[200]',
                'errors' => [
                    'required' => 'O campo {field} é de preenchimento obrigatório',
                    'min_length' => 'O campo {field} deve ter no mínimo {param} caracteres.',
                    'max_length' => 'O campo {field} deve ter no máximo {param} caracteres.'
                ]
            ],
            'text_descricao' => [
                'label' => 'Descrição',
                'rules' => 'max_length[500]',
                'errors' => [
                    'max_length' => 'O campo {field} deve ter no máximo {param} caracteres.'
                ]
            ]
        ]);
        if (!$validation) {
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }
        // get form data
        $titulo = $this->request->getPost('text_tarefa');
        $descricao = $this->request->getPost('text_descricao');
        // insert data
        $tasks_model = new TasksModel();
        $tasks_model->insert([
            'id_user' => session()->id,
            'task_name' => $titulo,
            'task_description' => $descricao,
            'task_status' => 'new'
        ]);
        // redirect to home page
        return redirect()->to('/');
        // save data
        echo 'Fim';
    }

    public function search()
    {
        $data = [];
        // get search items
        $search_term = $this->request->getPost('text_search');
        // load tasks from the database and search items
        $tasks_model = new TasksModel();
        $data['tasks'] = $tasks_model->where('id_user', session()->id)->like('task_name', $search_term)->findAll();
        $data['datatables'] = true;
        return view('main', $data);
    }

    public function filter($status)
    {
        $data = [];
        $tasks_model = new TasksModel();
        if ($status == 'all') {
            $data['tasks'] = $tasks_model->where('id_user', session()->id)->findAll();
        } else {
            $data['tasks'] = $tasks_model->where('id_user', session()->id)->where('task_status', $status)->findAll();
        }
        $data['status'] = $status;
        $data['datatables'] = true;
        return view('main', $data);
    }

    public function edit_task($enc_id)
    {
        // decrypt id
        $task_id = decrypt($enc_id);
        if (!$task_id) {
            return redirect()->to('/');
        }
        $data = [];
        // check for validation errors
        $validation_errors = session()->getFlashdata('validation_errors');
        if ($validation_errors) {
            $data['validation_errors'] = $validation_errors;
        }
        // load task data
        $tasks_model = new TasksModel();
        $task_data = $tasks_model->where('id', $task_id)->first();
        if (!$task_data) {
            return redirect()->to('/');
        }
        // check if task belongs to the user in the session
        if ($task_data->id_user != session()->id) {
            return redirect()->to('/');
        }
        $data['task'] = $task_data;
        return view('edit_task_frm', $data);
    }

    public function edit_task_submit()
    {
        // form validation
        $validation = $this->validate(
            [
                'hidden_id' => [
                    'label' => 'ID',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'O campo {field} é obrigatório.'
                    ]
                ],
                'text_tarefa' => [
                    'label' => 'Nome da tarefa',
                    'rules' => 'required|min_length[5]|max_length[200]',
                    'errors' => [
                        'required' => 'O campo {field} é obrigatório.',
                        'min_length' => 'O campo {field} deve ter no mínimo {param} caracteres.',
                        'max_length' => 'O campo {field} deve ter no máximo {param} caracteres.'
                    ]
                ],
                'text_descricao' => [
                    'label' => 'Descrição',
                    'rules' => 'max_length[500]',
                    'errors' => [
                        'max_length' => 'O campo {field} deve ter no máximo {param} caracteres.'
                    ]
                ],
                'select_status' => [
                    'label' => 'Status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'O campo {field} é obrigatório.'
                    ]
                ]
            ]
        );
        if (!$validation) {
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }
        // get hidden task id
        $task_id = decrypt($this->request->getPost('hidden_id'));
        if (!$task_id) {
            return redirect()->to('/');
        }
        // get form data
        $tarefa = $this->request->getPost('text_tarefa');
        $descricao = $this->request->getPost('text_descricao');
        $status = $this->request->getPost('select_status');
        // load task data
        $tasks_model = new TasksModel();
        $task_data = $tasks_model->where('id', $task_id)->first();
        if (!$task_data) {
            return redirect()->to('/');
        }
        // check if task belong to the user in the session
        if ($task_data->id_user != session()->id) {
            return redirect()->to('/');
        }
        // insert data in database
        $tasks_model->update($task_id, [
            'task_name' => $tarefa,
            'task_description' => $descricao,
            'task_status' => $status
        ]);
        // redirect to homepage
        return redirect()->to('/');
    }

    public function delete_task($enc_id)
    {
        // decrypt task id
        $task_id = decrypt($enc_id);
        if (!$task_id) {
            return redirect()->to('/');
        }
        // load task data
        $tasks_model = new TasksModel();
        $task_data = $tasks_model->where('id', $task_id)->first();
        if (!$task_data) {
            return redirect()->to('/');
        }
        // check if task belong to user in the session
        if ($task_data->id_user != session()->id) {
            return redirect()->to('/');
        }
        // display task with question if it is to delete or no delete
        $data['task_data'] = $task_data;
        return view('delete_task', $data);
    }

    public function delete_task_confirm($enc_id)
    {
        // decrypt task id
        $task_id = decrypt($enc_id);
        if (!$task_id) {
            return redirect()->to('/');
        }
        // load task data
        $tasks_model = new TasksModel();
        $task_data = $tasks_model->where('id', $task_id)->first();
        if (!$task_data) {
            return redirect()->to('/');
        }
        // check if task belong to user in the session
        if ($task_data->id_user != session()->id) {
            return redirect()->to('/');
        }
        $tasks_model->delete($task_id);
        // redirect to home page
        return redirect()->to('/');
    }

    public function task_details($enc_id) {
        // decrypt task id
        $task_id = decrypt($enc_id);
        if (!$task_id) {
            return redirect()->to('/');
        }
        // load task data
        $tasks_model = new TasksModel();
        $task_data = $tasks_model->where('id', $task_id)->first();
        if (!$task_data) {
            return redirect()->to('/');
        }
        // check if task belong to user in the session
        if ($task_data->id_user != session()->id) {
            return redirect()->to('/');
        }
        // show task details
        $data['task_data'] = $task_data;
        return view('task_details', $data);
    }

    public function session()
    {
        echo '<pre>';
        print_r(session()->get());
        echo '</pre>';
    }
}
