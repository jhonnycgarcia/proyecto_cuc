<!-- Sidebar user panel (optional) -->
<div class="user-panel">
  <div class="pull-left image">
    <img src="<?= base_url('assets/fotos_personal/'.$this->session->userdata('cedula').'.jpg'); ?>" class="img-circle" alt="User Image">
    <!-- <img src="<?= base_url('assets/AdminLTE/dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image"> <--></-->
  </div>
  <div class="pull-left info">
    <p><?= $this->session->userdata('apellidos_nombres');?></p>
    <!-- Status -->
    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
  </div>
</div>
