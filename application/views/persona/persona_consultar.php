<div class="box box-default"> 
  <div class="box-header with-border"> <!-- Box-Header -->
    <div class="col-md-12">
      <h4>Datos Personales 

      <?php 
        $id_usuario = $this->session->userdata('id_usuario');
        $metodo = 'Reportes/consultar_persona_informe';
        if( $this->seguridad_lib->validar_acceso_metodo($id_usuario,$metodo,false) ){
      ?>
        <span class="label">
          <button type="button" class="btn btn-default btn-sm" id="btn_informe" data-worker="<?=$this->seguridad_lib->execute_encryp($datos['id_dato_personal'],'encrypt','Persona');?>">
            <span class="glyphicon glyphicon-list" aria-hidden="true"></span> Informe
          </button>
        </span>
      <?php } ?>
      
      </h4>
    </div>
  </div> <!-- /Box-Header -->
  <div class="box-body"> <!-- Box-Body -->

    <div class="row">
      <div class="col-md-5 col-sm-12 col-md-push-6 text-center">
      <?php
        if(is_null($datos['imagen'])){
      ?>
        <img src="<?= base_url('assets/images/fotos/default.png'); ?>" class="user-image img-thumbnail" alt="User Image"> 
      <?php }else{ 
          $foto = base_url('assets/images/fotos/').$datos['imagen'];
          $data = @getimagesize($foto);
          if( $data == false ){ ?>
            <img src="<?= base_url('assets/images/fotos/default.png'); ?>" class="user-image img-thumbnail" alt="User Image">
          <?php }else{ ?> 
            <img src="<?=$foto;?>" class="user-image img-thumbnail" alt="User Image">
          <?php } ?>
        <?php } ?>
      </div>
      <br>

      <div class="col-md-offset-1 col-md-6 col-md-pull-5 col-sm-12">
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
          <div class="col-md-3 col-sm-3"><b>Sexo</b></div>
          <div class="col-md-3 col-sm-3">
            <?= ( $datos['sexo'] == 'M' )
              ?'<span class="label label-info">Masculino</span>'
              :'<span class="label label-danger">Femenino</span>' ; ?> 
          </div>
          <div class="col-md-3 col-sm-3"><b>Estatus</b></div>
          <div class="col-md-3 col-sm-3">
            <?= ( $datos['estatus'] == 't' )
              ?'<span class="label label-success">Activo</span>'
              :'<span class="label label-default">Inactivo</span>' ; ?> 
          </div>
        </div>

      </div>
    </div>

  <?php
    if(!is_null($datos['historial']) && count($datos['historial']) >0 ){ ?>
    <p class="divider"></p>
      <h4>Historial</h4>
        <div class="table-responsive">
          <table class="table table-hover" id="list">
            <thead>
              <tr>
                <th>Cargo</th>
                <th>Condición Laboral</th>
                <th>Coordinación</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Egreso</th>
              </tr>
            </thead>
            <tbody>
      <?php $i=0; foreach ($datos['historial'] as $key => $value) { ?>
              <tr>
                <td><?=$value['cargo'];?></td>
                <td><?=$value['condicion_laboral'];?></td>
                <td><?=$value['coordinacion'];?></td>
                <td><?=$value['fecha_ingreso'];?></td>
                <td><?=$value['fecha_egreso'];?></td>
              </tr>
      <?php } ?>
            </tbody>
          </table>
        </div>
      <?php } ?>

    <p class="divider"></p>
    <div class="row">
      <div class="col-md-offset-1 col-md-2">
        <a href="<?= base_url('Persona');?>" class="btn btn-danger">Volver</a>
      </div>
    </div>

  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
