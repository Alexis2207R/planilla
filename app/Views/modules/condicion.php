<?php echo view('include/header.php') ?>
<?php echo view('include/menu.php') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Condición Laboral</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Panel Principal</a></li>
                        <li class="breadcrumb-item active">Condición Laboral</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Condición Laboral</h3>
                        </div>
                        <div class="card-body p-3">
                            <table id="tbl_condicion" class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center">N°</th>
                                        <th class="text-center">Condición Laboral</th>
                                        <th class="text-center">Fecha Actualización</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <?php $c=0; foreach ($condiciones as $condicion) {?>
                                <tbody>
                                    <td class="text-center">
                                        <?php $c++; echo $c?>
                                    </td>
                                    <td class="text-center">
                                        <?=$condicion['condicion'];?>
                                    </td>
                                    <td class="text-center">
                                        <?=$condicion['creacion_condicion']?>
                                    </td>
                                    <td class="text-center"></td>
                                </tbody>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Formulario Condición Laboral</h3>
                        </div>
                        <form class="form" action="<?=base_url().'/condicion/create'?>" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="condicion">Condición Laboral</label>
                                    <input type="text" class="form-control" name="nombre_condicion"
                                        id="nombre_condicion" placeholder="Ingresar Condición Laboral">
                                </div>
                                <?php 
                                date_default_timezone_set('America/Lima');
                                $fecha_hora_actual = date("Y-m-d H:i:s");
                                ?>
                                <div class="form-group">
                                    <label for="creacion_condicion">Se registarta la fecha de creacion</label>
                                    <input type="datetime" class="form-control" name="creacion_condicion"
                                        id="creacion_condicion" value="<?= $fecha_hora_actual;?>">
                                </div>
                            </div>
                            <div class="card-footer">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalId">
                                    Guardar
                                </button>
                                <button type="button" class="btn btn-danger btn-sm"
                                    data-dismiss="modal">Cancelar</button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="modalId" tabindex="-1" role="dialog"
                                aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">Guardar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                Seguro que quiere guardar los cambios?
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->

<?php echo view('include/footer.php') ?>

<script>
    var modalId = document.getElementById('modalId');

    modalId.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        let button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        let recipient = button.getAttribute('data-bs-whatever');

        // Use above variables to manipulate the DOM
    });
</script>