<div class="box box-default"> 
  <!-- <div class="box-header with-border"> Box-Header -->
    <!-- <h4>Formulario</h4> -->
  <!-- </div> /Box-Header -->
  <div class="box-body"> <!-- Box-Body -->
<?php
  $form_attributes = array(
                'id' => 'form_menu'
                ,'class' => 'form-horizontal'
                  );
  echo form_open($form_action,$form_attributes);
?>
  <fieldset>
      <div class="form-group">
        <label for="menu" class="control-label col-md-2">Nombre:</label>
        <div class="col-md-10">
          <?php
            $attribute_nombre = array('class' => 'form-control','placeholder' => 'Nombre:');
            echo form_input('menu',$menu,$attribute_nombre);
            echo form_error('menu');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="link" class="control-label col-md-2">Link:</label>
        <div class="col-md-10">
          <?php
            $attribute_link = array('class' => 'form-control','placeholder' => 'Link:');
            echo form_input('link',$link,$attribute_link);
            echo form_error('link');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="icono" class="control-label col-md-2">Icono:</label>
        <div class="col-md-10">
          <?php
            $attribute_icono = array('class' => 'form-control','placeholder' => 'Icono:');
            echo form_input('icono',$icono,$attribute_icono);
            echo form_error('icono');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="visible_menu" class="control-label col-md-2">Listar:</label>
        <div class="col-md-10">
          <?php
            $option_visible_menu = array('t' =>'SI','f' => 'NO');
            $attribute_visible_menu = array('class' => 'form-control','id' => 'visible_menu');
            echo form_dropdown('visible_menu',$option_visible_menu,$visible_menu,$attribute_visible_menu);
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
        <label for="relacion" class="control-label col-md-2">Padre</label>
        <div class="col-md-10">
          <?php
            $option_relacion[0] = 'Si';
            $sql = $this->db->query("SELECT * FROM seguridad.obtener_items_menu();")->result_array();
            foreach ($sql as $key => $value) {
              $option_relacion[ $value['id'] ] = $value['menu'];
            }
            $attribute_relacion = array('class' => 'form-control','id' => 'relacion');
            echo form_dropdown('relacion',$option_relacion,$relacion,$attribute_relacion);
          ?>
        </div>
      </div>
      <div class="form-group">
        <label for="posicion" class="control-label col-md-2">Posicion:</label>
        <div class="col-md-10">
          <?php
            $attribute_posicion = array('class' => 'form-control','placeholder' => 'Posicion:','id' => 'posicion');
            echo form_input('posicion',$posicion,$attribute_posicion);
            echo form_error('posicion');
          ?>
        </div>  
      </div>
      <div class="form-group">
        <label for="rol_menu" class="col-md-2 control-label">Roles:</label>
        <div class="col-md-10">
          <?php

            $query = $this->db->select('a.id_rol,a.rol')->from('seguridad.roles AS a')
                        ->where( array('a.estatus' => 't') )->order_by('a.id_rol','ASC')->get()->result_array();
            if( count($query) > 0 ):

              foreach ($query as $key => $value) :
                $option_rol_menu[ $value['id_rol'] ] = $value['rol'];
              endforeach;

              ;else:
              $option_rol_menu[0] = '...';
            endif;
            $attribute_rol_menu = array('class' => 'form-control');
            echo form_multiselect('rol_menu[]',$option_rol_menu,$rol_menu,$attribute_rol_menu);
            echo form_error('rol_menu[]');
          ?>
        </div>
      </div>
      <div>
        <?php
          echo form_hidden('id_menu',$id_menu);
        ?>
      </div>
      <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
          <button class="btn btn-primary"><?= ( isset($btn_action ) )?$btn_action:'Procesar'; ?></button>
          <?php 
            $btn_cancelar = array('class' => 'btn btn-danger');
            echo anchor('Menu','Cancelar',$btn_cancelar);
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
