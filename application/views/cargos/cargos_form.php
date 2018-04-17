<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->

<?php
  $form_attributes = array(
                'id' => 'form_cargos'
                ,'class' => 'form-horizontal'
                  );
  echo form_open($form_action,$form_attributes);
?>
    <fieldset>
      <div class="form-group">
        <label for="cargo" class="control-label col-md-2">Cargo:</label>
        <div class="col-md-10">
          <?php
            $attribute_cargo = array('class' => 'form-control','placeholder' => 'Cargo:');
            echo form_input('cargo',$cargo,$attribute_cargo);
            echo form_error('cargo');
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
      <div>
        <?php
          echo form_hidden('id_cargo',$id_cargo);
        ?>
      </div>
      <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
          <button class="btn btn-primary"><?= ( isset($btn_action ) )?$btn_action:'Procesar'; ?></button>
          <?php 
            $btn_cancelar = array('class' => 'btn btn-danger');
            echo anchor('Cargos','Cancelar',$btn_cancelar);
          ?>
        </div>
      </div>
    </fieldset>
<?= form_close(); ?>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
