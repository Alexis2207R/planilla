<?php echo view('include/header'); ?>
<?php 
// var_dump($persona);
// die; 
?>
<!-- Main content -->
<section class="invoice">
  <h2 class="page-header text-center">PLANILLA ANUAL - NORMA DE PAGOS: HABERES DEL AÑO <?= $persona[0]['nombre_year']?></h2>
  <br>
  <!-- title row -->
  <div class="row">
    <div class="col-12">
      <h2 class="page-header">
        <img src="<?= base_url().'/public/dist/img/DRTC.png'?>" width="40px" alt=""> S.M.TRANSP. - DRTC-SM
        <small class="float-right">Fecha: 21/12/202</small>
      </h2>
      <h2>NRO RUC: 20178677684</h2>
    </div>
    <!-- /.col -->
  </div>
  <div class="row">
    <!-- accepted payments column -->
    <div class="col-6">
      <p class="lead">CONTROL Y AUDITORIA:</p>
      <div class="container">
        <div class="row align-items-start">
          <div class="col">
            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
              200.9001.3999999.5000006.15.006.0012
            </p>
          </div>
          <div class="col">
            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
              0025 CONTROL Y AUDITORIA
            </p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row align-items-start">
          <div class="col">
            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
              DEPENDECIA: 0000000000330000
            </p>
          </div>
          <div class="col">
            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
              CONTROL Y AUDITORIA
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- Table -->
  <div class="row invoice-info">
    <!-- /.col -->
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead class="thead-dark">
            <th>ATRIBUTOS</th>
            <th>TRABAJADOR</th>
          </thead>
          <tr>
            <th>Nombres</th>
            <td><?= $persona[0]['nombre_personal']?></td>
          </tr>
          <tr>
            <th>Apellidos</th>
            <td><?= $persona[0]['apellido_personal'] ?></td>
          </tr>
          <tr>
            <th>Nro. Cuenta</th>
            <td><?= $persona[0]['nro_cuenta'] ?></td>
          </tr>
          <tr>
            <th>Reg. Pens</th>
            <td><?= $persona[0]['id_regimen'] ?></td>
          </tr>
          <tr>
            <th>Cond. Lab</th>
            <td><?= $persona[0]['id_condicion'] ?></td>
          </tr>
          <tr>
            <th>Nivel Rem.</th>
            <td><?= $persona[0]['id_remuneracion'] ?></td>
          </tr>
          <tr>
            <th>Cargo Estructural</th>
            <td><?= $persona[0]['id_cargo'] ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <!-- / Table -->
  <!-- Table row -->
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <th>MES</th>
            <?php 
              foreach ($bonificaciones as $bonificacion) {
                echo '<th>' . $bonificacion['nombre_bonificacion'] . '</th>';
              }
            ?>
            <th>TOTAL INGRESO</th>
            <?php 
              foreach ($descuentos as $descuento) {
                echo '<th>' . $descuento['nombre_descuento'] . '</th>';
              }
            ?>
            <th>TOTAL EGRESO</th>
            <th>TOTAL NETO</th>
          </tr>
        </thead>
        <?php
          foreach ($persona as $p) {
        ?>
        <tbody>
          <tr>
            <td><?= $p['nombre_mes'] ?></td>
            <?php 
              foreach ($bonificaciones as $bonificacion) {
                echo '<td class="text-center">' . $bonificacion['cantidad_bonificacion'] . '</td>';
              }
            ?>
            <td class="text-center"><?= $p['total_ingreso'] ?></td>
            <?php 
              foreach ($descuentos as $descuento) {
                echo '<td class="text-center">' . $descuento['cantidad_descuento'] . '</td>';
              }
            ?>
            <td class="text-center"><?= $p['total_egreso'] ?></td>
            <td class="text-center"><?= $p['total_neto'] ?></td>
          </tr>
        </tbody>
        <?php 
          }
        ?>
        <tfoot class="table table-striped">
          <tr>
            <th>TOTAL</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>
              <?php
                $total = 0;
                foreach ($persona as $p) {
                  $total += $p['total_neto'];
                }
                echo '<td class="text-center">' . $total . '</td>';
              ?>
            </th>
          </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

<?php echo view('include/footer'); ?>