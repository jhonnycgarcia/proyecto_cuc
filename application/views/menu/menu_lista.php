<div class="box box-default"> 
  <!-- Box-Header -->
  <!-- <div class="box-header with-border"> -->
  <!-- <?php echo anchor('Menu/agregar/','Agregar',array('class'=>'btn btn-primary btn-sm pull-right'));?> -->
  <!-- </div> -->
  <!-- /Box-Header -->
  <div class="box-body"> <!-- Box-Body -->
  <!-- <?php echo anchor('Menu/agregar/','Agregar',array('class'=>'btn btn-primary btn-sm pull-right'));?> -->
  <?php echo anchor('Menu/agregar/','<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',array('class'=>'btn btn-primary btn-sm pull-right'));?>
  <!-- <h4>Lista de Items</h4> -->
  <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered" id="list">
      <thead>
        <tr>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">id</th>
          <th>Menu</th>
          <th>Link</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Icono</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Relación</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Posición</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Acceso</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Estatus</th>
          <th class="col-md-1 col-sm-1 col-xs-1">Opciones</th>
        </tr>
      </thead>
      <tbody>
  <?php
    $lista = $this->Menu_M->obtener_todos();
    $i = 0;
    foreach ($lista as $key => $value) {
    $i++;
?>
        <tr>
          <td><?= $value['id'];?></td>
          <td><?= $value['menu']; ?></td>
          <td><code><?= $value['link']; ?></code></td>
          <td class="text-center"><?= "<i class='".$value['icono']."'></i>"; ?></td>
          <td class="text-center">
            <?= ( $value['relacion'] == 0 )
              ?'<span class="label label-primary">Padre</span>'
              :'<span class="label label-danger">Hijo</span>;' ?>
          </td>
          <td class="text-center"><?= $value['posicion']; ?></td>
          <td class="text-center">
            <?= ( $value['acceso'] == 1 )
              ?'<span class="label label-info">Vista y Método</span>'
              :'<span class="label label-warning">Método</span>'; ?>
          </td>
          <td class="text-center">
            <?= ( $value['estatus'] )
              ?'<span class="label label-success">Activado</span>'
              :'<span class="label label-default">Inactivo</span>' ; ?>
          </td>
          <td>
            <div class="dropdown">
              <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdown_menu<?= $i; ?>" data-toggle="dropdown" aria-extended="true">
                <i class="fa fa-cog"></i>
                <span class="caret"></span>
              </button>

              <ul class="dropdown-menu" rle="menu" aria-labelledby="dropdown_menu<?= $i; ?>">
                <li role="presentation"><a href="editar/<?=$value['id']?>" role="item">Editar</a></li>
                <li role="presentation"><a href="eliminar/<?=$value['id']?>" role="item">Eliminar</a></li>
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
  <!-- <div class="box-footer"> <!-- Box-Header -->
  	<!-- Lorem ipsum dolor sit amet. [FOOTER] -->
  <!-- </div> -->
</div>
<!-- Your Page Content Here -->
