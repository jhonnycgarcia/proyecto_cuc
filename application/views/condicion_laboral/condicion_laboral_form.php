<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->

<?php
  $form_attributes = array(
                'id' => 'form_condicion_laboral'
                ,'class' => 'form-horizontal'
                  );
  echo form_open($form_action,$form_attributes);
?>
    <fieldset>
      <div class="form-group">
        <label for="condicion_laboral" class="control-label col-md-2">Condición Laboral:</label>
        <div class="col-md-10">
          <?php
            $attribute_condicion_laboral = array('class' => 'form-control','placeholder' => 'Condición Laboral:');
            echo form_input('condicion_laboral',$condicion_laboral,$attribute_condicion_laboral);
            echo form_error('condicion_laboral');
          ?>
        </div>  
      </div>
      <div>
        <?php
          echo form_hidden('id_condicion_laboral',$id_condicion_laboral);
        ?>
      </div>
      <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
          <button class="btn btn-primary"><?= ( isset($btn_action ) )?$btn_action:'Procesar'; ?></button>
          <?php 
            $btn_cancelar = array('class' => 'btn btn-danger');
            echo anchor('Condicion_laboral','Cancelar',$btn_cancelar);
          ?>
        </div>
      </div>
    </fieldset>
<?= form_close(); ?>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
