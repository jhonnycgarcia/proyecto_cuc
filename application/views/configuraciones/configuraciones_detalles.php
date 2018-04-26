<div class="box box-default"> 
  <div class="box-header with-border"> <!-- Box-Header -->
    <!-- <h4>trabajador Personales</h4> -->
  </div> <!-- /Box-Header -->
  <div class="box-body"> <!-- Box-Body -->
    
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Tema del Template:</b></div>
      <div class="col-md-9"><?=$configuracion['tema_template'];?></div>
    </div>     
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Tiempo máximo de inactividad:</b></div>
      <div class="col-md-9">
        <?=number_format($configuracion['tiempo_max_inactividad'],0,',','.')." milisegundos | ".($configuracion['tiempo_max_inactividad']/1000)." segundos";?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Tiempo máximo de alerta:</b></div>
      <div class="col-md-9">
        <?=number_format($configuracion['tiempo_max_alerta'],0,',','.')." milisegundos | ".($configuracion['tiempo_max_alerta']/1000)." segundos";?>
      </div>
    </div> 
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Tiempo máximo de espera:</b></div>
      <div class="col-md-9">
        <?=number_format($configuracion['tiempo_max_espera'],0,',','.')." milisegundos | ".($configuracion['tiempo_max_espera']/1000)." segundos";?>
      </div>
    </div>    
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Uso de Camara:</b></div>
      <div class="col-md-3">
        <?= ( $configuracion['camara'] == 't' )
          ?'<span class="label label-success">Obligatorio</span>'
          :'<span class="label label-default">No necesario</span>' ; ?> 
      </div>
      <div class="col-md-offset-1 col-md-2"><b>Estatus:</b></div>
      <div class="col-md-3">
        <?= ( $configuracion['estatus'] == 't' )
          ?'<span class="label label-success">Activo</span>'
          :'<span class="label label-default">Inactivo</span>' ; ?> 
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-offset-1 col-md-2">
        <?= anchor('Configuraciones','Cancelar',array('class' => 'btn btn-danger'));?>
      </div>
    </div>

  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
