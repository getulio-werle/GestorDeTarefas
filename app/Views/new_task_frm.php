<?= $this->extend('layouts/main_layout.php') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h3>Nova tarefa</h3>
            <hr>
            <?= form_open('new_task_submit') ?>
            <div class="mb-3">
                <label class="form-label">Nome da tarefa</label>
                <input type="text" name="text_tarefa" class="form-control" placeholder="Nome da tarefa" value="<?= old('text_tarefa') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição da tarefa</label>
                <textarea name="text_descricao" class="form-control" rows="3"><?= old('text_descricao') ?></textarea>
            </div>
            <div class="text-center">
                <a href="<?= site_url('/') ?>" class="btn btn-secondary px-5"><i class="fa-solid fa-ban me-2"></i>Cancelar</a>
                <button type="submit" class="btn btn-primary px-5"><i class="fa-solid fa-floppy-disk me-2"></i>Salvar</button>
            </div>
            <?= form_close() ?>

            <?php if (!empty($validation_errors)) : ?>
                <div class="alert alert-danger mt-5">
                    <?php foreach ($validation_errors as $error) : ?>
                        <?= $error ?>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>