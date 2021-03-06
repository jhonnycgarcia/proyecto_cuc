<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->

<?php
  $form_attributes = array(
                'id' => 'form_configuraciones'
                ,'class' => 'form-horizontal'
                ,'autocomplete' => 'off'
                  );
  echo form_open($form_action,$form_attributes);
?>
    <fieldset>
      <div class="form-group">
        <label for="tema_template" class="control-label col-md-2">Color del tema:</label>
        <div class="col-md-10">
          <?php
            echo form_dropdown(
              'tema_template',
              array(
                  "skin-blue"=>'Azul',
                  "skin-blue-light"=>'Azul Palido',
                  "skin-black"=>'Negro',
                  "skin-black-light"=>'Negro Palido',
                  "skin-purple"=>'Purpura',
                  "skin-purple-light"=>'Purpura Palido',
                  "skin-yellow"=>'Amarillo',
                  "skin-yellow-light"=>'Amarillo Palido',
                  "skin-red"=>'Rojo',
                  "skin-red-light"=>'Rojo Palido',
                  "skin-green"=>'Verde',
                  "skin-green-light"=>'Verde Palido'
                ),
              $tema_template,
              array('class' => 'form-control')
            );
            echo form_error('tema_template');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="tiempo_max_inactividad" class="control-label col-md-2">Tiempo maximo de inactividad:</label>
        <div class="col-md-10">
          <?php
            echo form_input('tiempo_max_inactividad'
              ,$tiempo_max_inactividad
              ,array('class' => 'form-control','placeholder' => 'Tiempo maximo de inactividad:'));
            echo form_error('tiempo_max_inactividad');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="tiempo_max_alerta" class="control-label col-md-2">Tiempo maximo de alerta:</label>
        <div class="col-md-10">
          <?php
            echo form_input('tiempo_max_alerta'
              ,$tiempo_max_alerta
              ,array('class' => 'form-control','placeholder' => 'Tiempo maximo de alerta:'));
            echo form_error('tiempo_max_alerta');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="tiempo_max_espera" class="control-label col-md-2">Tiempo maximo de espera:</label>
        <div class="col-md-10">
          <?php
            echo form_input('tiempo_max_espera'
              ,$tiempo_max_espera
              ,array('class' => 'form-control','placeholder' => 'Tiempo maximo de espera:'));
            echo form_error('tiempo_max_espera');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="camara" class="control-label col-md-2">Uso de cámara:</label>
        <div class="col-md-10">
          <?php
            echo form_dropdown('camara',array('t' =>'Obligatorio','f' => 'No requerido'),$camara,array('class' => 'form-control'));
            echo form_error('camara');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="hora_inicio" class="control-label col-md-2">Hora Inicio:</label>
        <div class="col-md-4">
          <?php
            echo form_input('hora_inicio'
              ,$hora_inicio
              ,array('class' => 'form-control','id'=>'hora_inicio','readonly'=>'readonly'));
            echo form_error('hora_inicio');
          ?>
        </div> 
        <label for="hora_fin" class="control-label col-md-2">Hora Fin:</label>
        <div class="col-md-4">
          <?php
            echo form_input('hora_fin'
              ,$hora_fin
              ,array('class' => 'form-control','id'=>'hora_fin','readonly'=>'readonly'));
            echo form_error('hora_fin');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="dias_laborales" class="control-label col-md-2">Dias Laborales:</label>
        <div class="col-md-10">
          <?php
            echo form_multiselect('dias_laborales[]'
              ,array(
                '0' =>'Domingo'
                ,'1' =>'Lunes'
                ,'2' =>'Martes'
                ,'3' =>'Miercoles'
                ,'4' =>'Jueves'
                ,'5' =>'Viernes'
                ,'6' => 'Sabado')
              ,$dias_laborales
              ,array('class' => 'form-control')
            );
            echo form_error('dias_laborales[]');
          ?>
        </div>
      </div>
      <div>
        <?= form_hidden('id_configuracion',$id_configuracion);?>
      </div>
      <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
          <button class="btn btn-primary"><?= ( isset($btn_action ) )?$btn_action:'Procesar'; ?></button>
          <?php 
            $btn_cancelar = array('class' => 'btn btn-danger');
            echo anchor('Configuraciones','Cancelar',$btn_cancelar);
          ?>
        </div>
      </div>
    </fieldset>
<?= form_close(); ?>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
