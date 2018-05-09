<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Registrar Asistencia</title>
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

	<style>
		.camara{
			background-color: #000000;
			/*background-color: #B3B3B3;*/
			height: 240px;
			min-height: 240px;
			min-width: 240px;
		}
		.caja{
			background-color: #FFFFFF;
			border-radius: 15px;
			width: 60%;
			min-width: 400px;
			margin: 20px auto;
			padding: 20px;
		}
		.alert{
			padding-top: 5px;
			padding-bottom: 5px;
		}
		.text-center{
			margin-top: 0px;
			margin-bottom: 0px;
		}
	</style>

</head>
<body class="hold-transition login-page">

<!--  Cargar ventana MODAL  -->	
	<div class="modal modal-default fade" id="mymodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Header de la ventana1 -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hiden="true" onclick="remove_modal();">&times;</button>
					<h4 class="modal-title"></h4>
				</div>

				<!-- Contenido de la ventana1 -->
				<div class="modal-body">
					<h4 id="mensaje"></h4>
					<!-- <p id="mensaje"></p> -->
				</div>

				<!-- Footer de la ventana1 -->
				<div class="modal-footer">
					<button class="btn btn-outline" data-dismiss="modal" onclick="remove_modal();">Cerrar</button>
				</div>

			</div>
		</div>
	</div>

<div class="container">
	<div class="caja">
	<?php

	$attributes_form = array('id' => 'form_asistencia');
	echo form_open($form_action,$attributes_form);
	?>
		<div class="form-group" id='contenedor_camara'>
			<div class="camara text-center" id="webcam">
				<!-- Lorem ipsum dolor sit amet.	
				
				<span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x"></i>
					<i class="fa fa-twitter fa-stack-1x"></i>
				</span>	 -->				
			</div>
			<!-- Campo para almacenar la foto -->
			<input class="form-control" type="hidden" name="img" id="img" readonly="readonly" value="">
		</div>
		
		<div class="form-group" id="ultimo_registro">
			<div class="well well-sm">
				<h5 class="text-center">Ultimos <b style="color: #FF0000;">3</b> registros </h5>
			</div>
		</div>
		
		<!-- Alerta -->
<!-- 		<div class="alert alert-success alert-dismissible">
	    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	    	<h4>
	    		<i class="icon fa fa-check"></i> Registro creado exitosamente
	    	</h4>
		</div> -->


		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-user"></span>
				</span>
				<input type="text" class="form-control" placeholder="Cedula" name="cedula" id="cedula" maxlength="8">
				<div class="input-group-btn">
					<!-- <button class="btn btn-primary" id="consultar" >Consultar</button> -->
					<button class="btn btn-primary" id="consultar" disabled="disabled">Consultar</button>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Nombres</span>
				<input type="text" class="form-control" placeholder="Nombres" name="nombres" id="nombres" disabled="disabled">
			</div>
		</div>

		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Apellidos</span>
				<input type="text" class="form-control" placeholder="Apellidos" name="apellidos" id="apellidos" disabled="disabled">
			</div>
		</div>

		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Departamento</span>
				<input type="text" class="form-control" placeholder="Departamento" name="departamento" id="departamento" disabled="disabled">
			</div>
		</div>

		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Cargo</span>
				<input type="text" class="form-control" placeholder="Cargo" name="cargo" id="cargo" disabled="disabled">
			</div>
		</div>

		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Fecha</span>
				<input type="text" class="form-control" placeholder="Fecha" name="fecha" id="fecha" disabled="disabled" value="<?= date('d-m-Y') ?>">
			</div>
		</div>

		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Hora</span>
				<input type="text" class="form-control" placeholder="Hora" name="hora" id="hora-servidor" disabled="disabled">
			</div>
		</div>

		<div>
			<input type="hidden" name="tipo_registro" id="tipo_registro" value="">
		</div>
		
		<div class="form-group text-center">
			<button class="btn btn-primary btn-lg" disabled="disabled" id="entrada">ENTRADA</button>
			<button class="btn btn-danger btn-lg" disabled="disabled" id="salida">SALIDA</button>
			<!-- <button class="btn btn-warning btn-lg" id="limpiar" >LIMPIAR</button> -->
			<button class="btn btn-warning btn-lg" id="limpiar" disabled="disabled">LIMPIAR</button>
		</div>

		<div class="form-group text-center">
			<h6><?= anchor(base_url('ingresar'),'Si desea ingresar al sistema haga CLICK aqui'); ?></h6>
		</div>
		<div>
			<input type="hidden" id="hidden_camara" value="false">
			<input type="hidden" name="trabajador_id" id="trabajador_id" value="">
		</div>
	<?= form_close(); ?>
	</div>
