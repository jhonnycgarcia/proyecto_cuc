<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
  <?php echo anchor('Persona/agregar/','<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',array('class'=>'btn btn-primary btn-sm pull-right'));?>
  
  <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered" id="list">
      <thead>
        <tr>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">#</th>
          <th class="text-center">Apellidos</th>
          <th class="text-center">Nombres</th>
          <th class="text-center">Cedula</th>
          <th class="text-center">Fecha Nacimiento</th>
          <th class="text-center">Email</th>
          <th class="text-center">Sexo</th>
          <th class="text-center">Estatus</th>
          <th class="col-md-1 col-sm-1 col-xs-1">Opciones</th>
        </tr>
      </thead>
      <tbody>
  <?php
    $lista = $this->Persona_M->consultar_lista();
    $i = 0;
    foreach ($lista as $key => $value) {
    $i++;
?>
       <tr>
          <td><?= $i;?></td>
          <td class="text-center"><?= $value['apellidos']; ?></td>
          <td class="text-center"><?= $value['nombres']; ?></td>
          <td class="text-center"><?= $value['cedula']; ?></td>
          <td class="text-center"><?= $value['fecha_nacimiento']; ?></td>
          <td class="text-center"><?= $value['email']; ?></td>
          <td class="text-center"><?= $value['sexo']; ?></td>
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
                <li role="presentation"><?= anchor( site_url('Persona/consultar/'.$value['id_dato_personal']),"Consultar",array("role" =>"item")  )?></li>
                <li role="presentation"><?= anchor( site_url('Persona/editar/'.$value['id_dato_personal']),"Editar",array("role" =>"item")  )?></li>
                <li role="presentation"><?= anchor( site_url('Persona/eliminar/'.$value['id_dato_personal']),"Eliminar",array("role" =>"item")  )?></li>
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
