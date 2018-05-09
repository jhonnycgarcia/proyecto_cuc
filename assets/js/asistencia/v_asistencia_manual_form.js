	
	//////////////////////////////////
	// Variables para la validacion //
	//////////////////////////////////

	var _rule1 = {
		observacion : {
			required : true,
				minlength : 5
			},
		hora : {
			required : true
			},
		fecha : {
			required : true
			}
	}, _rule2 = {
		observacion : {
			required : true,
				minlength : 5
			},
		hora : {
			required : true
			}
	}

	///////////////////////////////////////
	// Funciones para la gestion del DOM //
	///////////////////////////////////////

	function bloquear_campo(campo){ $("#"+campo).attr('disabled', 'disabled'); }
	function desbloquear_campo(campo){ $("#"+campo).removeAttr('disabled'); }
	function mostrar_camara(contenedor){ $("#"+contenedor).removeClass('hidden'); }
	function ocultar_camara(contenedor){ $("#"+contenedor).addClass('hidden'); }
	function readonly_campo(campo){ $("#"+campo).attr('readonly', 'readonly'); }

	function rellenar_campos(datos){
		if( datos.hasOwnProperty('nombres') ){ $("#nombres").val(datos.nombres); }
		if( datos.hasOwnProperty('apellidos') ){ $("#apellidos").val(datos.apellidos); }
		if( datos.hasOwnProperty('coordinacion') ){ $("#departamento").val(datos.coordinacion); }
		if( datos.hasOwnProperty('cargo') ){ $("#cargo").val(datos.cargo); }
		if( datos.hasOwnProperty('id_trabajador') ){ $("#trabajador_id").val(datos.id_trabajador); }
		if( datos.hasOwnProperty('trabajador_id') ){ $("#trabajador_id").val(datos.trabajador_id); }
		if( datos.hasOwnProperty('fecha') ){ $("#fecha").val(datos.fecha); }
	}	

	function limpiar_campos(){
		$("#cedula").val('');
		$("#nombres").val('');
		$("#apellidos").val('');
		$("#departamento").val('');
		$("#cargo").val('');
		$("#trabajador_id").val('');
		$("#fecha").val('');

		bloquear_campo('entrada');
		bloquear_campo('salida');
		bloquear_campo('limpiar');
		desbloquear_campo('cedula');
		desbloquear_campo('consultar');
	}

	////////////////////////////////////////////////////
	// Funcion para consultar el estadus de la cedula //
	////////////////////////////////////////////////////
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

	obtener_regla = function(){
		if( _configuracion.camara == 't'){ return _rule1;
		}else{ return _rule2; }
	}

		/* Funcion para validar el tipo de registro a ejecutar y habilitar botones correspondientes */
	 validar_registros = function(e) {
	 	var _bloqueo = e.bloqueo
	 	, _fecha = e.fecha
	 	, _tipo_registro = e.tipo_registro
	 	, _fecha_actual = "<?= date('d-m-Y'); ?>";

	 	bloquear_campo('entrada');
	 	bloquear_campo('salida');
	 	bloquear_campo('limpiar');
		// console.log(e);
		if (_bloqueo == true || (_bloqueo == false && _fecha !== null)) {
			if( _fecha !== null){
				var _msn = 'Usted tiene una salida pendiente sin registrar del dia '+_fecha+', favor cierre el dia para poder realizar cualquier otra peticion';
				show_modal('info','Alerta',_msn,false);
				desbloquear_campo('hora');
				desbloquear_campo('observacion');

				$("#hora").wickedpicker({
					twentyFour: false,
					clearable: false,
					title: ''
				});

				$("#tipo_registro").val('SALIDA');
				$("#trabajador_id").val(e.trabajador_id);
				$("#fecha").removeAttr('disabled').attr('readonly', 'readonly');;
				desbloquear_campo('salida');
				$("#form_asistencia").validate({rules : _rule2});
				
			}else{
				var _msn = 'Usted ya cerro su registro de asistencia para el día de hoy, favor intente nuevamente mañana o pongase en contacto con un administrador en caso de que lo requiera.';
				show_modal('warning','Alerta',_msn);
			}
		}else{
			desbloquear_campo('fecha');
			desbloquear_campo('hora');
			desbloquear_campo('observacion');

			$("#fecha").datepicker({autoclose: true
				,language:'es'
				,format: 'dd/mm/yyyy'
				,daysOfWeekDisabled:'[0,6]'
	 			,todayHighlight : true});

			$("#hora").wickedpicker({
				twentyFour: false,
				clearable: false,
				title: ''
			});

			$("#form_asistencia").validate({rules : _rule1});

			if(_tipo_registro == "ENTRADA"){
				desbloquear_campo('salida');
				$("#tipo_registro").val('SALIDA');
			}else{
				desbloquear_campo('entrada');
				$("#tipo_registro").val('ENTRADA');
			}
		}
	}

	////////////////////////////////////////////////////
	// Funcion para consultar la configuracion actual //
	////////////////////////////////////////////////////
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

		if( $("#mymodal").attr('data-info') || $("#mymodal").hasClass('no_reset') ){ // si tiene el valor insertado por SayCheese

			$('#mymodal').modal('toggle');
			$("#mymodal").removeAttr('class').addClass(_defaul_class)
				.removeAttr('data-info');

		}else{
			
			limpiar_campos(); // limpiar campos del formulario
			desbloquear_campo('cedula');
			desbloquear_campo('consultar');
			$('#mymodal').modal('toggle');
			$("#mymodal").removeAttr('class').addClass(_defaul_class);
		}

		// estado de la modal
		// alert( $("#mymodal").data()['bs.modal'].isShown );
	}

	/* Funcion para mostrar ventana modal */
	show_modal = function(clase = null, titulo = null, mensaje = null, resetear_form = true ){
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
		if( resetear_form == false ){
			clase += ' no_reset ';
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

	////////////////////////////////////////
	// Funciones para la CAMARA SAYCHEESE //
	////////////////////////////////////////

	// ################################# CAMARA ####################################
	// Declarar el Objeto
	var sayCheese = new SayCheese('#webcam', { snapshots: true });
	var _img = null;
	// #############################################################################
	
	/* Al tomar la foto */
	sayCheese.on('snapshot', function(snapshot) {

		// creamos la imagen o capturamos la imagen
		_img = document.createElement('img');

		// Capturamos la direccion y le indicamos el tipo de archivo
		_img.src = snapshot.toDataURL('image/png');

		// Le asignamos el valor en BASE64 al campo hidden img
		$("#imagen").val(_img.src);
	});

	/* Al no permitir el uso de la camara */
	sayCheese.on('error', function(error) {
		var _msn = 'Debe activar el uso de la camara compartida para poder registrarse';
		$("#mymodal").attr('data-info', 'true');
		show_modal('info','Cámara no detectada',_msn); // ventana modal

		bloquear_campo('consultar');
		bloquear_campo('limpiar');
		bloquear_campo('cedula');
	});

	/* Al cargar la camara */
	sayCheese.on('start', function(start) {
		desbloquear_campo('consultar');
		desbloquear_campo('limpuar');
		desbloquear_campo('cedula');
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

	$("#limpiar").on('click', function(event) {
		event.preventDefault();
		limpiar_campos();
	});

	$("#consultar").on('click', function(event) {
		event.preventDefault();
		var _cedula = $("#cedula").val();
		bloquear_campo('consultar');
		bloquear_campo('cedula');
		desbloquear_campo('limpiar');
		consultar(_cedula);
		// console.log(_cedula);
	});

	////////////////////////////////////
	// Funcion para iniciar el SCRIPT //
	////////////////////////////////////
	function iniciar(){
		if( _mensaje !== null){
			show_modal(_mensaje.clase, _mensaje.titulo, _mensaje.mensaje);
			$('#mymodal').one('hidden.bs.modal', function (e) {
				if( _configuracion.camara == 't'){ 
					sayCheese.start(); 
				}else{
					desbloquear_campo('cedula');
					desbloquear_campo('consultar');
				}
			});
		}else{
			if( _configuracion.camara == 't'){
				sayCheese.start(); 
			}else{
				desbloquear_campo('cedula');
				desbloquear_campo('consultar');
			}
		}
	}

$(document).ready(function() {
	consultar_configuracion();
	setInterval( consultar_configuracion , 20000);

	/* Corregir solo numeros en campo cedula */
	$("#cedula").keyup(function (){
		this.value = (this.value + '').replace(/[^0-9]/g, '');
	});

	iniciar();
});