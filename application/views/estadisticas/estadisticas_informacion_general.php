
<div class="row">
<!-- Personas -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-gray">
      <div class="inner">
        <h3 id="dato_general_personas">0</h3>

        <p>Personas</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
        <!-- <i class="fa fa-user"></i> -->
      <?php 
        $id_usuario = $this->session->userdata('id_usuario');
        $metodo = 'Persona/lista';

        if( $this->seguridad_lib->validar_acceso_metodo($id_usuario,$metodo,false) ){ ?>
      </div>
      <a href="<?= base_url('Persona'); ?>" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
      <?php } ?>
    </div>
  </div>

<!-- Trabajadores -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
      <div class="inner">
        <h3 id="dato_general_trabajadores">0</h3>

        <p>Trabajadores</p>
      </div>
      <div class="icon">
        <i class="fa fa-institution"></i>
        <!-- <i class="fa fa-users"></i> -->
      </div>
      <?php 
        $metodo = 'Trabajadores/lista_activos';
        if( $this->seguridad_lib->validar_acceso_metodo($id_usuario,$metodo,false) ){ ?>
        <a href="<?= base_url('Trabajadores'); ?>" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
      <?php } ?>
    </div>
  </div>

<!-- Direcciones -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3 id="dato_general_direcciones">0</h3>

        <p>Direcciones</p>
      </div>
      <div class="icon">
        <i class="fa fa-line-chart"></i>
      </div>
      <?php 
        $metodo = 'Direccion/lista';
        if( $this->seguridad_lib->validar_acceso_metodo($id_usuario,$metodo,false) ){ ?>
        <a href="<?= base_url('Direccion'); ?>" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
      <?php } ?>
    </div>
  </div>

<!-- Coordinaciones -->
  <div class="col-lg-3 col-xs-6 col-md-4">
    <!-- small box -->
    <div class="small-box bg-teal">
      <div class="inner">
        <h3 id="dato_general_coordinaciones">0</h3>

        <p>Coordinaciones</p>
      </div>
      <div class="icon">
        <span class="glyphicon glyphicon-blackboard"></span>
      </div>
      <?php 
        $metodo = 'Coordinacion/lista';
        if( $this->seguridad_lib->validar_acceso_metodo($id_usuario,$metodo,false) ){ ?>
        <a href="<?= base_url('Coordinacion'); ?>" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
      <?php } ?>
    </div>
  </div>

</div>

<div class="row"> <h3 class="col-md-12 text-center">Información de Asistencia del día <?= date('d/m/Y'); ?></h3> </div>

<div class="row">

  <!-- Barra de porcentaje de asistencia -->
  <div class="col-md-6" id="contador_nro_asistencias"><!-- Apply any bg-* class to to the info-box to color it -->
    <div class="info-box bg-green">
      <span class="info-box-icon"><i class="fa fa-child"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Trabajadores Laborando</span>
        <span class="info-box-number">0</span>
        <!-- The progress section is optional -->
        <div class="progress">
          <div class="progress-bar" style="width: 5%"></div>
        </div>
<!--         <span class="progress-description">
          70% Increase in 30 Days
        </span> -->
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div>

  <!-- Barra de porcentaje de inasistencias -->
  <div class="col-md-6" id="contador_nro_inasistencias"><!-- Apply any bg-* class to to the info-box to color it -->
    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="fa fa-exclamation-triangle"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Trabajadores Inasistentes</span>
        <span class="info-box-number">0</span>
        <!-- The progress section is optional -->
        <div class="progress">
          <div class="progress-bar" style="width: 5%"></div>
        </div>
<!--         <span class="progress-description">
          70% Increase in 30 Days
        </span> -->
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div>

</div>

  <div class="row">

    <!-- Control Asistencia por Direccion -->
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Control Asistencian por Dirección</h3>
          <div class="box-tools">
            <div class="btn-group">
              <a href="<?= base_url('Estadisticas/informacion_direcciones'); ?>" class="btn btn-default btn-sm" id="btn_informe_general_direcciones" data-worker="">
                <i class="fa fa-area-chart"></i> Mes
              </a>
            </div>
          </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover" id="tb_direcciones">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th class="hidden">id</th>
                  <th class="text-center col-md-5">Dirección</th>
                  <th>Estatus</th>
                  <th class="text-center" style="width: 40px">%</th>
                </tr>
              </thead>
              <tbody>                
              </tbody>
            </table>
        </div>
      </div>
    </div>

    <!--  Control Asistencia por Coordinacion -->
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Control Asistencia por Coordinación</h3>
          <div class="box-tools">
            <div class="btn-group" role="group">
               <a href="<?= base_url('Estadisticas/informacion_coordinaciones'); ?>" class="btn btn-default btn-sm" id="btn_informe_general_coordinaciones" data-worker="">
                <i class="fa fa-area-chart"></i> Mes
              </a>
            </div>
          </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover" id="tb_coordinaciones">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th class="hidden">id</th>
                  <th class="text-center col-md-5">Descripción</th>
                  <th>Estatus</th>
                  <th class="text-center" style="width: 40px">%</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
      </div>
    </div>   
  </div>

<div class="box box-default"> 
  <div class="box-header with-border">
    <h3 class="box-title">Control Asistencian por Trabajadores</h3>
    <div class="box-tools">
      <div class="btn-group">
        <a href="<?= base_url('Estadisticas/informacion_trabajadores'); ?>" class="btn btn-default btn-sm" id="btn_informe_general_trabajadores" data-worker="">
          <i class="fa fa-area-chart"></i> Mes
        </a>
      </div>
    </div>
  </div>
  <div class="box-body"> <!-- Box-Body -->
    <table class="table table-bordered table-hover" id="tb_trabajadores">
      <thead>
        <tr>
          <th class="text-center" style="width: 10px">#</th>
          <!-- <th style="width: 10px">#</th> -->
          <th class="hidden">id</th>
          <th class="text-center col-md-8">Apellidos y nombres</th>
          <th class="text-center col-md-2">Hora entrada</th>
          <th class="text-center col-md-2">Hora salida</th>
          <!-- <th class="text-center col-md-4">Coordinacion</th> -->
          <!-- <th class="text-center col-md-4">direccion</th> -->
          <!-- <th class="text-center" style="width: 40px">%</th> -->
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
