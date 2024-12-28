<?= $this->extend('layouts/main_layout.php') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col card p-5">
            <h3 class="text-info"><?= $task_data->task_name ?></h3>
            <hr>
            <p>Descrição:</p>
            <p><b><?= $task_data->task_description ?></b></p>
            <p>Status:</p>
            <p><b><?= STATUS_LIST[$task_data->task_status] ?></b></p>
            <div class="text-center">
                <a href="<?= site_url('/') ?>" class="btn btn-secondary px-5"><i class="fa-solid fa-rotate-left me-2"></i>Voltar</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>