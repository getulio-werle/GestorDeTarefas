<?= $this->extend('layouts/main_layout.php') ?>
<?= $this->section('content') ?>

<section class="container mt-5">
    <div class="row">
        <div class="col">
            <!-- search bar -->
            <?= form_open('search') ?>
            <div class="mb-3 d-flex align-items-center">
                <label for="text_search" class="me-3">Pesquisar:</label>
                <input type="text" name="text_search" id="text_search" class="form-control w-50 me-3">
                <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <?= form_close() ?>
        </div>
        <div class="col">
            <!-- status filter -->
            <div class="d-flex mb-3 align-items-center">
                <label for="select_status" class="me-2">Status:</label>
                <select name="select_status" id="select_status" class="form-select">
                    <?php foreach (STATUS_LIST as $key => $value) : ?>
                        <option value="<?= $key ?>" <?= check_status($key, !empty($status) ? $status : '') ?>><?= $value ?></option>
                    <?php endforeach ?>
                </select>
            </div>
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
<?php if (!empty($tasks)) : ?>
    <section class="container">
        <div class="row">
            <div class="col">
                <table class="table table-striped" id="table_tasks">
                    <thead>
                        <th width="50%">Tarefa</th>
                        <th width="25%">Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task) : ?>
                            <tr>
                                <td><?= $task->task_name ?></td>
                                <td>
                                    <?= STATUS_LIST[$task->task_status] ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= site_url('edit_task/' . encrypt($task->id)) ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="<?= site_url('delete_task/' . encrypt($task->id)) ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php else : ?>
    <section class="container mt-3">
        <div class="row">
            <div class="col text-center">
                <p>Não foram encontradas tarefas.</p>
            </div>
        </div>
    </section>
<?php endif ?>
<!-- datatables -->
<script>
    // datatable
    $(document).ready(function() {
        $('#table_tasks').DataTable({
            "language": {
                "info": "Mostrando página _START_ de _TOTAL_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "loadingRecords": "Carregando...",
                "search": "Pesquisar:",
                "zeroRecords": "Nada encontrado",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                }
            }
        })
    });
    // filter change
    document.querySelector('select[name="select_status"]').addEventListener('change', (e) => {
        console.log('teste');
        let status = e.target.value;
        window.location.href = `<?= site_url('filter') ?>/${status}`;
    });
</script>

<?= $this->endSection() ?>