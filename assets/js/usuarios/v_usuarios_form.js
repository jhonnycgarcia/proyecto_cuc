$(document).ready(function() {
	var _nro_trabajadores = $("#trabajador_id option").length;
	if( _nro_trabajadores == 0){
		$("#trabajador_id").attr('disabled', 'disabled');
		alert("No se puede realizar esta accion debido a que no hay trabajadores a quien asignar usuario")		;
		window.location.replace(_base_url+"Usuarios");
	}

	$("#form_usuarios").validate({
		rules : {
			usuario : {
				required : true,
				minlength : 5
			},
			clave : {
				required : true,
				minlength : 5,
				maxlength : 12
			},
			re_clave : {
				required : true,
				minlength : 5,
				maxlength : 12,
				equalTo: "input[name='clave']"
			}
		}
	});
});

