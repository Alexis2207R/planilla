<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Condiciones</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Panel Principal</a></li>
                        <li class="breadcrumb-item active">Condiciones</li>
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
                    <h3 class="card-title">Lista de Condiciones</h3>

                    <div class="card-tools">
                        <button id="btnNew" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-condicion">
                            Agregar
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <table id="tbl_condiciones" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">CÓDIGO</th>
                                <th>NOMBRE</th>
                                <th>FECHA CREACIÓN</th>
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

<!-- Modal Condicion -->
<div class="modal fade" id="modal-condicion">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulario Condicion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form_condicion" method="post">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="fornombre">NOMBRE <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="nombre_condicion" class="form-control form-control-sm" id="fornombre" placeholder="Nombre condicion">
                                </div>
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

<script type="text/javascript" src="<?= base_url() . '/public/dist/js/condiciones.js' ?>">

</script>

<script>
    $(document).ready(function() {
        condiciones();
    })
</script>
