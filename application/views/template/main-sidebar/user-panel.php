<!-- Sidebar user panel (optional) -->
<div class="user-panel">
  <div class="pull-left image">
      <?php if( is_null($this->template_lib->obtener_imagen_usuario()) ){ ?>
        <img src="<?= base_url('assets/images/fotos/default.png'); ?>" class="img-circle" alt="User Image"> 
      <?php }else{
          $name_file = $this->template_lib->obtener_imagen_usuario();
          $foto = base_url('assets/images/fotos/').$name_file;
          $data = @getimagesize($foto);
          if( $data == FALSE ){ ?>
          <img src="<?= base_url('assets/images/fotos/default.png'); ?>" class="img-circle" alt="User Image"> 
        <?php }else{?>
        	<img src="<?= $foto; ?>" class="img-circle" alt="User Image"> 
        <?php }?>
      <?php }?>
     <!-- <img src="<?= base_url('assets/AdminLTE/dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">  -->
     <!-- <img src="<?= base_url('assets/images/fotos/default.png'); ?>" class="img-circle" alt="User Image">  -->
  </div>
  <div class="pull-left info">
    <p><?= $this->session->userdata('apellidos_nombres');?></p>
    <!-- Status -->
    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
  </div>
</div>
