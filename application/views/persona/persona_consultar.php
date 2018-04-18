<div class="box box-default"> 
  <div class="box-header with-border"> <!-- Box-Header -->
    <h4>Datos Personales</h4>
  </div> <!-- /Box-Header -->
  <div class="box-body"> <!-- Box-Body -->

    <div class="row">
      <div class="col-md-offset-1 col-md-6 col-sm-12">
        <div class="row">
          <div class="col-md-3 col-sm-3"><b>Primer Apellido:</b></div>
          <div class="col-md-3 col-sm-3"><?=$datos['p_apellido'];?></div>
          <div class="col-md-3 col-sm-3"><b>Segundo Apellido:</b></div>
          <div class="col-md-3 col-sm-3"><?=$datos['s_apellido'];?></div>
        </div>

        <div class="row">
          <div class="col-md-3 col-sm-3"><b>Primer Nombre:</b></div>
          <div class="col-md-3 col-sm-3"><?=$datos['p_nombre'];?></div>
          <div class="col-md-3 col-sm-3"><b>Segundo Nombre:</b></div>
          <div class="col-md-3 col-sm-3"><?=$datos['s_nombre'];?></div>
        </div>

        <div class="row">
          <div class="col-md-3 col-sm-3"><b>Cedula:</b></div>
          <div class="col-md-3 col-sm-3"><?=$datos['cedula'];?></div>
          <div class="col-md-3 col-sm-3"><b>Fecha nacimiento:</b></div>
          <div class="col-md-3 col-sm-3"><?=$datos['fecha_nacimiento'];?></div>
        </div>

        <div class="row">
          <div class="col-md-3 col-sm-3"><b>Estado civil:</b></div>
          <div class="col-md-3 col-sm-3"><?=$datos['estado_civil'];?></div>
          <div class="col-md-3 col-sm-3"><b>Tipo sangre:</b></div>
          <div class="col-md-3 col-sm-3"><?=$datos['tipo_sangre'];?></div>
        </div>

        <div class="row">
          <div class="col-md-3 col-sm-3"><b>Email</b></div>
          <div class="col-md-9 col-sm-9"><?=$datos['email'];?></div>
        </div>

        <div class="row">
          <div class="col-md-3 col-sm-3"><b>Telefono principal</b></div>
          <div class="col-md-3 col-sm-3"><?=$datos['telefono_1'];?></div>
          <div class="col-md-3 col-sm-3"><b>Telefono secundario</b></div>
          <div class="col-md-3 col-sm-3"><?= (is_null($datos['telefono_2']))?"S/R":$datos['telefono_2'];?></div>
        </div>

        <div class="row">
          <div class="col-md-3 col-sm-3"><b>Dirección</b></div>
          <div class="col-md-9 col-sm-9"><?=$datos['direccion'];?></div>
        </div>

        <div class="row">
          <div class="col-md-3 col-sm-3"><b>Estatus</b></div>
          <div class="col-md-9 col-sm-9">
            <?= ( $datos['estatus'] == 't' )
              ?'<span class="label label-success">Activo</span>'
              :'<span class="label label-default">Inactivo</span>' ; ?> 
          </div>
        </div>

      </div>

      <div class="col-md-5 col-sm-12 text-center">
      <?php
        if(is_null($datos['imagen'])){
      ?>
        <img src="<?= base_url('assets/images/fotos/default.png'); ?>" class="user-image" alt="User Image"> 
      <?php
        }else{
          echo "string";
        }
      ?>
      </div>
    </div>
<br>

    <div class="row">
      <div class="col-md-offset-1 col-md-2">
        <a href="<?= base_url('Persona');?>" class="btn btn-danger">Volver</a>
      </div>
    </div>

  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
