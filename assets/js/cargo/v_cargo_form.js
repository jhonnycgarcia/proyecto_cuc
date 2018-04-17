$(document).ready(function() {
	
	$("#form_cargos").validate({
		rules : {
			condicion_laboral : {
				required : true,
				minlength : 3
			}
		}
	});
});