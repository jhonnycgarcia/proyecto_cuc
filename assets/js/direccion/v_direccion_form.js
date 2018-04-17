$(document).ready(function() {
	
	$("#form_direccion").validate({
		rules : {
			direccion : {
				required : true,
				minlength : 3
			},
			descripcion : {
				required : true,
				minlength : 3
			}
		}
	});
});