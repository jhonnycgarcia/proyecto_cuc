<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">

    <?php
      if( isset($titulo_contenedor) && !empty($titulo_contenedor) && !isset($titulo_descripcion) )
      { ?>
    <h1><?=$titulo_contenedor;?></h1>
    <?php }elseif(
      (isset($titulo_contenedor) && !empty($titulo_contenedor) )
      AND ( isset($titulo_descripcion) && !empty($titulo_descripcion) )
    )
    { ?>
    <h1><?=$titulo_contenedor;?><small><?=$titulo_descripcion;?></small></h1>
    <?php }elseif ( !isset($titulo_contenedor) && isset($titulo_descripcion) && !empty($titulo_descripcion) ) 
    { ?>
    <h1><small><?=$titulo_descripcion;?></small></h1>
    <?php } ?>

<!--     <h1>
      <?php 
        // Imprimir titulo 
        echo ( isset($titulo_contenedor) && !is_null($titulo_contenedor) && !empty($titulo_contenedor) )
          ?$titulo_contenedor
          :'';
      ?>
      <small>
      <?=
        ( isset($titulo_descripcion) && !is_null($titulo_descripcion) && !empty($titulo_descripcion) )
          ?$titulo_descripcion
          :'';
      ?>
      </small>
    </h1> -->

<!--     <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
      <li class="active">Here</li>
    </ol> -->

  </section>

  <!-- Main content -->
  <section class="content">
<?php 
  
  // Cargar la vista correspondiente
  if ( isset($contenido) && !is_null($contenido) && !empty($contenido) ) {
    $this->load->view( $contenido );
  }else{
    $this->load->view('Template/content/content_view'); 
  }

?>
  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->
<!-- Content-Wrapper (Content Site) -->