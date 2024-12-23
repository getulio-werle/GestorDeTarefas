<?= $this->extend('layouts/main_layout.php') ?>
<?= $this->section('content') ?>

<section class="container mt-5">
    <div class="row">
        <div class="col">
            <!-- search bar -->
            <?= form_open('search') ?>
            <div class="mb-3 d-flex align-items-center">
                <label for="text_search" class="me-3">Pesquisar:</label>
                <input type="text" name="text_search" class="form-control w-50 me-3">
                <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <?= form_close() ?>
        </div>
        <div class="col">
            <!-- status filter -->
            <?= form_open('filter') ?>
            <div class="d-flex mb-3 align-items-center">
                <label for="select_status" class="me-2">Status:</label>
                <select name="select_status" class="form-select">
                    <?php foreach (STATUS_LIST as $key => $value) : ?>
                        <option value="<?= $key ?>"><?= $value ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <?= form_close() ?>
        </div>
        <div class="col text-end">
            <!-- new task button -->
            <a href="<?= site_url('new_task') ?>" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Nova tarefa</a>
        </div>
    </div>
</section>

<section class="container">
    <div class="row">
        <div class="col">
          <h3>Tarefas</h3>  
        </div>
    </div>
</section>
<section class="container">
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <th>Tarefa</th>
                    <th>Status</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                </tbody>
            </table>
        </div>
    </div>
</section>
<section class="container mt-3">
    <div class="row">
        <div class="col text-center">
            <p>Não foram encontradas tarefas.</p>
        </div>
    </div>
</section>

<?= $this->endSection() ?>