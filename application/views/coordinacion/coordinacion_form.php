<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->

<?php
  $form_attributes = array(
                'id' => 'form_coordinacion'
                ,'class' => 'form-horizontal'
                  );
  echo form_open($form_action,$form_attributes);
?>
    <fieldset>
      <div class="form-group">
        <label for="coordinacion" class="control-label col-md-2">Coordinación:</label>
        <div class="col-md-10">
          <?php
            $attribute_coordinacion = array('class' => 'form-control','placeholder' => 'Coordinación:');
            echo form_input('coordinacion',$coordinacion,$attribute_coordinacion);
            echo form_error('coordinacion');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="descripcion" class="control-label col-md-2">Descripción:</label>
        <div class="col-md-10">
          <?php
            $attribute_descripcion = array('class' => 'form-control','placeholder' => 'Descripción:',  'style' => 'resize: vertical;');
            echo form_textarea('descripcion',$descripcion,$attribute_descripcion);
            echo form_error('descripcion');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="estatus" class="control-label col-md-2">Estatus:</label>
        <div class="col-md-10">
          <?php
            $option_estatus = array('t' =>'Activo','f' => 'Inactivo');
            $attribute_estatus = array('class' => 'form-control');
            echo form_dropdown('estatus',$option_estatus,$estatus,$attribute_estatus);
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="direccion_id" class="control-label col-md-2">Direccion:</label>
        <div class="col-md-10">
          <?php
            $direcciones = $this->Coordinacion_M->obtener_direcciones(TRUE);
            foreach ($direcciones as $key => $value) {$option_direccion_id[$value['id_direccion']] = $value['direccion'];}
            $attribute_direccion_id = array('class' => 'form-control');
            echo form_dropdown('direccion_id',$option_direccion_id,$direccion_id,$attribute_direccion_id);
          ?>
        </div>  
      </div>
      <div>
        <?php
          echo form_hidden('id_coordinacion',$id_coordinacion);
        ?>
      </div>
      <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
          <button class="btn btn-primary"><?= ( isset($btn_action ) )?$btn_action:'Procesar'; ?></button>
          <?php 
            $btn_cancelar = array('class' => 'btn btn-danger');
            echo anchor('Coordinacion','Cancelar',$btn_cancelar);
          ?>
        </div>
      </div>
    </fieldset>
<?= form_close(); ?>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
