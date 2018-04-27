$(document).ready(function() {
	
	$("#form_usuarios").validate({
		rules : {
			usuario : {
				required : true,
				minlength : 5
			},
			clave : {
				required : true,
				minlength : 6,
				maxlength : 12
			},
			re_clave : {
				required : true,
				minlength : 6,
				maxlength : 12,
				equalTo: "input[name='clave']"
			}
		}
	});
});

