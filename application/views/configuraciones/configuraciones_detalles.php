<div class="box box-default"> 
  <div class="box-header with-border"> <!-- Box-Header -->
    <!-- <h4>trabajador Personales</h4> -->
  </div> <!-- /Box-Header -->
  <div class="box-body"> <!-- Box-Body -->
    
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Tema del Template:</b></div>
      <div class="col-md-9"><?=$configuracion['tema_template'];?></div>
    </div>  
    <p class="divider"></p>   
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Tiempo máximo de inactividad:</b></div>
      <div class="col-md-2">
        <?=number_format($configuracion['tiempo_max_inactividad'],0,',','.')." milisegundos";?>
      </div>
      <div class="col-md-2 text-center"><?=($configuracion['tiempo_max_inactividad']/1000)." segundos";?></div>
      <div class="col-md-2 text-center">
        <?= ( (($configuracion['tiempo_max_inactividad']/1000)/60)>0 )
          ?"0 minutos"
          :(($configuracion['tiempo_max_inactividad']/1000)/60)." minutos";?>
      </div>
    </div>
    <p class="divider"></p>
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Tiempo máximo de alerta:</b></div>
      <div class="col-md-2">
        <?=number_format($configuracion['tiempo_max_alerta'],0,',','.')." milisegundos";?>
      </div>
      <div class="col-md-2 text-center"><?=($configuracion['tiempo_max_alerta']/1000)." segundos";?></div>
      <div class="col-md-2 text-center">
        <?= ( (($configuracion['tiempo_max_alerta']/1000)/60)>0 )
          ?"0 minutos"
          :(($configuracion['tiempo_max_alerta']/1000)/60)." minutos";?>
      </div>
    </div>
    <p class="divider"></p> 
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Tiempo máximo de espera:</b></div>
      <div class="col-md-2">
        <?=number_format($configuracion['tiempo_max_espera'],0,',','.')." milisegundos";?>
      </div>
      <div class="col-md-2 text-center"><?=($configuracion['tiempo_max_espera']/1000)." segundos";?></div>
      <div class="col-md-2 text-center">
        <?= ( (($configuracion['tiempo_max_espera']/1000)/60)>0 )
          ?"0 minutos"
          :(($configuracion['tiempo_max_espera']/1000)/60)." minutos";?>
      </div>
    </div> 
    
    <p class="divider"></p>
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Hora Inicio:</b></div>
      <div class="col-md-1"><?=$configuracion['hora_inicio'];?></div>
      <div class="col-md-offset-1 col-md-1"><b>Hora Fin:</b></div>
      <div class="col-md-1"><?=$configuracion['hora_fin'];?></div>
      <div class="col-md-offset-1 col-md-1"><b>Duración:</b></div>
      <div class="col-md-1"><?=$configuracion['duracion_jornada'];?></div>
    </div>
    <p class="divider"></p>


    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Uso de Camara:</b></div>
      <div class="col-md-1">
        <?= ( $configuracion['camara'] == 't' )
          ?'<span class="label label-success">Obligatorio</span>'
          :'<span class="label label-default">No necesario</span>' ; ?> 
      </div>
      <div class="col-md-offset-1 col-md-2"><b>Estatus:</b></div>
      <div class="col-md-1">
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
