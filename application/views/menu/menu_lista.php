<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
  <?php echo anchor('Menu/agregar/','<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',array('class'=>'btn btn-primary btn-sm pull-right'));?>
  
  <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered" id="list">
      <thead>
        <tr>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">id</th>
          <th class="input-filter">Menu</th>
          <th class="input-filter">Link</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Icono</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Relación</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Posición</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Visible en Lista</th>
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
          <td><?= $value['id_menu'];?></td>
          <td><?= $value['menu']; ?></td>
          <td><code><?= $value['link']; ?></code></td>
          <td class="text-center"><?= "<i class='".$value['icono']."'></i>"; ?></td>
          <td class="text-center">
            <?= ( $value['relacion'] == 0 )
              ?'<span class="label label-primary">Padre</span>'
              :'<span class="label label-danger">Hijo</span>' ?>
          </td>
          <td class="text-center"><?= $value['posicion']; ?></td>
          <td class="text-center">
            <?= ( $value['visible_menu'] == 't' )
              ?'<span class="label label-info">SI</span>'
              :'<span class="label label-warning">NO</span>'; ?>
          </td>
          <td class="text-center">
            <?= ( $value['estatus'] == 't' )
              ?'<span class="label label-success">Activado</span>'
              :'<span class="label label-default">Inactivo</span>'; ?>
          </td>
          <td>
            <div class="dropdown">
              <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdown_menu<?= $i; ?>" data-toggle="dropdown" aria-extended="true">
                <i class="fa fa-cog"></i>
                <span class="caret"></span>
              </button>

              <ul class="dropdown-menu" rle="menu" aria-labelledby="dropdown_menu<?= $i; ?>">
                <li role="presentation"><?= anchor( site_url('Menu/editar/'.$value['id_menu']),"Editar",array("role" =>"item")  )?></li>
                <li role="presentation"><?= anchor( site_url('Menu/eliminar/'.$value['id_menu']),"Eliminar",array("role" =>"item")  )?></li>
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
