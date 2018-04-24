<div class="box box-default"> 
  <div class="box-header with-border"> <!-- Box-Header -->
    <!-- <h4>trabajador Personales</h4> -->
  </div> <!-- /Box-Header -->
  <div class="box-body"> <!-- Box-Body -->
    
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Apellidos y nombres:</b></div>
      <div class="col-md-9"><?=$trabajador['apellidos_nombres'];?></div>
    </div>     
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Cedula:</b></div>
      <div class="col-md-9"><?=$trabajador['cedula'];?></div>
    </div>    
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Cargo:</b></div>
      <div class="col-md-3"><?=$trabajador['cargo'];?></div>
      <div class="col-md-offset-1 col-md-2"><b>Condición Laboral:</b></div>
      <div class="col-md-3"><?=$trabajador['condicion_laboral'];?></div>
    </div>    
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Coordinación:</b></div>
      <div class="col-md-9"><?=$trabajador['coordinacion'];?></div>
    </div>    
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Dirección:</b></div>
      <div class="col-md-9"><?=$trabajador['direccion'];?></div>
    </div>    
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Fecha ingreso:</b></div>
      <div class="col-md-3"><?=$trabajador['fecha_ingreso'];?></div>
      <div class="col-md-offset-1 col-md-2"><b>Fecha egreso:</b></div>
      <div class="col-md-3">
        <?= (is_null($trabajador['fecha_egreso']))?"S/R":$trabajador['fecha_egreso'];?>
      </div>
    </div>    
    <div class="row">
    </div>    
    <div class="row">
      <div class="col-md-offset-1 col-md-2"><b>Asistencia obligatoria:</b></div>
      <div class="col-md-9">
        <?= ( $trabajador['asistencia_obligatoria'] == 't' )
          ?'<span class="label label-success">SI</span>'
          :'<span class="label label-default">NO</span>' ; ?> 
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-offset-1 col-md-2">
        <!-- <a href="<?= base_url('Trabajadores');?>" class="btn btn-danger">Volver</a> -->
        <?= (is_null($trabajador['fecha_egreso']))?
            anchor('Trabajadores','Cancelar',array('class' => 'btn btn-danger'))
            :anchor('Trabajadores/egresados','Cancelar',array('class' => 'btn btn-danger'));
          ?>
      </div>
    </div>

  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
