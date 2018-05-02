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
      <div class="form-group">
        <label for="trabajador_id" class="control-label col-md-2">Trabajador:</label>
        <div class="col-md-10">
          <?= $usuario['apellidos_nombres'];?>
        </div>
      </div>

      <div class="form-group" id="c_usuario">
        <label for="usuario" class="control-label col-md-2">Usuario:</label>
        <div class="col-md-10">
          <?= $usuario['usuario'];?>
        </div>
      </div>

      <div class="form-group" id="c_rol_id">
        <label for="rol_id" class="control-label col-md-2">Rol:</label>
        <div class="col-md-10">
          <?php
            $option_rol_id = array();
            $sql = $this->Usuarios_M->consultar_roles();
            foreach ($sql as $key => $value) { $option_rol_id[$value['id_rol']] = $value['rol']; }

            echo form_dropdown('rol_id'
              ,$option_rol_id
              ,$rol_id
              ,array('class'=>'form-control')
            );
          ?>
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