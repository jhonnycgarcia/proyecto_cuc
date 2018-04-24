<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->

  <div class="row">
    <label class="col-md-2" for="apellidos_nombres">Apellidos y nombres:</label>
    <div class="col-md-4"><?= $persona['apellidos_nombres']; ?></div>
    <label class="col-md-push-1 col-md-2" for="cedula">Cedula:</label>
    <div class="col-md-4"><?= $persona['cedula']; ?></div>
  </div>

<?php
  $form_attributes = array(
                'id' => 'form_trabajadores'
                ,'class' => 'form-horizontal'
                  );
  echo form_open($form_action,$form_attributes);
?>
    <fieldset>
      <div class="form-group">
        <label for="coordinacion_id" class="control-label col-md-2">Coordinación:</label>
        <div class="col-md-10">
          <?php
            $sql = $this->Trabajadores_M->obtener_coordinaciones();
            $opcion_coordinacion_id = array();
            foreach ($sql as $key => $value) {
              $opcion_coordinacion_id[$value['id_coordinacion']] = $value['coordinacion'];
            }
            echo form_dropdown('coordinacion_id'
                ,$opcion_coordinacion_id
                ,$coordinacion_id
                ,array('class' => 'form-control')+$coordinacion_id_opciones );
          ?>
        </div>  
      </div>
      
      <div class="form-group">
        <label for="condicion_laboral_id" class="control-label col-md-2">Condición laboral:</label>
        <div class="col-md-4">
          <?php
            $sql = $this->Trabajadores_M->obtener_condiciones_laborales();
            $opcion_condicion_laboral_id = array();
            foreach ($sql as $key => $value) {
              $opcion_condicion_laboral_id[$value['id_condicion_laboral']] = $value['condicion_laboral'];
            }
            echo form_dropdown('condicion_laboral_id'
                ,$opcion_condicion_laboral_id
                ,$condicion_laboral_id
                ,array('class' => 'form-control')+$condicion_laboral_id_opciones );  
          ?>
        </div>  
        <label for="cargo_id" class="control-label col-md-2">Cargo:</label>
        <div class="col-md-4">
          <?php
            $sql = $this->Trabajadores_M->obtener_cargos();
            $opcion_cargo_id = array();
            foreach ($sql as $key => $value) {
              $opcion_cargo_id[$value['id_cargo']] = $value['cargo'];
            }
            echo form_dropdown('cargo_id'
                ,$opcion_cargo_id
                ,$cargo_id
                ,array('class' => 'form-control')+$cargo_id_opciones );  
          ?>
        </div>  
      </div>
      
      <div class="form-group">
        <label for="fecha_ingreso" class="control-label col-md-2">Fecha de ingreso:</label>
        <div class="col-md-4">
          <?php
            echo form_input('fecha_ingreso',$fecha_ingreso,array('class' => 'form-control','placeholder' => 'dd/mm/aaaa')+$fecha_ingreso_opciones);
            echo form_error('fecha_ingreso');
          ?>
        </div> 
        <label for="fecha_egreso" class="control-label col-md-2">Fecha de egreso:</label>
        <div class="col-md-4">
          <?php
            echo form_input('fecha_egreso',$fecha_egreso,array('class' => 'form-control','placeholder' => 'dd/mm/aaaa')+$fecha_egreso_opciones);
            echo form_error('fecha_egreso');
          ?>
        </div>  
      </div>

      <div class="form-group">
        <label for="asistencia_obligatoria" class="control-label col-md-2">Asistencia obligatoria:</label>
        <div class="col-md-4">
          <?php
            $opcion_asistencia_obligatoria = array('t'=>'SI','f'=>'NO');
            echo form_dropdown('asistencia_obligatoria'
                  ,$opcion_asistencia_obligatoria
                  ,$asistencia_obligatoria
                  ,array('class' => 'form-control')+$asistencia_obligatoria_opciones );
            echo form_error('asistencia_obligatoria');
          ?>
        </div>
      </div>

      <div>
        <?= form_hidden('id_trabajador',$id_trabajador); ?>
        <?= form_hidden('dato_personal_id',$dato_personal_id); ?>
        <?= form_error('dato_personal_id'); ?>
      </div>

      <div class="form-group">
      </div>

      <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
          <button class="btn btn-primary"><?= ( isset($btn_action ) )?$btn_action:'Procesar'; ?></button>
          <?php 
            echo anchor($btn_cancelar,'Cancelar',array('class' => 'btn btn-danger'));
          ?>
        </div>
      </div>
    </fieldset>
<?= form_close(); ?>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
