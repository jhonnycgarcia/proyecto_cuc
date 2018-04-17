$(document).ready(function() {
	
	$("#form_coordinacion").validate({
		rules : {
			coordinacion : {
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