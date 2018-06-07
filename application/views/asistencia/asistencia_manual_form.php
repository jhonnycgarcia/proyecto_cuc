<style>
  .camara{
    background-color: #000000;
    /*background-color: #B3B3B3;*/
    height: 240px;
    min-height: 240px;
    min-width: 240px;
  }
</style>

<!--  Cargar ventana MODAL  --> 
<div class="modal modal-default fade" id="mymodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Header de la ventana1 -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hiden="true" onclick="remove_modal();">&times;</button>
        <h4 class="modal-title"></h4>
      </div>

      <!-- Contenido de la ventana1 -->
      <div class="modal-body">
        <h4 id="mensaje"></h4>
        <!-- <p id="mensaje"></p> -->
      </div>

      <!-- Footer de la ventana1 -->
      <div class="modal-footer">
        <button class="btn btn-outline" data-dismiss="modal" onclick="remove_modal();">Cerrar</button>
      </div>

    </div>
  </div>
</div>

<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->

<?php
  $form_attributes = array(
                'id' => 'form_asistencia'
                ,'class' => 'form-horizontal'
                  );
  echo form_open($form_action,$form_attributes);
?>
    <fieldset>
      <div class="form-group hidden" id="contenedor_camara">
        <div class=" col-md-offset-2 col-md-10 text-center">
          <div class="camara" id="webcam">
          </div>
        </div>
      </div>
      <div class="form-group">
          <label for="cedula" class="control-label col-md-2">Cedula:</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Cedula:" name="cedula" id="cedula" disabled="disabled">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="consultar" disabled="disabled">Consultar</button>
              </span>
            </div>
          </div>
      </div>
      <div class="form-group">
        <label for="nombres" class="control-label col-md-2">Nombres:</label>
        <div class="col-md-10">
          <?php
            echo form_input('nombres'
              ,''
              ,array('class' => 'form-control','placeholder' => 'Nombres:','id'=>'nombres','disabled'=>'disabled')
            );
          ?>
        </div>
      </div>
      <div class="form-group">
        <label for="apellidos" class="control-label col-md-2">Apellidos:</label>
        <div class="col-md-10">
          <?php
            echo form_input('apellidos'
              ,''
              ,array('class' => 'form-control','placeholder' => 'Apellidos:','id'=>'apellidos','disabled'=>'disabled')
            );
          ?>
        </div>
      </div>
      <div class="form-group">
        <label for="departamento" class="control-label col-md-2">Departamento:</label>
        <div class="col-md-10">
          <?php
            echo form_input('departamento'
              ,''
              ,array('class' => 'form-control','placeholder' => 'Departamento:','id'=>'departamento','disabled'=>'disabled')
            );
          ?>
        </div>
      </div>
      <div class="form-group">
        <label for="cargo" class="control-label col-md-2">Cargo:</label>
        <div class="col-md-10">
          <?php
            echo form_input('cargo'
              ,''
              ,array('class' => 'form-control','placeholder' => 'Cargo:','id'=>'cargo','disabled'=>'disabled')
            );
          ?>
        </div>
      </div>
      <div class="form-group">
        <label for="fecha" class="control-label col-md-2">Fecha:</label>
        <div class="col-md-10">
          <?php
            echo form_input('fecha'
              ,''
              ,array('class' => 'form-control','id'=>'fecha','placeholder' => 'dd/mm/yyyy','disabled'=>'disabled')
            );
          ?>
        </div>
      </div>
      <div class="form-group">
        <label for="hora" class="control-label col-md-2">Hora:</label>
        <div class="col-md-10">
          <?php
            echo form_input('hora'
              ,''
              ,array('class' => 'form-control timepicker','id'=>'hora','placeholder' => 'hh:mm','disabled'=>'disabled')
            );
          ?>
        </div>
      </div>
      <div class="form-group">
        <label for="observaciones" class="control-label col-md-2">Observación:</label>
        <div class="col-md-10">
          <!-- <textarea name="observaciones" id="observaciones" cols="30" rows="1" class="form-control"></textarea> -->
          <?=
          form_textarea('observaciones','',array('rows'=>'1','class' => 'form-control','id'=>'observaciones','disabled'=>'disabled','style' => 'resize: vertical;','cols'=>'30'));
          ?>
        </div>
      </div>
      <div>
        <input type="hidden" name="imagen" id="imagen" value="">
        <input type="hidden" name="tipo_registro" id="tipo_registro" value="">
        <input type="hidden" name="trabajador_id" id="trabajador_id" value="">
      </div>

      <div class="form-group">
        <div class="col-md-4 col-md-offset-2">
          <button class="btn btn-primary" disabled="disabled" id="entrada">ENTRADA</button>
          <button class="btn btn-danger" disabled="disabled" id="salida">SALIDA</button>
          <button class="btn btn-warning" disabled="disabled" id="limpiar">Limpiar</button>
        </div>
      </div>
    </fieldset>
<?= form_close(); ?>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->

<script>
  var _base_url = "<?=base_url();?>";
  var _mensaje = JSON.parse('<?= $mensaje_modal; ?>');
  var _configuracion = JSON.parse('<?= $configuracion; ?>');
</script>
