
<div class="row">
  <div class="col-md-12">
    <!-- AREA CHART -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Informacion General por Direcciones</h3>
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

        <table class="table table-hover table-bordered" id="tb_direcciones">
          <thead>
            <tr>
              <th>#</th>
              <th class="hidden">id</th>
              <th class="text-center col-md-4">Dirección</th>
              <th>Inasistencias</th>
              <th>Asistencias</th>
              <th>Horas trabajadas</th>
              <th>Horas Jornada</th>
              <th>Horas faltantes</th>
              <th>Horas extras</th>
              <!-- <th></th> -->
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


