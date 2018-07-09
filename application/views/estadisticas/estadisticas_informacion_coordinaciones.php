<div class="row">
  <!-- Chart Donut -->
  <div class="col-md-4">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">% Asistencia al mes</h3>
      </div>
      <div class="box-body">
        <canvas id="chart_asistencia" height="215"></canvas>
      </div>
    </div>
  </div>
  
  <!-- Chart Bar -->
  <div class="col-md-8">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">% Horas al mes</h3>
      </div>
      <div class="box-body">
        <canvas id="chart_desempeno" height="100"></canvas>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-md-12">
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Informacion General por Coordinaciones</h3>
        <div class="box-tools pull-right" id="boxtool_listado_direcciones">
          <div class="input-group input-group-sm">
            <span class="input-group-addon" id="">Fecha consultada </span>
            <input type="text" class="form-control" placeholder="" aria-describedby="" id="fecha_consulta" name="fecha_consulta" value="<?= date('m/Y'); ?>" readonly="readonly">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button" id="consultar">Consultar</button>
            </span>
          </div>
        </div>   
      </div>
      <div class="box-body">

        <table class="table table-hover table-bordered" id="tb_coordinaciones">
          <thead>
            <tr>
              <th>#</th>
              <th class="hidden">id</th>
              <th class="hidden">st_asistencia</th>
              <th class="hidden">st_desempeno</th>
              <th class="text-center col-md-4">Coordinación</th>
              <th>Inasistencias</th>
              <th>Asistencias</th>
              <th>Horas trabajadas</th>
              <th>Horas faltantes</th>
              <!-- <th>Horas Jornada Laboral</th> -->
              <th>Horas extras</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        
        <div class="row">
          <div class="col-md-offset-2">
            <a class="btn btn-danger" href="<?= base_url('Estadisticas/informacion_general'); ?>">Volver</a>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>


