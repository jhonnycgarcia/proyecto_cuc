<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
    <?php echo anchor('Direccion/agregar/','<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',array('class'=>'btn btn-primary btn-sm pull-right'));?>
    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered" id="list">
        <thead>
          <tr>
            <th class="col-md-1 col-sm-1 col-xs-1 text-center">id</th>
            <th class="input-filter text-center">Dirección</th>
            <th class="text-center">Descripción</th>
            <th class="col-md-1 col-sm-1 col-xs-1 text-center">Estatus</th>
            <th class="col-md-1 col-sm-1 col-xs-1">Opciones</th>
          </tr>
        </thead>
        <tbody>
<?php
  $lista = $this->Direccion_M->obtener_todos();
  $i = 0;
  foreach ($lista as $key => $value) {
?>
          <tr>
            <td><?= $value['id']; ?></td>
            <td><?= $value['direccion']; ?></td>
            <td><?= $value['descripcion']; ?></td>
            <td><?= $value['estatus']; ?></td>
            <td></td>
          </tr>
<?php
  }
?>
        </tbody>
      </table>
    </div>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
