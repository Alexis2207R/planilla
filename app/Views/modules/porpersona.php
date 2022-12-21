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
    <section class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title">Generador de reportes pdf</h3>
                        </div>
                        <div class="col-4">
                        <form action="<?= base_url().'/porPersonas/view_personal'?>" method="POST">
                            <div class="form-group">
                                <label for="my-select">PERSONAL</label>
                                <select id="my-select" class="form-control" name="id_personal">
                                    <option selected disabled>SELECIONAR...</option>
                                    <?php foreach ($personales as $item) { ?>
                                    <option value="<?= $item['id_personal'] ?>"> <?=$item['nombre_personal'] . ' ' . $item['apellido_personal']?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="my-select">AÑO</label>
                                <select id="my-select" class="form-control" name="id_year">
                                    <option selected disabled>SELECCIONAR...</option>
                                    <?php
                                        foreach ($years as $item) {
                                            echo '<option value="' . $item['id_year'] . '">' . $item['nombre_year'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-download"></i> Descargar PDF
                            </button>
                        </form>
                        </div>
                            <div class="card-tools">
                                <form method="post" id="form_busqueda" class="form">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="forpersonal">PERSONAL <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control form-control-sm select2" name="id_personal"
                                                    id="forpersonal">
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
                                                <select class="form-control form-control-sm select2" name="id_year"
                                                    id="foryear">
                                                    <option selected disabled>Seleccionar...</option>
                                                    <?php
                                            foreach ($years as $item) {
                                                echo '<option value="' . $item['id_year'] . '">' . $item['nombre_year'] . '</option>';
                                            }
                                            ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <button id="btnSearch" type="button" class="btn btn-primary btn-sm">
                                                Buscar
                                            </button>
                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
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
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript" src="<?= base_url() . '/public/dist/js/porpersonas.js' ?>">

</script>

<script>
$(document).ready(function () {
    porpersonas();
    $('.select2').select2({
        placeholder: 'Seleccionar...'
    });
})

// $(function() {
//     $("#example1").DataTable({
//         "responsive": true,
//         "lengthChange": false,
//         "autoWidth": false,
//         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
//     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
// });
</script>