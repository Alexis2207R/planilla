
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h4>Usuarios</h4>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url() ?>">Panel Principal</a></li>
					<li class="breadcrumb-item active">Usuarios</li>
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
            <h3 class="card-title">Lista de Usuarios</h3>

            <div class="card-tools">
              <button id="btnNew" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-usuario">
                Agregar
              </button>
            </div>
          </div>
          <div class="card-body p-3">
            <table id="tbl_usuarios" class="table table-hover table-sm">
                <thead>
                    <tr>
                      <th class="text-center">Codigo</th>
                      <th>DNI</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Perfil</th>
                      <th class="text-center">Estado</th>
                      <th class="text-center">Acciones</th>
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

<!-- Modal Usuario -->
<div class="modal fade" id="modal-usuario">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Formulario Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" id="form_usuario" method="post">
        <div class="modal-body">
          <div class="row">

            <div class="col-lg-6">
              <div class="form-group">
                <label for="fordni">DNI <span class="text-danger">*</span></label>
                <div class="input-group input-group-sm">
                  <input type="text" name="dni" class="form-control form-control-sm" id="fordni" placeholder="Documento Nacional de Identidad">
                  <span class="input-group-append">
                    <button id="api_user" type="button" class="btn btn-info btn-flat"><i class="fas fa-search"></i></button>
                  </span>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="fornombre">Nombres <span class="text-danger">*</span></label>
                <input type="text" name="nombre" class="form-control form-control-sm" id="fornombre" placeholder="Nombres Completos">
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="forape">Apellidos <span class="text-danger">*</span></label>
                <input type="text" name="apellido" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label>Perfil <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="idperfil_usuario">
                  <option selected disabled>Seleccionar...</option>
                  <?php 
                    foreach ($Perfiles as $item) {
                      echo '<option value="'.$item['id_perfil'].'">'.$item['nombreperfil'].'</option>';
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


<script>
  $(document).ready(function(){
    usuarios();
  })
</script>