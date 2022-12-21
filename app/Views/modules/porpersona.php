<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Porpersonas</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Panel Principal</a></li>
                        <li class="breadcrumb-item active">Porpersonas</li>
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
                    <h3 class="card-title">Reporte de pagos</h3>

                    <div class="card-tools">
                        <form method="post" id="form_busqueda" class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="forpersonal">PERSONAL <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm select2" name="id_personal" id="forpersonal">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php
                                            foreach ($personales as $item) {
                                                echo '<option value="' . $item['id_personal'] . '">' . $item['nombre_personal'] . ' ' . $item['apellido_personal'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="foryear">AÑO <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm select2" name="id_year" id="foryear">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php
                                            foreach ($years as $item) {
                                                echo '<option value="' . $item['id_year'] . '">' . $item['nombre_year'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="foryear">TIPO <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm select2" name="type_report" id="type_report">
                                            <option selected disabled>Seleccionar...</option>
                                            <option value="1">Ver</option>
                                            <option value="2">Pdf</option>
                                            <option value="3">Excel</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="btnSearch"><span class="text-danger"></span></label>
                                        <button id="btnSearch" type="submit" class="btn btn-primary btn-sm">
                                            Buscar
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
                <div class="card-body p-3">
                    <table id="tbl_porpersonas" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">MES
                                </th>
                                <th>NRO PLANILLA</th>
                                <th>DIAS</th>
                                <?php
                                foreach ($bonificaciones as $item) {
                                    echo '<th>' . $item['nombre_bonificacion']  . '</th>';
                                }
                                ?>
                                <th>INGRESO</th>
                                <?php
                                foreach ($descuentos as $item) {
                                    echo '<th>' . $item['nombre_descuento']  . '</th>';
                                }
                                ?>
                                <th>EGRESO</th>
                                <th>TOTAL NETO</th>
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

<script type="text/javascript" src="<?= base_url() . '/public/dist/js/porpersonas.js' ?>">

</script>

<script>
    $(document).ready(function() {
        porpersonas();
        $('.select2').select2({
            placeholder: 'Seleccionar...'
        });
    })
</script>
