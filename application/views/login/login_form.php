<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ingresar .::Sistema Maestro::.</title>
  <!-- FavIcon -->
  <link rel="shortcut icon" type="image/ico" href="<?= base_url('assets/images/icovzla.png'); ?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!-- Bootstrap CSS  -->
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/ionicons/css/ionicons.min.css'); ?>">
  <!-- Theme style AdminLTE folder -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/AdminLTE.min.css'); ?>">

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <h1>Sistema <b>Maestro</b></h1>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Inicie sesion para poder continuar</p>

    <?php 
      $form_attributes = array('id' => 'login_form');
      echo form_open($form_action,$form_attributes); 
    ?>
    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario" value="">
      <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="password" class="form-control" placeholder="Contraseña" maxlength="6" name="contraseña" id="contraseña" value="">
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
      </div>
    </div>
    <?php
      echo form_close();
    ?>
    <br>
    <div class="row">
      <p class="login-box-msg">Para registrar la asistencia ingrese <?= anchor(base_url('Asistencia'),'aquí'); ?></p>
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery JS -->
<script src="<?= base_url('assets/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<!-- Bootstrap JS -->
<script src="<?= base_url('assets/AdminLTE/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- jQueryValidate JS -->
<script src="<?= base_url('assets/jqueryvalidate/dist/jquery.validate.min.js'); ?>"></script>
<!-- jQueryValidate Languaje JS -->
<script src="<?= base_url('assets/jqueryvalidate/dist/localization/messages_es.js'); ?>"></script>

<script type="text/javascript">

  //  Parametros para la configuracion del validador
  $.validator.setDefaults({
    errorElement : 'span',
    errorClass : 'help-block',
    //para los elementos no validados
    highlight : function(element){
      //seleccionamos el elemento
      $(element)
        //encuentra el objeto
        .closest('.form-group')
        //removemos la clase anteior
        .removeClass('has-success has-feedback')
        //agrega esta clase
        .addClass('has-error has-feedback');
    },
    //para los elementos ya validados
    unhighlight : function(element){
      //seleccionamos el elemento
      $(element)
        //encuentra el objeto
        .closest('.form-group')
        //remueve esta clase
        .removeClass('has-error has-feedback')
        //agrega esta clase
        .addClass('has-success has-feedback');
    }
  });

  // Validar Formulario
  $('#login_form').validate({
    rules:{
      usuario:{
        required : true
      },
      contraseña:{
        required : true
      }
    }
  });
</script>

</body>
</html>
