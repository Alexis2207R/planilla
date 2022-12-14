<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Personal</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Panel Principal</a></li>
                        <li class="breadcrumb-item active">Personal</li>
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
                    <h3 class="card-title">Lista del Personal</h3>

                    <div class="card-tools">
                        <button id="btnNew" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-personal">
                            Agregar
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <table id="tbl_personales" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">DNI</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>REGIMEN</th>
                                <th>REMUNERACIÓN</th>
                                <th>CONDICIÓN</th>
                                <th>CARGO</th>
                                <th>SEXO</th>
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

<!-- Modal Personal -->
<div class="modal fade" id="modal-personal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulario Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form_personal" method="post">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="fordni">DNI <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="dni_personal" class="form-control form-control-sm" id="fordni" placeholder="Documento Nacional de Identidad">
                                    <span class="input-group-append">
                                        <button id="api_personal" type="button" class="btn btn-info btn-flat"><i class="fas fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="fornombre">NOMBRE <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="nombre_personal" class="form-control form-control-sm" id="fornombre" placeholder="Nombre personal">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="forape">APELLIDOS <span class="text-danger">*</span></label>
                                <input type="text" name="apellido_personal" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
                            </div>
                        </div>

                        <div class="col-lg-1">
                            <div class="form-group">
                                <label>SEXO <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="sexo_personal">
                                    <option selected disabled>Seleccionar...</option>
                                    <option value="F">F</option>
                                    <option value="M">M</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="forcuenta">NÚMERO CUENTA <span class="text-danger">*</span></label>
                                <input type="text" name="nro_cuenta" class="form-control form-control-sm" id="forcuenta" step="0.01" placeholder="Número de cuenta">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="fordiashoras"> DÍAS/HORAS </label>
                                <input type="number" name="dias_horas" class="form-control form-control-sm" id="fordiashoras" step="0.1" placeholder="">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>CARGO ESTRUCTURAL <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="id_cargo">
                                    <option selected disabled>Seleccionar...</option>
                                    <?php
                                    foreach ($cargos as $item) {
                                        echo '<option value="' . $item['id_cargo'] . '">' . $item['nombre_cargo'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>REGIMEN PENSIONAL <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="id_regimen">
                                    <option selected disabled>Seleccionar...</option>
                                    <?php
                                    foreach ($regimenes as $item) {
                                        echo '<option value="' . $item['id_regimen'] . '">' . $item['nombre_regimen'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>NIVEL REMUNERACIÓN <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="id_remuneracion">
                                    <option selected disabled>Seleccionar...</option>
                                    <?php
                                    foreach ($remuneraciones as $item) {
                                        echo '<option value="' . $item['id_remuneracion'] . '">' . $item['nivel'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>CONDICIÓN LABORAL <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="id_condicion">
                                    <option selected disabled>Seleccionar...</option>
                                    <?php
                                    foreach ($condiciones as $item) {
                                        echo '<option value="' . $item['id_condicion'] . '">' . $item['condicion'] . '</option>';
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

<script type="text/javascript" src="<?= base_url() . '/public/dist/js/personales.js' ?>">

</script>

<script>
    $(document).ready(function() {
        personales();
    })
</script>
