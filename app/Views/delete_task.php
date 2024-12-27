<?= $this->extend('layouts/main_layout.php') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h3 class="text-danger">Pretende eliminar a tarefa?</h3>
            <hr>
            <div class="mb-4">
                <p>Nome da tarefa: <b><?= $task_data->task_name ?></b></p>
            </div>
            <div class="mb-4">
                <p>Descrição da tarefa: <b><?= $task_data->task_description ?></b></p>
            </div>
            <div class="mb-4">
                <p>Status da tarefa: <b><?= STATUS_LIST[$task_data->task_status] ?></b></p>
            </div>
            <div class="text-center">
                <a href="<?= site_url('/') ?>" class="btn btn-secondary px-5"><i class="fa-solid fa-ban me-2"></i>Cancelar</a>
                <a href="<?= site_url('delete_task_confirm/' . encrypt($task_data->id)) ?>" class="btn btn-primary px-5"><i class="fa-solid fa-trash me-2"></i>Excluir</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>