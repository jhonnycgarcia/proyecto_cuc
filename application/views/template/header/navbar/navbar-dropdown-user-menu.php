<!-- User Account Menu -->
<li class="dropdown user user-menu">
  <!-- Menu Toggle Button -->
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <!-- The user image in the navbar-->
    <img src="<?= base_url('assets/images/fotos/default.png'); ?>" class="user-image" alt="User Image">
    <!-- <img src="<?= base_url('assets/AdminLTE/dist/img/user2-160x160.jpg'); ?>" class="user-image" alt="User Image"> -->
    <!-- hidden-xs hides the username on small devices so only the image appears. -->
    <span class="hidden-xs"><?= $this->session->userdata('apellidos_nombres');?></span>
  </a>
  <ul class="dropdown-menu">
    <!-- The user image in the menu -->
    <li class="user-header">
      <img src="<?= base_url('assets/images/fotos/default.png'); ?>" class="img-circle" alt="User Image">
      <!-- <img src="<?= base_url('assets/AdminLTE/dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image"> -->

      <p>
        <?= $this->session->userdata('apellidos_nombres'); ?>
        <small><?= $this->session->userdata('rol'); ?></small>
        <!-- <small>Member since Nov. 2012</small> -->
      </p>
    </li>
    <!-- Menu Footer-->
    <li class="user-footer">
      <div class="pull-right">
        <a href="<?= base_url('salir'); ?>" class="btn btn-default btn-flat">Cerrar sesion</a>        <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
      </div>
    </li>
  </ul>
</li> <!-- Dropdown-User-Panel -->
            
