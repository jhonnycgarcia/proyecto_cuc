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
          <?php
            $option_trabajador_id = array();
            $sql = $this->Usuarios_M->consultar_trabajadores();
            foreach ($sql as $key => $value) { $option_trabajador_id[$value['id_trabajador']] = $value['trabajador']; }

            echo form_dropdown('trabajador_id'
              ,$option_trabajador_id
              ,$trabajador_id
              ,array('class'=>'form-control')
            );
          ?>
        </div>
      </div>

      <div class="form-group" id="c_usuario">
        <label for="usuario" class="control-label col-md-2">Usuario:</label>
        <div class="col-md-10">
          <?=
            form_input('usuario',$usuario,array('class'=>'form-control','placeholder'=>'Usuario:'))
          ?>
          <?= form_error('usuario');?>
        </div>
      </div>

      <div class="form-group" id="c_clave">
        <label for="clave" class="control-label col-md-2">Clave:</label>
        <div class="col-md-10">
          <?=
            form_password('clave',$clave,array('class'=>'form-control','placeholder'=>'Clave:'))
          ?>
          <?= form_error('clave');?>
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