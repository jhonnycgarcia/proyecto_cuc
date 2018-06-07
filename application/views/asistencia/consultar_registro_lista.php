<div class="box box-default"> 
  <div class="box-body"> <!-- Box-Body -->
  
  <button class="btn btn-sm btn-warning hidden" id="limpiar">Limpiar</button>

<!--   <div class="row">
<?=
  form_open(
    '#',
    array(
      'id' => 'consulta_fecha'
      )
  );
?>
    <div class="form-group">
      <label for="fecha" class="control-label col-md-2">Fecha</label>
      <div class="col-md-10">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="dd/mm/aaaa" name="fecha" id="fecha">
            <span class="input-group-btn">
              <button class="btn btn-default" id="consultar">Consultar</button>
            </span>
        </div>
      </div>
    </div>
    <div class="col-md-offset-2" id="fecha-error">
    </div>
<?= form_close(); ?>
  </div> -->

<?=
  form_open(
    '#',
    array(
      'id' => 'consulta_fecha'
      )
  );
?>
      <div class="row">
        <div class="form-group">
          <label for="fecha" class="control-label col-md-2 text-center">Fecha:</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control dateITA" placeholder="dd/mm/aaaa" name="fecha" id="fecha" readonly="readonly">
              <span class="input-group-btn">
                <button class="btn btn-default" id="consultar">Consultar</button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-offset-5" id="fecha-error"></div>
      </div>
<?= form_close(); ?>
<br>

  <div class="table-responsive">
    <table class="table table-hover" id="list">
      <thead>
        <tr>
          <th class="col-md-1">#</th>
          <th class="col-md-1">fecha</th>
          <th class="col-md-2">hora</th>
          <th>trabajador</th>
          <th class="col-md-1">Tipo Registro</th>
          <th class="col-md-2">Opciones</th>
        </tr>
      </thead>
      <tbody>
<!--         <tr>
          <td>a</td>
          <td>a</td>
          <td>a</td>
          <td>a</td>
          <td>a</td>
          <td>a</td>
        </tr> -->
      </tbody>
    </table>
  </div>

  </div> <!-- /Box-Body -->
</div>
<!-- Your Page Content Here -->
