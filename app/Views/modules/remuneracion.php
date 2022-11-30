
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h4>Nivel Remunerativo</h4>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url() ?>">Panel Principal</a></li>
					<li class="breadcrumb-item active">Remuneración</li>
					</ol>
				</div>
			</div>
		</div>
	</section>

    <section class="content">
      <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Niveles Remunerativos</h3>
                    </div>
                    <div class="card-body p-3">
                        <table id="tbl_nivel" class="table table-hover table-sm">
                            <thead>
                                <tr>
                                <th class="text-center">Item</th>
                                <th>Nivel Remuneración</th>
                                <th class="text-center">Fecha Actualización</th>
                                <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Formulario Remuneración</h3>
                    </div>
                    <form class="form" id="form_nivel" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nivel">Nivel de Remuneración</label>
                                <input type="text" class="form-control" name="nivel" id="nivel" placeholder="Ingresar el nivel remunerativo">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                            <button id="btnCancel" type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->


<script>
  $(document).ready(function(){
    renumeracion();
  })
</script>