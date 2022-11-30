  <?php
    $Opciones = session()->get( 'Modulos' );
    $nombres = session()->get( 'nombres' );
    $perfil = session()->get( 'perfil' );
  ?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
          <button class="btn" title="Cerrar Sesión">
            <i id="logger" class="fas fa-power-off"></i>
          </button>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url()?>" class="brand-link">
      <!-- <img src="<?= base_url()?>/public/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <center><span class="brand-text font-weight-light">DRTC-SM</span></center>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel text-center">
        <div class="info">
          <a href="#" class=""><?= $nombres ?></a>
		  <p class="text-muted small"><?= $perfil ?></p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url()?>" class="nav-link active">
              <i class="nav-icon fas fa-home"></i>
              <p>Panel Principal</p>
            </a>
          </li>
          <?php
            if ( $Opciones ) {
              foreach ( $Opciones as $key => $op ) {
                if ( $op['idmodulopadre'] == null) {
                  echo '
                        <li class="nav-item">
                          <a href="'.base_url().$op['urlmodulo'].'" class="nav-link">
                            '.$op['iconomodulo'].'
                            <p>'.$op['nombremodulo'].'
                            <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">';
                            foreach ($Opciones as $key1 => $sp) {
                              if ( $op['id_modulo'] == $sp['idmodulopadre']) {
                                echo  '<li class="nav-item">
                                    <a href="'.base_url().$sp['urlmodulo'].'" class="nav-link">
                                    <i class="nav-icon fas fa-dot-circle"></i>
                                    <p>'. $sp['nombremodulo'].'</p>
                                    </a>
                                  </li>';
                              }
                            }
                          echo '</ul>
                      </li>';
                }
              }
            }

          ?>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>