<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->

<?php
  echo form_open($form_action
      ,array(
          'id' => 'form_usuarios'
          ,'class' => 'form-horizontal'
                  )
  );
?>
    <fieldset>
      <div class="form-group" id="c_clave">
        <label for="clave_nueva" class="control-label col-md-2">Clave Nueva:</label>
        <div class="col-md-10">
          <?=
            form_password('clave_nueva',$clave_nueva,array('class'=>'form-control','placeholder'=>'Clave Actual:'))
          ?>
          <?= form_error('clave_nueva');?>
        </div>
      </div>

      <div class="form-group" id="c_re_clave">
        <label for="re_clave" class="control-label col-md-2">Confirmar clave:</label>
        <div class="col-md-10">
          <?=
            form_password('re_clave',$re_clave,array('class'=>'form-control','placeholder'=>'Confirmar clave:'))
          ?>
          <?= form_error('re_clave');?>
        </div>
      </div>

      <div>
        <?php
          echo form_hidden('id_usuario',$id_usuario);
        ?>
      </div>
      <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
          <button class="btn btn-primary"><?= ( isset($btn_action ) )?$btn_action:'Procesar'; ?></button>
          <?php 
            $btn_cancelar = array('class' => 'btn btn-danger');
            echo anchor('Usuarios','Cancelar',$btn_cancelar);
          ?>
        </div>
      </div>
    </fieldset>
<?= form_close(); ?>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
<script>
  var _base_url = "<?= base_url(); ?>";
</script>