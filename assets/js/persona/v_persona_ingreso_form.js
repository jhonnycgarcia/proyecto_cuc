$(document).ready(function() {

	jQuery.validator.addMethod("lettersonly", function(value, element) {
  		return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Debe ingresar solo caracteres alfabeticos"); 

	var _form_persona_ingresar = $("#form_persona").validate({
		rules : {
			p_apellido : {
				required : true,
				minlength : 3,
				lettersonly : true
			},
			s_apellido : {
				lettersonly : true
			},
			p_nombre : {
				required : true,
				minlength : 3,
				lettersonly : true
			},
			s_nombre : {
				lettersonly : true
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
			},
			imagen : {
				extension: "png|jpg|jpeg"
			}
		}
	});

	_form_persona_ingresar.form();

	 $("input[name='telefono_1']").inputmask({"mask":"(999) 999-9999"});
	 $("input[name='telefono_2']").inputmask({"mask":"(999) 999-9999"});
	 $("input[name='fecha_nacimiento']").datepicker({autoclose: true,language:'es',format: 'dd/mm/yyyy',startView: 2});

	 $("input").on('change',  function(event) {
	 	_form_persona_ingresar.form();
	 });
	 
	 $("#limpiar_file").on('click', function(event) {
	 	$("#imagen").val('');
	 	_form_persona_ingresar.form();
	 });

	$("#contenedor_actual_imagen").addClass('hidden');
	$("#contenedor_actual_imagen input").attr('disabled', 'disabled');
	$("#contenedor_actual_imagen button").attr('disabled', 'disabled');
	$("#contenedor_actualizar_imagen").addClass('hidden');
	$("#contenedor_actualizar_imagen input").attr('disabled', 'disabled');
	$("#contenedor_actualizar_imagen button").attr('disabled', 'disabled');

 	$("#contenedor_agregar_imagen").removeClass('hidden');

});
