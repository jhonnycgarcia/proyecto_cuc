$(document).ready(function() {
	
	$("#form_menu").validate({
		rules : {
			menu : {
				required : true,
				minlength : 3
			},
			link : {
				required : true,
				minlength : 1
			},
			icono : {
				required : true,
				minlength : 3
			},
			posicion : {
				required : true,
				minlength : 1
			}
		}
	});
});