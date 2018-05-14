<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
<?=
  form_open(
    $form_action,
    array(
      'id' => 'form_consulta_asistencia'
      ,'class' => 'form-horizontal'
      ,'target' => '_blank'
      )
  );
?>
  <fieldset>
    <div class="form-group">
      <label for="fechas" class="control-label col-md-2">Fechas:</label>
      <div class="col-md-10">
        <div class="input-group input-daterange">
            <input type="text" name="fdesde" id="fdesde" class="form-control" value="">
            <div class="input-group-addon">Hasta</div>
            <input type="text" name="fhasta" id="fhasta" class="form-control" value="">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="cargos" class="control-label col-md-2">Cargos a excluir:</label>
      <div class="col-md-10">
        <?php
          $lista = $this->Reportes_M->obtener_cargos();
          $opciones_cargos = array();
          foreach ($lista as $key => $value) {
            $opciones_cargos[$value['id_cargo']] = $value['cargo'];
          }
          echo form_multiselect('cargos_excluidos[]'
            ,$opciones_cargos
            ,array()
            ,array('class'=>'form-control','id'=>'cargos_excluidos'));
        ?>
      </div>
    </div>
    
    <div class="form-group">
      <div class="col-md-4 col-md-offset-2">
        <button class="btn btn-success" id="consultar">Consultar</button>
        <button class="btn btn-warning" id="limpiar">Limpiar</button>
      </div>
    </div>
  </fieldset>

<?= form_close(); ?>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
