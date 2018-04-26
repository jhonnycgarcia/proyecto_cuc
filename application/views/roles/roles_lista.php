<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
  <?php echo anchor('Roles/agregar/','<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',array('class'=>'btn btn-primary btn-sm col-md-offset-1','id'=>'btn_add'));?>

    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered" id="list">
        <thead>
          <tr>
            <th class="col-md-1 col-sm-1 col-xs-1 text-center">id</th>
            <th class="input-filter text-center">Rol</th>
            <th class="col-md-1 col-sm-1 col-xs-1 text-center">Estatus</th>
            <th class="col-md-1 col-sm-1 col-xs-1">Opciones</th>
          </tr>
        </thead>
        <tbody>
<?php
  $lista = $this->Roles_M->obtener_todos();
  $i = 0;
  foreach ($lista as $key => $value) {
    $i++;
    $id = $this->seguridad_lib->execute_encryp($value['id_rol'],'encrypt',__CLASS__);
?>
          <tr>
            <td class="text-center"><?= $value['id_rol']; ?></td>
            <td class="text-center"><?= $value['rol']; ?></td>
            <td class="text-center">
            <?= ( $value['estatus'] == 't' )
              ?'<span class="label label-success">Activo</span>'
              :'<span class="label label-default">Inactivo</span>' ; ?>    
            </td>
            <td>
              <div class="dropdown">
                <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdown_menu<?= $i; ?>" data-toggle="dropdown" aria-extended="true">
                  <i class="fa fa-cog"></i>
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" rle="menu" aria-labelledby="dropdown_menu<?= $i; ?>">
                  <li role="presentation"><?= anchor( site_url('Roles/editar/'.$id),"Editar",array("role" =>"item")  )?></li>
                  <li role="presentation"><?= anchor( site_url('Roles/eliminar/'.$id),"Eliminar",array("role" =>"item")  )?></li>
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
