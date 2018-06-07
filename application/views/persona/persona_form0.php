<div class="box box-default"> 
  <!-- <div class="box-header with-border"> Box-Header -->
    <!-- <h4>Formulario</h4> -->
  <!-- </div> /Box-Header -->
  <div class="box-body"> <!-- Box-Body -->
<?php
  $form_attributes = array(
                'id' => 'form_persona'
                ,'class' => 'form-horizontal'
                  );
  echo form_open($form_action,$form_attributes);
?>
  <fieldset>
      <!-- Apellidos  -->
      <div class="form-group">
        <label for="p_apellido" class="control-label col-md-2">Primer Apellido:</label>
        <div class="col-md-4">
          <?php
            echo form_input('p_apellido'
                ,$p_apellido
                ,array('class' => 'form-control','placeholder' => 'Primer Apellido:')
              );
            echo form_error('p_apellido');
          ?>
        </div>
        <label for="s_apellido" class="control-label col-md-2">Segundo Apellido:</label>
        <div class="col-md-4">
          <?php
            echo form_input('s_apellido'
                ,$s_apellido
                ,array('class' => 'form-control','placeholder' => 'Segundo Apellido:')
              );
            echo form_error('s_apellido');
          ?>
        </div>
      </div>
      <!-- Nombres -->
      <div class="form-group">
        <label for="p_nombre" class="control-label col-md-2">Primer Nombre:</label>
        <div class="col-md-4">
          <?php
            echo form_input('p_nombre'
                ,$p_nombre
                ,array('class' => 'form-control','placeholder' => 'Primer Nombre:')
              );
            echo form_error('p_nombre');
          ?>
        </div>
        <label for="s_nombre" class="control-label col-md-2">Segundo Nombre:</label>
        <div class="col-md-4">
          <?php
            echo form_input('s_nombre'
                ,$s_nombre
                ,array('class' => 'form-control','placeholder' => 'Segundo Nombre:')
              );
            echo form_error('s_nombre');
          ?>
        </div>
      </div>
      
      <div class="form-group">
        <label for="cedula" class="control-label col-md-2">Cedula:</label>
        <div class="col-md-4">
          <?php
            echo form_input('cedula'
                ,$cedula
                ,array('class' => 'form-control','placeholder' => 'Cedula:','maxlength'=>'8')+$cedula_config
              );
            echo form_error('cedula');
          ?>
        </div>
        <label for="fecha_nacimiento" class="control-label col-md-2">Fecha nacimiento:</label>
        <div class="col-md-4">
          <?php
            echo form_input('fecha_nacimiento'
                ,$fecha_nacimiento
                ,array('class' => 'form-control','placeholder' => 'dd/mm/aaaa')
              );
            echo form_error('fecha_nacimiento');
          ?>
        </div>
      </div> 
      
      <div class="form-group">
        <label for="estado_civil_id" class="control-label col-md-2">Estado civil:</label>
        <div class="col-md-4">
          <?php

            $sql = $this->Persona_M->lista_estado_civil();
            $opcion_estado_civil = array();
            foreach ($sql as $key => $value) {
              $opcion_estado_civil[$value['id_estado_civil']]=$value['estado_civil'];
            }

            echo form_dropdown("estado_civil_id",
                $opcion_estado_civil,
                $estado_civil_id,
                array('class' => 'form-control')
              );
            echo form_error('estado_civil_id');
          ?>
        </div>
        <label for="tipo_sangre_id" class="control-label col-md-2">Tipo sangre:</label>
        <div class="col-md-4">
          <?php

            $sql = $this->Persona_M->lista_tipos_sangre();
            $opcion_tipo_sangre = array();
            foreach ($sql as $key => $value) {
              $opcion_tipo_sangre[$value['id_tipo_sangre']]=$value['tipo_sangre'];
            }

            echo form_dropdown("tipo_sangre_id",
                $opcion_tipo_sangre,
                $tipo_sangre_id,
                array('class' => 'form-control')
              );
            echo form_error('tipo_sangre_id');
          ?>
        </div>
      </div>     

      <div class="form-group">
        <label for="email" class="control-label col-md-2">Sexo:</label>
        <div class="col-md-4">
          <?=
            form_dropdown('sexo',array('M'=>'Masculino','F'=>'Femenino'),$sexo,array('class' => 'form-control'));
          ?>
        </div>
        <label for="email" class="control-label col-md-2">Email:</label>
        <div class="col-md-4">
          <?php
            echo form_input('email'
                ,$email
                ,array('class' => 'form-control','placeholder' => 'Email:')
              );
            echo form_error('email');
          ?>
        </div>
      </div>

      <div class="form-group">
        <label for="telefono_1" class="control-label col-md-2">Telefono principal:</label>
        <div class="col-md-4">
          <?php
            echo form_input('telefono_1'
                ,$telefono_1
                ,array('class' => 'form-control','placeholder' => 'Telefono principal:')
              );
            echo form_error('telefono_1');
          ?>
        </div>
        <label for="telefono_2" class="control-label col-md-2">Telefono secundario:</label>
        <div class="col-md-4">
          <?php
            echo form_input('telefono_2'
                ,$telefono_2
                ,array('class' => 'form-control','placeholder' => 'Telefono secundario:')
              );
            echo form_error('telefono_2');
          ?>
        </div>
      </div> 

      <div class="form-group">
        <label for="direccion" class="control-label col-md-2">Dirección:</label>
        <div class="col-md-10">
          <?php
            echo form_textarea('direccion'
                ,$direccion
                ,array('class' => 'form-control','placeholder' => 'Dirección:','style' => 'resize: vertical;','id'=>'direccion')
              );
            echo form_error('direccion');
          ?>
        </div>
      </div>

      <div>
        <?= form_hidden('id_dato_personal',$id_dato_personal); ?>
      </div> 

      <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
          <button class="btn btn-primary"><?= ( isset($btn_action ) )?$btn_action:'Procesar'; ?></button>
          <?php 
            $btn_cancelar = array('class' => 'btn btn-danger');
            echo anchor('Persona','Cancelar',$btn_cancelar);
          ?>
        </div>
      </div>
    </fieldset>
  </div> <!-- /Box-Body -->
  <!-- <div class="box-footer"> Box-Header -->
  	<!-- Lorem ipsum dolor sit amet. [FOOTER] -->
  <!-- </div> -->
</div>
<!-- Your Page Content Here -->
