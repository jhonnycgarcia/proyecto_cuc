<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
<?php
  $form_attributes = array(
                'id' => 'form_roles'
                ,'class' => 'form-horizontal'
                  );
  echo form_open($form_action,$form_attributes);
?>
    <fieldset>
      <div class="form-group">
        <label for="rol" class="control-label col-md-2">Rol:</label>
        <div class="col-md-10">
          <?php
            $attribute_rol = array('class' => 'form-control','placeholder' => 'Rol:');
            echo form_input('rol',$rol,$attribute_rol);
            echo form_error('rol');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="estatus" class="control-label col-md-2">Estatus:</label>
        <div class="col-md-10">
          <?php
            $option_estatus = array('t' =>'Activado','f' => 'Inactivo');
            $attribute_estatus = array('class' => 'form-control');
            echo form_dropdown('estatus',$option_estatus,$estatus,$attribute_estatus);
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="descripcion" class="control-label col-md-2">Descripcion:</label>
        <div class="col-md-10">
          <?php
            $attribute_descripcion = array('class' => 'form-control','placeholder' => 'Descripcion:', 'style' => 'resize: vertical;');
            echo form_textarea('descripcion',$descripcion,$attribute_descripcion);
            echo form_error('descripcion');
          ?>
        </div>  
      </div>
      <div>
        <?php
          echo form_hidden('id',$id);
        ?>
      </div>
      <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
          <button class="btn btn-primary"><?= ( isset($btn_action ) )?$btn_action:'Procesar'; ?></button>
          <?php 
            $btn_cancelar = array('class' => 'btn btn-danger');
            echo anchor('Roles','Cancelar',$btn_cancelar);
          ?>
        </div>
      </div>
    </fieldset>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
