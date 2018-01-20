$(document).ready(function() {

			// validar formulario
			$("#form").validate({

	        rules:{
	          cedula:{
	            required : true,
	            minlength : 7,
	            maxlength : 8
	          }
	        }

	      });
});