$(document).ready(function() {

	$("#form_usuarios").validate({
		rules : {
			clave_nueva : {
				required : true,
				minlength : 5,
				maxlength : 12
			},
			re_clave : {
				required : true,
				minlength : 5,
				maxlength : 12,
				equalTo: "input[name='clave_nueva']"
			}
		}
	});
});

