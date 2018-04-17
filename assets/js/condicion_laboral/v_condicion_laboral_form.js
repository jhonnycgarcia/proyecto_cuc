$(document).ready(function() {
	
	$("#form_condicion_laboral").validate({
		rules : {
			condicion_laboral : {
				required : true,
				minlength : 3
			}
		}
	});
});