<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
  <?php echo anchor('Coordinacion/agregar/','<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',array('class'=>'btn btn-primary btn-sm col-md-offset-1','id'=>'btn_add'));?>
  
  <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered" id="list">
      <thead>
        <tr>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">id</th>
          <th class="input-filter">Coordinación</th>
          <th class="input-filter">Dirección</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Descripción</th>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">Estatus</th>
          <th class="col-md-1 col-sm-1 col-xs-1">Opciones</th>
        </tr>
      </thead>
      <tbody>
  <?php
    $lista = $this->Coordinacion_M->consultar_lista();
    $i = 0;
    foreach ($lista as $key => $value) {
    $i++;
    $id = $this->seguridad_lib->execute_encryp($value['id_coordinacion'],'encrypt',"Coordinacion");
?>
       <tr>
          <td><?= $value['id_coordinacion'];?></td>
          <td><?= $value['coordinacion']; ?></td>
          <td><?= $value['direccion']; ?></td>
          <td class="text-center"><?= $value['descripcion']; ?></td>
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
                <li role="presentation"><?= anchor( site_url('Coordinacion/editar/'.$id),"Editar",array("role" =>"item")  )?></li>
                <li role="presentation"><?= anchor( site_url('Coordinacion/eliminar/'.$id),"Eliminar",array("role" =>"item")  )?></li>
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
