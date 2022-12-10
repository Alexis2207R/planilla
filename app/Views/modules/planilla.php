<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Planillas</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Panel Principal</a></li>
                        <li class="breadcrumb-item active">Planillas</li>
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
                    <h3 class="card-title">Lista de Planillas</h3>

                    <div class="card-tools">
                        <button id="btnNew" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-planilla">
                            Agregar
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <table id="tbl_planillas" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">NÚMERO</th>
                                <th>TIPO</th>
                                <th>AÑO</th>
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

<!-- Modal Planilla -->
<div class="modal fade" id="modal-planilla">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulario Planilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form_planilla" method="post">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="fornombre">NÚMERO <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="numero_planilla" class="form-control form-control-sm" id="fornombre" placeholder="Número de planilla">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>TIPO PLANILLA <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="id_tipo_planilla">
                                    <option selected disabled>Seleccionar...</option>
                                    <?php
                                    foreach ($tipoPlanillas as $item) {
                                        echo '<option value="' . $item['id_tipo_planilla'] . '">' . $item['nombre_tipo_planilla'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>AÑO PLANILLA <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" name="id_year_planilla">
                                    <option selected disabled>Seleccionar...</option>
                                    <?php
                                    foreach ($years as $item) {
                                        echo '<option value="' . $item['id_year'] . '">' . $item['nombre_year'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>BONIFICACIONES</label>
                                <select class="duallistbox form-control" multiple="multiple" name="bonificaciones" id="bonificaciones">
                                    <?php
                                    foreach ($bonificaciones as $item) {
                                        $contenido = $item['nombre_bonificacion'] . '     S/' . $item['cantidad_bonificacion'];
                                        echo '<option value="' . $item['id_bonificacion'] . '">' . $contenido . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>DESCUENTOS</label>
                                <select class="duallistbox form-control" multiple="multiple" name="descuentos" id="descuentos">
                                    <?php
                                    foreach ($descuentos as $item) {
                                        $contenido = $item['nombre_descuento'] . '      S/' . $item['cantidad_descuento'];
                                        echo '<option value="' . $item['id_descuento'] . '">' . $contenido . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- /.form-group -->
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

<script type="text/javascript" src="<?= base_url() . '/public/dist/js/planillas.js' ?>">

</script>

<script>
    $(document).ready(function() {
        planillas();
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox({
            filterPlaceHolder: 'Buscar',
            infoTextEmpty: 'Sin elementos',
            infoText: 'Mostrando todo {0}',
            infoTextFiltered: '<span class="label label-warning">Mostrando</span> {0} de {1}',
            filterTextClear: 'Mostrar todo'
        });
    })
</script>
