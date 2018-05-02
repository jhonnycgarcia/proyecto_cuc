<div class="box box-default"> 
  <div class="box-header with-border"> <!-- Box-Header -->
    <!-- <h4>trabajador Personales</h4> -->
  </div> <!-- /Box-Header -->
  <div class="box-body"> <!-- Box-Body -->
    
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Apellidos y nombres:</b></div>
      <div class="col-md-9"><?=$usuario['apellidos_nombres'];?></div>
    </div>     
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Usuario:</b></div>
      <div class="col-md-9"><?=$usuario['usuario'];?></div>
    </div>      
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Rol:</b></div>
      <div class="col-md-9"><?=$usuario['rol'];?></div>
    </div>             
<!--     <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Estatus:</b></div>
      <div class="col-md-9">
        <?= ( $usuario['estatus'] == 't' )
          ?'<span class="label label-success">Activo</span>'
          :'<span class="label label-default">Inactivo</span>' ; ?> 
      </div>
    </div>  -->      
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Sesion activa:</b></div>
      <div class="col-md-9">
        <?= ( $usuario['sesion_activa'] == 't' )
          ?'<span class="label label-success">SI</span>'
          :'<span class="label label-default">NO</span>' ; ?> 
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-offset-1 col-md-2">
        <a href="<?= base_url('Usuarios');?>" class="btn btn-danger">Volver</a>
      </div>
    </div>

  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
