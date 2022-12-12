<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Pagos</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Panel Principal</a></li>
                        <li class="breadcrumb-item active">Pagos</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="row justify-content-center">
            <div class="card col-lg-10">
                <div class="card-header">
                    <h3 class="card-title">Lista de Pagos</h3>

                    <div class="card-tools">
                        <button id="btnNew" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-pago">
                            Agregar
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <table id="tbl_pagos" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">CÓDIGO</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>PLANILLA</th>
                                <th>AÑO</th>
                                <th>MES</th>
                                <th class="text-center">ESTADO</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal Pago -->
<div class="modal fade" id="modal-pago">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulario Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form_pago" method="post">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>PERSONAL <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="id_personal">
                                    <option selected disabled>Seleccionar...</option>
                                    <?php
                                    foreach ($personales as $item) {
                                        echo '<option value="' . $item['id_personal'] . '">' . $item['nombre_personal'] . ' ' . $item['apellido_personal'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>PLANILLA <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="id_planilla">
                                    <option selected disabled>Seleccionar...</option>
                                    <?php
                                    foreach ($planillas as $item) {
                                        echo '<option value="' . $item['id_planilla'] . '">' . $item['numero_planilla'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>MES <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="id_mes">
                                    <option selected disabled>Seleccionar...</option>
                                    <?php
                                    foreach ($meses as $item) {
                                        echo '<option value="' . $item['id_mes'] . '">' . $item['nombre_mes'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                    <button id="btnCancel" type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript" src="<?= base_url() . '/public/dist/js/pagos.js' ?>">

</script>

<script>
    $(document).ready(function() {
        pagos();
    })
</script>
