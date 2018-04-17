<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
  <?php echo anchor('Condicion_Laboral/agregar/','<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',array('class'=>'btn btn-primary btn-sm pull-right'));?>
  
  <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered" id="list">
      <thead>
        <tr>
          <th class="col-md-1 col-sm-1 col-xs-1 text-center">id</th>
          <th class="input-filter text-center">Condicion Laboral</th>
          <th class="col-md-1 col-sm-1 col-xs-1">Opciones</th>
        </tr>
      </thead>
      <tbody>
  <?php
    $lista = $this->Condicion_Laboral_M->consultar_lista();
    $i = 0;
    foreach ($lista as $key => $value) {
    $i++;
?>
       <tr>
          <td><?= $value['id_condicion_laboral'];?></td>
          <td class="text-center"><?= $value['condicion_laboral']; ?></td>
          <td>
            <div class="dropdown">
              <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdown_menu<?= $i; ?>" data-toggle="dropdown" aria-extended="true">
                <i class="fa fa-cog"></i>
                <span class="caret"></span>
              </button>

              <ul class="dropdown-menu" rle="menu" aria-labelledby="dropdown_menu<?= $i; ?>">
                <li role="presentation"><?= anchor( site_url('Condicion_Laboral/editar/'.$value['id_condicion_laboral']),"Editar",array("role" =>"item")  )?></li>
                <li role="presentation"><?= anchor( site_url('Condicion_Laboral/eliminar/'.$value['id_condicion_laboral']),"Eliminar",array("role" =>"item")  )?></li>
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