</div>


<!-- jQuery JS -->
<script src="<?= base_url('assets/jquery/jquery.js'); ?>"></script>
<!-- Bootstrap JS -->
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- SayCheese JS -->
<script src="<?= base_url('assets/say-cheese/say-cheese.js'); ?>"></script>

<script type="text/javascript">
	var _base_url = "<?= base_url(); ?>";
	var _mensaje = JSON.parse('<?= $mensaje_modal; ?>');
	// var _mensaje = "<?= $mensaje_modal; ?>";
	var _configuracion = JSON.parse('<?= $configuracion; ?>');

	/* Variables para el RELOJ */
	var jDate = "<?= date('d/m/Y') ?>";
	var jHora = "<?= date('H') ?>";
	var jMin = "<?= date('i') ?>";
	var jSec = "<?= date('s') ?>";


	////////////////////////
	// Funciones GLOBALES //
	////////////////////////

	/* Remover las etiquetas de alertas */
	remove_alert = function(){
		if( $("div.alert").find() ){ $("div.alert").remove();}
	}

	/* Agregar etiqueta de alerta */
	add_alert = function(contenedor,clase = null,icono = null,mensaje){
		// Valores predeterminados
		var _icono = "<i class='icon fa fa-check'></i>";
		var _clase = 'success';

		/* sustituir clase */
		if( clase !== null && clase !== '' ){ _clase = clase; }

		 // sustituir icono 
		if( icono !== null && icono !== '' ){ _icono = "<i class='icon fa "+icono+"'></i>"; }

		// concatenar todo
		var _contenido = "<div class ='alert  alert-"+_clase+" alert-dismissible'>"
			+"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"
			+"<h4>"
				+_icono
				+mensaje
			+"</h4>"
		+"</div>";

		$("#"+contenedor+"").after(_contenido);
	}

	/* Bloquear o Desbloquear boton */
	btn_lock = function(id,estatus){
		if( estatus == true ){ $("#"+id+"").removeAttr('disabled');
		}else{ $("#"+id+"").attr('disabled', 'disabled'); }
	}

	/* Funcion para bloquear el campo cedula */
	lock_cedula = function(){ $("#cedula").attr('readonly', 'readonly'); }
	
	/* Funcion para desbloquear el campo cedula */
	unlock_cedula = function(){ $("#cedula").removeAttr('readonly'); }


	//////////////////////////////
	// Funciones del FORMULARIO //
	//////////////////////////////

	/* Funcion para rellenar los datos en el formulario */
	rellenar_campos = function(e){
		$("#apellidos").val(e.apellidos);
		$("#trabajador_id").val(e.trabajador_id);
		$("#nombres").val(e.nombres);
		$("#departamento").val(e.coordinacion);
		$("#cargo").val(e.cargo);
	}

	/* Funcion para limpiar los campos del formulario */
	limpiar_campos = function(){
		$("#cedula").val('');
		$("#nombres").val('');
		$("#apellidos").val('');
		$("#trabajador_id").val('');
		$("#departamento").val('');
		$("#cargo").val('');
		$("#tipo_registro").val('');

		btn_lock('entrada',false); // bloquear boton de entrada
		btn_lock('salida',false); // bloquear boton de salida
	}

	/* Funcion para validar el tipo de registro a ejecutar y habilitar botones correspondientes */
	 validar_registros = function(e) {
	 	var _bloqueo = e.bloqueo
	 	, _fecha = e.fecha
	 	, _tipo_registro = e.tipo_registro
	 	, _fecha_actual = "<?= date('d-m-Y'); ?>";

		btn_lock('entrada',false);
		btn_lock('salida',false);
		// console.log(e);
		if (_bloqueo == true) {
			if( _fecha !== null){
				var _msn = 'Usted tiene una salida pendiente sin registrar del dia '+_fecha+', favor comunicarse con los administradores para procesar el registro pendiente y poder registrarse nuevamente en el sistema.';
				show_modal('warning','Alerta',_msn);

			}else{
				var _msn = 'Usted ya cerro su registro de asistencia para el día de hoy, favor intente nuevamente mañana o pongase en contacto con un administrador en caso de que lo requiera.';
				show_modal('warning','Alerta',_msn);
			}
		}else{
			if(_tipo_registro == "ENTRADA"){
				btn_lock('salida',true);
				$("#tipo_registro").val('SALIDA');
			}else{
				btn_lock('entrada',true);
				$("#tipo_registro").val('ENTRADA');
			}
		}
	}

	/* Funcion para consultar cedula y sus registros */
	consultar = function(cedula){
		$.ajax({
			url: _base_url+"Asistencia/consultar_cedula",
			type: 'POST',
			dataType: 'json',
			data: { cedula: cedula },
		})
		.done(function(e) {
			// console.log("success");
			var _consulta = e.consulta;
			if( _consulta ){
				rellenar_campos(e); // llenar campos 
				validar_registros(e); // validar registros 
			}else{
				// remove_alert(); // remover alertas

				var _msn = 'La cedula ingresada no esta registrada';
				// add_alert('ultimo_registro','danger','fa-ban',_msn); // alerta
				show_modal('danger','Error',_msn); // ventana modal

			}
		})
		.fail(function() {
			// console.log("error");
			var _msn = 'Ocurrio un inconveniente al momento de realizar la consulta por favor verifique su conexion a la red e intente nuevamente.';
			show_modal('info','Informacion',_msn); // ventana modal	
		});
	}

	/* Consultar los ultimos tres (3) registros */
	ultimo_registro = function(){
		$.ajax({
			url: _base_url+"Asistencia/ultimos_registros",
		})
		.done(function(e) {
			// console.log("success");
			// console.log(e);
			if( e !== 'null' ){ // validar que no este vacio
				$("marquee").remove();
				$("#ultimo_registro > div.well >").append('<marquee>'+e+'</marquee>');
			// no trajo ningun dato
			}else{
				$("marquee").remove();
				$("#ultimo_registro > div.well >").append('<marquee>S/R</marquee>');
			}
		})
		.fail(function() {
			console.log("error");
			remove_alert(); // remover alertas
			var _msn = 'Ocurrio un inconveniente al momento de cargar los ultimos tres (3) registros';
			add_alert('contenedor_camara','error','fa-ban',_msn);
		});
	}

	function consultar_configuracion(){
		$.ajax({
			url: _base_url+'Asistencia/obtener_configuracion',
			dataType: 'JSON',
		})
		.done(function(e) {
			// console.log("success");
			var _camara = e.camara;
			if( _camara !== _configuracion.camara){ location.reload(true); }
		})
		.fail(function() {
			// console.log("error");
			remove_alert(); // remover alertas
			var _msn = 'Ocurrio un inconveniente al momento de consultar la configuracion actual';
			add_alert('contenedor_camara','error','fa-ban',_msn);
		});
		
	}

	/////////////////////////////////////
	// Funciones para la ventana MODAL //
	/////////////////////////////////////

	// variable personal
	var _show_modal = false;

	/* Funcion para remover/ocultar ventana modal */
	remove_modal = function() {
		var _defaul_class = "modal modal-default fade";

		_show_modal = null;

		if( $("#mymodal").attr('data-info') ){ // si tiene el valor insertado por SayCheese

			$('#mymodal').modal('toggle');
			$("#mymodal").removeAttr('class').addClass(_defaul_class)
				.removeAttr('data-info');

		}else{
			
			limpiar_campos(); // limpiar campos del formulario
			unlock_cedula(); // desbloquear cedula 
			btn_lock('consultar',true); // desbloquear boton 
			$('#mymodal').modal('toggle');
			$("#mymodal").removeAttr('class').addClass(_defaul_class);
		}

		// estado de la modal
		// alert( $("#mymodal").data()['bs.modal'].isShown );
	}

	/* Funcion para mostrar ventana modal */
	show_modal = function(clase = null, titulo = null, mensaje = null){
		// Valores por defecto 
		var _clase = 'modal-default';
		var _titulo = 'Titulo';
		var _mensaje = 'Lorem ipsum dolor sit amet.';
		var _icono = '';

		_show_modal = true;

		/* sustituir el titulo */
		if( titulo !== null && titulo !== '' ){
			_titulo = titulo;
		}

		/* sustituir la clase */
		if( clase !== null && clase !== '' ){
			$("#mymodal").removeClass(_clase).addClass('modal-'+clase);
			_clase = clase;
		}

		/* sustituir el mensaje */
		if( mensaje !== null && mensaje !== ''){
			_mensaje = mensaje;
		}

		if( _clase.toLowerCase() == 'success'){
			_icono = "<i class='fa fa-check fa-fw'></i>";
		}else if( _clase.toLowerCase() == 'danger'){
			_icono = "<i class='fa fa-ban fa-fw'></i>";
		}else if( _clase.toLowerCase() == 'info'){
			_icono = "<i class='fa fa-info fa-fw'></i>";
		}else if( _clase.toLowerCase() == 'warning'){
			_icono = "<i class='fa fa-warning fa-fw'></i>";
		}

		/* agregar valores */
		$("h4.modal-title").html(_icono+_titulo);
		// $("h4.modal-title").html(_icono).text(_titulo);
		$("#mensaje").text(_mensaje);

		/* Mostrar ventana modal */
		$('#mymodal').modal('show'); 

		// estado de la modal 
		// alert( $("#mymodal").data()['bs.modal'].isShown );
	}


	////////////////////////////////
	// Funciones al CARGAR EL DOM //
	////////////////////////////////
	
	function iniciar(){
		/* Mostrar mensaje de proceso */
		if( _mensaje !== null){
			// mostrar resultado del proceso
			show_modal(_mensaje.clase, _mensaje.titulo, _mensaje.mensaje);

			// al cerrar la ventana modal, ejecutar una sola vez
			$('#mymodal').one('hidden.bs.modal', function (e) {
				if( _configuracion.camara == 't'){ 
					sayCheese.start(); 
				}else{
					btn_lock('consultar',true); // desbloquear boton consultar
					btn_lock('limpiar',true); // desbloquear boton limpiar
					unlock_cedula();
				}
			});

		}else{
			if( _configuracion.camara == 't'){ 
				sayCheese.start(); 
			}else{
				btn_lock('consultar',true); // desbloquear boton consultar
				btn_lock('limpiar',true); // desbloquear boton limpiar
				unlock_cedula();
			}
		}
	}

	$(document).ready(function() {


		ultimo_registro(); // buscar ultimo registro
		setInterval( ultimo_registro , 20000); // actualizar cada 20 segundos 
		consultar_configuracion();
		setInterval( consultar_configuracion , 20000); // actualizar cada 20 segundos 
		// btn_lock('consultar',true); // bloquear btn consultar
		
		/* Corregir solo numeros en campo cedula */
		$("#cedula").keyup(function (){
			this.value = (this.value + '').replace(/[^0-9]/g, '');
		});


		/* Al hacer click en consultar */
		$("#consultar").on('click', function(event) {
			event.preventDefault();
			
			_cedula = $("#cedula").val();

			// el campo cedula no esta vacio 
			if( _cedula.trim() !== '' ){
				lock_cedula(); // bloquear cedula
				btn_lock('consultar',false); // bloquear btn consultar
				consultar(_cedula); // consultar
			}

		});

		/* Al hacer click en limpiar */
		$("#limpiar").on('click', function(e) {
			e.preventDefault();

			remove_alert(); // remover alertas
			limpiar_campos(); // limpiar formulario 
			unlock_cedula(); // desbloquear cedula
			btn_lock('consultar',true); // desbloquear boton 

		});

		iniciar();

	});

	////////////////////////////////////////
	// Funciones para la CAMARA SAYCHEESE //
	////////////////////////////////////////

	// ################################# CAMARA ####################################
	// Declarar el Objeto
	var sayCheese = new SayCheese('#webcam', { snapshots: true });
	var _img = null;

	// Inicializar el objeto
	// sayCheese.start();
	// #############################################################################
	
	/* Al tomar la foto */
	sayCheese.on('snapshot', function(snapshot) {

		// creamos la imagen o capturamos la imagen
		_img = document.createElement('img');

		// Capturamos la direccion y le indicamos el tipo de archivo
		_img.src = snapshot.toDataURL('image/png');

		// Le asignamos el valor en BASE64 al campo hidden img
		$("#img").val(_img.src);
	});

	/* Al no permitir el uso de la camara */
	sayCheese.on('error', function(error) {
		var _msn = 'Debe activar el uso de la camara compartida para poder registrarse';
		$("#mymodal").attr('data-info', 'true');
		show_modal('info','Cámara no detectada',_msn); // ventana modal

		btn_lock('consultar',false); // bloquear boton consultar
		btn_lock('limpiar',false); // bloquear boton limpiar
		lock_cedula();
	});

	/* Al cargar la camara */
	sayCheese.on('start', function(start) {
		btn_lock('consultar',true); // desbloquear boton consultar
		btn_lock('limpiar',true); // desbloquear boton limpiar
		unlock_cedula();
	});

	//  Evento Click ENTRADA
	$("#entrada").on('click', function(event) {
		if( _configuracion.camara == 't'){
			sayCheese.takeSnapshot(240,160); // tomar fotografia
		}
	});

	//  Evento Click SALIDA
	$("#salida").on('click', function(event) {
		if( _configuracion.camara == 't'){
			sayCheese.takeSnapshot(240,160); // tomar fotografia
		}
	});

</script>

<!-- Reloj JS -->
<script src="<?= base_url('assets/js/template/j_reloj.js'); ?>"></script>

</body>
</html>
