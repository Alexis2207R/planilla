
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h4>Perfiles</h4>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url() ?>">Panel Principal</a></li>
					<li class="breadcrumb-item active">Perfiles</li>
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
            <h3 class="card-title">Lista de Perfiles</h3>

            <div class="card-tools">
              <button id="btnNew" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-perfil">
                Agregar
              </button>
            </div>
          </div>
          <div class="card-body p-3">
            <table id="tbl_perfiles" class="table table-hover table-sm">
                <thead>
                    <tr>
                      <th class="text-center">Codigo</th>
                      <th>Nombre de Perfil</th>
                      <th class="text-center">Accesos</th>
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

<!-- Modal Access -->
<div class="modal fade" id="modal-acceso">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Accesos a modulos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tbl-accesos" class="table table-hover table-sm">
          <thead>
            <tr>
              <th>Item</th>
              <th>Perfil</th>
              <th>Accesos</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- Modal Perfil -->
<div class="modal fade" id="modal-perfil">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Formulario Perfil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" id="form_perfil" method="post">
        <div class="modal-body">
          <div class="row">

            <div class="col-lg-12">
              <div class="form-group">
                <label for="forperfil">Nombre Perfil <span class="text-danger">*</span></label>
                <input type="text" name="nombreperfil" class="form-control form-control-sm" id="forperfil" placeholder="Nombre del Perfil">
              </div>
            </div>

            <?php 
              // var_dump($ListModulo);
            ?>
          </div>

          <div class="row">
            <div class="col-lg-12">
             <label>Accesos</label>
              <div class="row">

                <?php 
                  foreach ($ListModulo as $key => $mod) {
                    if ( $mod['idmodulopadre'] == null ) {
                      echo '<div class="col-sm-4">
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input check-'.$mod['id_modulo'].'" type="checkbox" name="permisos[]" value="'.$mod['id_modulo'].'">
                            <label class="form-check-label"><strong>'.$mod['nombremodulo'].'</strong></label>
                          </div>
                        </div>';
                        foreach ($ListModulo as $key1 => $submod) {
                          if ( $mod['id_modulo'] == $submod['idmodulopadre'] ) {
                            echo '<div class="form-group">
                              <div class="form-check">
                                <input class="form-check-input check-'.$submod['id_modulo'].'" type="checkbox" name="permisos[]" value="'.$submod['id_modulo'].'">
                                <label class="form-check-label">'.$submod['nombremodulo'].'</label>
                              </div>
                            </div>';
                          }
                        }
                      echo '</div>';
                    }
                  }
                ?>
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
    perfiles();
  })
</script>