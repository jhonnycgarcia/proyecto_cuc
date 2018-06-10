$(document).ready(function() {

	var _hora_inicio = $("#hora_inicio").wickedpicker({
				twentyFour: true,
				clearable: false,
				title: '',
				timeSeparator: ':',
				showSeconds: true
			});
	var _hora_fin =  $("#hora_fin").wickedpicker({
				twentyFour: true,
				clearable: false,
				title: '',
				timeSeparator: ':',
				showSeconds: true
			});

	/* Funcion para verificar que la hora de fin sea mayor a la hora de inicio */
	jQuery.validator.addMethod("TimeBiggerTo", function(value, element, param) {
		var $time_1 = value.replace(':','').replace(" ",'').replace(" ",'');
		var $time_2= $(param).val().replace(":","").replace(" ",'').replace(" ",'');
		// console.log("time hora_fin 1 = "+$time_1);
		// console.log("time hora_inicio 2 = "+$time_2);
		if( $time_1 > $time_2 ){ return true }else{ return false; }
	}, "El valor de este campo debe ser mayor que el de Hora Inicio"); 

	var _form_configuraciones = $("#form_configuraciones").validate({
		rules : {
			tiempo_max_inactividad : {
				required : true,
				minlength : 4,
				number : true
			},
			tiempo_max_alerta : {
				required : true,
				minlength : 4,
				number : true
			},
			tiempo_max_espera : {
				required : true,
				minlength : 4,
				number: true
			},
			hora_inicio : {
				required : true
			},
			hora_fin : {
				required : true
				,TimeBiggerTo : "#hora_inicio"
			}
		}
	});

	_form_configuraciones.form();

	// var _x1 = $("#fecha_inicio").val();
	// // var _x1 = new Date($("#fecha_inicio").val());
	// console.log("valor de fecha de inicio = "+_x1);




});
