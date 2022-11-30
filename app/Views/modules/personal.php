
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
      <div class="row justify-content-center col-lg-12">
        <div class="card col-lg">
          <div class="card-header">
            <h3 class="card-title">Lista de Personal</h3>

            <div class="card-tools">
              <button id="btnNew" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-personal">
                Agregar
              </button>
            </div>
          </div>
          <div class="card-body p-3">
            <table id="tbl_personal" class="table table-hover table-sm">
                <thead>
                    <tr>
                      <th class="text-center">Codigo</th>
                      <th class="text-center">DNI</th>
                      <th class="text-center">Nombres</th>
                      <th class="text-center">Apellido P</th>
                      <th class="text-center">Apellido M</th>
                      <th class="text-center">Sexo</th>
                      <th class="text-center">Nivel Remunereación</th>
                      <th class="text-center">Condición Laboral</th>
                      <th class="text-center">Ubicación</th>
                      <th class="text-center">Sueldo</th>
                      <th class="text-center">Incentivo</th>
                      <th class="text-center">Costo Día</th>
                      <th class="text-center">Costo Hora</th>
                      <th class="text-center">Costo Minuto</th>
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

<!-- Modal Perfil -->
<div class="modal fade" id="modal-personal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Formulario del Personal</h5>
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

            <div class="col-lg-3">
              <div class="form-group">
                <label for="fornombre">Nombres<span class="text-danger">*</span></label>
                <input type="text" name="nombre_personal" class="form-control form-control-sm" id="fornombre" placeholder="Nombres Completos">
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forapemater">Apellido Paterno <span class="text-danger">*</span></label>
                <input type="text" name="paterno_personal" class="form-control form-control-sm" id="forapemater" placeholder="Apellidos Completos">
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forape">Apellido Materno <span class="text-danger">*</span></label>
                <input type="text" name="materno_personal" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label>Sexo <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="sexo_personal">
                  <option selected disabled>Seleccionar...</option>
                  <option value="M">Masculino</option>
                  <option value="F">Femenino</option>
                  <option value="O">Otro</option>
                </select>
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label>Nivel Remunerativo <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="nivel_remuneracion">
                  <option selected disabled>Seleccionar...</option>
                  <?php 
                    foreach ($listaRemuneracion as $rem) {
                      echo '<option value="'.$rem['id_remuneracion'].'">'.$rem['nivel'].'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label>Condición Laboral <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="condicion_laboral">
                  <option selected disabled>Seleccionar...</option>
                  <?php 
                    foreach ($listaCondicion as $item) {
                      echo '<option value="'.$item['id_condicion'].'">'.$item['condicion'].'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forape">Sueldo <span class="text-danger">*</span></label>
                <input type="number" step="any" name="sueldo_personal" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forape">Incentivo <span class="text-danger">*</span></label>
                <input type="number" step="any" name="incentivo_personal" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forape">Costo día <span class="text-danger">*</span></label>
                <input type="number" step="any" name="costo_dia" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forape">Costo hora <span class="text-danger">*</span></label>
                <input type="number" step="any" name="costo_hora" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forape">Costo minuto <span class="text-danger">*</span></label>
                <input type="number" step="any" name="costo_minuto" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forapss">Dirección </label>
                <input type="text" name="direccion_personal" class="form-control form-control-sm" id="forapss" placeholder="Domicilio Actual">
              </div>
            </div>
            

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forape">Departamento </label>
                <input type="text" name="ubicacion_dpt" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forape"> Provincia </label>
                <input type="text" name="ubicacion_prov" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="forape">Distrito </label>
                <input type="text" name="ubicacion_dist" class="form-control form-control-sm" id="forape" placeholder="Apellidos Completos">
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
    personal();
  })
</script>