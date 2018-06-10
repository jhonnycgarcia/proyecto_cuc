$(document).ready(function() {

	var _hora_inicio_value = $("#hora_inicio").val();
	var _hora_fin_value = $("#hora_fin").val();

	var _hora_inicio = $("#hora_inicio").wickedpicker({
				now : _hora_inicio_value,
				twentyFour: true,
				clearable: false,
				title: '',
				timeSeparator: ':',
				showSeconds: true
			});
	var _hora_fin =  $("#hora_fin").wickedpicker({
				now : _hora_fin_value,
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

});
