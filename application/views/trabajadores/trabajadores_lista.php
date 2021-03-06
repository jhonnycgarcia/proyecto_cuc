<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
  <?php echo anchor('Trabajador/registrar/','<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',array('class'=>'btn btn-primary btn-sm pull-right'));?>
  
  <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered" id="list">
      <thead>
        <tr>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">#</th>
          <th class="text-center">Cedula</th>
          <th class="text-center">Apellidos y Nombres</th>
          <th class="text-center">Condicion Laboral</th>
          <th class="text-center">Cargo</th>
          <th class="text-center">Fecha ingreso</th>
          <th class="text-center">Estatus</th>
          <th class="col-md-1 col-sm-1 col-xs-1">Opciones</th>
        </tr>
      </thead>
      <tbody>
  <?php
    $lista = $this->Trabajadores_M->consultar_lista();
    $i = 0;
    foreach ($lista as $key => $value) {
    $i++;
?>
       <tr>
          <td><?= $i;?></td>
          <td class="text-center"><?= $value['cedula']; ?></td>
          <td class="text-center"><?= $value['apellido_nombre']; ?></td>
          <td class="text-center"><?= $value['condicion_laboral']; ?></td>
          <td class="text-center"><?= $value['cargo']; ?></td>
          <td class="text-center"><?= $value['fecha_ingreso']; ?></td>
          <td class="text-center">
            <?= ( $value['estatus'] == 't' )
              ?'<span class="label label-success">Activo</span>'
              :'<span class="label label-default">Inactivo</span>'; ?>
          </td>
          <td>
            <div class="dropdown">
              <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdown_menu<?= $i; ?>" data-toggle="dropdown" aria-extended="true">
                <i class="fa fa-cog"></i>
                <span class="caret"></span>
              </button>

              <ul class="dropdown-menu" rle="menu" aria-labelledby="dropdown_menu<?= $i; ?>">
                <li role="presentation"><?= anchor( site_url('Cargos/editar/'.$value['id_trabajador']),"Editar",array("role" =>"item")  )?></li>
                <li role="presentation"><?= anchor( site_url('Cargos/eliminar/'.$value['id_trabajador']),"Eliminar",array("role" =>"item")  )?></li>
              </ul>
            </div>
          </td>
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
