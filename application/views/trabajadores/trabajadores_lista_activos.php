<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
    <?php
      $id_usuario = $this->session->userdata('id_usuario');
      $metodo = 'Reportes/reporte_general_trabajadores';
    if( $this->seguridad_lib->validar_acceso_metodo($id_usuario,$metodo,false) ){ 
    ?>
    <button type="button" id="btn_informe" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-list" aria-hidden="true"></span> Listado General
    </button>
    <?php } ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered" id="list">
      <thead>
        <tr>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">#</th>
          <th class="text-center">Cedula</th>
          <th class="text-center">Apellidos y Nombres</th>
          <th class="text-center">Condicion Laboral</th>
          <th class="text-center">Cargo</th>
          <th class="text-center">Coordinación</th>
          <th class="text-center">Estatus</th>
          <th class="col-md-1 col-sm-1 col-xs-1">Opciones</th>
        </tr>
      </thead>
      <tbody>
  <?php
    $lista = $this->Trabajadores_M->consultar_lista(true,array('campo'=>'cedula','orden'=>'ASC'));
    $i = 0;
    foreach ($lista as $key => $value) {
    $i++;
    $id = $this->seguridad_lib->execute_encryp($value['id_trabajador'],'encrypt',"Trabajadores");
?>
       <tr>
          <td><?= $i;?></td>
          <td class="text-center"><?= $value['cedula']; ?></td>
          <td class="text-center"><?= $value['apellido_nombre']; ?></td>
          <td class="text-center"><?= $value['condicion_laboral']; ?></td>
          <td class="text-center"><?= $value['cargo']; ?></td>
          <td class="text-center"><?= $value['coordinacion']; ?></td>
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
                <li role="presentation"><?= anchor( site_url('Trabajadores/detalles/'.$id),"Detalles",array("role" =>"item")  )?></li>

                <?php 
                  
                  $metodo = 'Trabajadores/editar';
                  if( $this->seguridad_lib->validar_acceso_metodo($id_usuario,$metodo,false) ){ ?>
                <li role="presentation"><?= anchor( site_url('Trabajadores/editar/'.$id),"Editar",array("role" =>"item")  )?></li>
                <?php } ?>
    
                <?php 
                  $metodo = 'Trabajadores/egresar';
                  if( $this->seguridad_lib->validar_acceso_metodo($id_usuario,$metodo,false) ){ ?>
                <li role="presentation"><?= anchor( site_url('Trabajadores/egresar/'.$id),"Egresar",array("role" =>"item","data"=>"egresar")  )?></li>
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
