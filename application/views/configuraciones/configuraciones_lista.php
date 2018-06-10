<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
  <?php echo anchor('Configuraciones/agregar/','<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',array('class'=>'btn btn-primary btn-sm col-md-offset-1','id'=>'btn_add'));?>
  
  <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered" id="list">
      <thead>
        <tr>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">id</th>
          <th class="text-center">Color Tema</th>
          <th class="text-center">Camara Obligatoria</th>
          <th class="text-center">Hora Inicio</th>
          <th class="text-center">Hora Fin</th>
          <th class="text-center">Duración</th>
          <th class="text-center">Estatus</th>
          <th class="col-md-1 col-sm-1 col-xs-1">Opciones</th>
        </tr>
      </thead>
      <tbody>
  <?php
    $lista = $this->Configuraciones_M->consultar_lista();

    $i = 0;
    foreach ($lista as $key => $value) {
    $i++;
    $id = $this->seguridad_lib->execute_encryp($value['id_configuracion'],'encrypt',"Configuraciones");
?>
       <tr>
          <td><?= $i;?></td>
          <td class="text-center"><?= $value['tema_template']; ?></td>
          <td class="text-center">
            <?= ( $value['camara'] == 't' )
              ?'<span class="label label-success">SI</span>'
              :'<span class="label label-default">NO</span>'; ?>
          </td>
          <td class="text-center"><?= $value['hora_inicio']; ?></td>
          <td class="text-center"><?= $value['hora_fin']; ?></td>
          <td class="text-center"><?= $value['duracion_jornada']; ?></td>
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
                <?php if($value['estatus'] == 'f'){?>
                  <li role="presentation"><?= anchor( 
                    site_url('Configuraciones/activar/'.$id)
                    ,"Activar",array("role" =>"item")  )?></li>
                <?php } ?>
                <li role="presentation"><?= anchor( 
                  site_url('Configuraciones/detalles/'.$id )
                  ,"Detalles",array("role" =>"item")  )?></li>
                <li role="presentation"><?= anchor( 
                  site_url('Configuraciones/editar/'.$id )
                  ,"Editar",array("role" =>"item")  )?></li>
                <?php if($value['estatus'] == 'f'){?>
                  <li role="presentation"><?= anchor( 
                    site_url('Configuraciones/eliminar/'.$id )
                    ,"Eliminar",array("role" =>"item")  )?></li>
                <?php } ?>
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
