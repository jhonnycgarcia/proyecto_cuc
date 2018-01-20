<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php 
        // Imprimir titulo 
        echo ( isset($titulo_contenedor) && !is_null($titulo_contenedor) )
          ?$titulo_contenedor
          :'';
      ?>
      <small>
      <?=
        ( isset($data_content) && array_key_exists('titulo_descripcion', $data_content) && !is_null($data_content['titulo_descripcion']) )
          ?$data_content['titulo_descripcion']
          :'';
      ?>
      </small>
    </h1>

<!--     <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
      <li class="active">Here</li>
    </ol> -->

  </section>

  <!-- Main content -->
  <section class="content">
<?php 
  
  // Cargar la vista correspondiente
  if ( isset($data_content) && array_key_exists('contenido_v', $data_content) && !is_null($data_content['contenido_v']) ) {
    $this->load->view( $data_content['contenido_v'] );
  }else{
    $this->load->view('Template/content/content_view'); 
  }

?>
  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper <!-- Content-Wrapper (Content Site) -->