$(document).ready(function() {
	
	$("#form_persona").validate({
		rules : {
			p_apellido : {
				required : true,
				minlength : 3
			},
			p_nombre : {
				required : true,
				minlength : 3
			},
			cedula : {
				required : true,
				minlength : 7,
				number: true
			},
			fecha_nacimiento : {
				required : true,
				minlength : 7
			},
			telefono_1 : {
				required : true,
				minlength : 11
			},
			direccion : {
				required : true,
				minlength : 5
			},
			email : {
				email : true
			}
		}
	});

	 $("input[name='telefono_1']").inputmask({"mask":"(999) 999-9999"});
	 $("input[name='telefono_2']").inputmask({"mask":"(999) 999-9999"});
	 $("input[name='fecha_nacimiento']").datepicker({autoclose: true,language:'es',format: 'dd/mm/yyyy'});

});
