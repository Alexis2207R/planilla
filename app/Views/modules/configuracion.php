
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h4>Configuración</h4>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url() ?>">Panel Principal</a></li>
					<li class="breadcrumb-item active">Configuración</li>
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
            <h3 class="card-title">Información Local</h3>
          </div>
          <?= print_r($Configuracion[0]['id']) ?>
          <div class="card-body p-3">
            <div class="row">
            <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-group-sm"> Número RUC</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" value="<?= $Configuracion[0]['ruc'] ?>">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Nombre Comercial</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" value="<?= $Configuracion[0]['nombre'] ?>">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Razón Social</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" value="<?= $Configuracion[0]['razon_social'] ?>">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Dirección</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" value="<?= $Configuracion[0]['direccion'] ?>">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Teléfono</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" value="<?= $Configuracion[0]['telefono'] ?>">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> País</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" value="<?= $Configuracion[0]['pais'] ?>">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Ciudad</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" value="<?= $Configuracion[0]['ciudad'] ?>">
                    </div>
                </div>

            </div>
          </div>
          <!-- /.card-body -->
        </div>
    </div>
      <!-- /.card -->

    </section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script>
//   $(document).ready(function(){
//     usuarios();
//   })
</script>