$(document).ready(function() {
	
	$("#form_configuraciones").validate({
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
			}
		}
	});

	$("#hora_inicio").wickedpicker({
				twentyFour: false,
				clearable: false,
				title: ''
			});
	$("#hora_fin").wickedpicker({
				twentyFour: false,
				clearable: false,
				title: ''
			});
});
