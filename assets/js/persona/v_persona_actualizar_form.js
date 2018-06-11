$(document).ready(function() {

	jQuery.validator.addMethod("lettersonly", function(value, element) {
  		return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Debe ingresar solo caracteres alfabeticos"); 

	var _form_persona_ingresar = $("#form_persona").validate({
		rules : {
			p_apellido : {
				required : true,
				minlength : 3,
				// lettersonly : true
			},
			s_apellido : {
				// lettersonly : true
			},
			p_nombre : {
				required : true,
				minlength : 3,
				// lettersonly : true
			},
			s_nombre : {
				// lettersonly : true
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
	 
	 $("#limpiar_actualizar").on('click', function(event) {
	 	$("input[data-imagen='up']").val('');
	 	_form_persona_ingresar.form();
	 });

	 $("#limpiar_file").on('click', function(event) {
	 	$("input[data-imagen='add']").val('');
	 	_form_persona_ingresar.form();
	 });

	 $("#cancelar_actualizacion").on('click',  function(event) {
	 	$("#contenedor_actualizar_imagen input").attr('disabled', 'disabled');
 		$("#contenedor_actualizar_imagen button").attr('disabled', 'disabled');
 		$("#contenedor_actualizar_imagen").addClass('hidden');
 		$("#contenedor_actual_imagen").removeClass('hidden');
		$("#contenedor_actual_imagen button").removeAttr('disabled');
	 });

 	$("#contenedor_agregar_imagen input").attr('disabled', 'disabled');
 	$("#contenedor_agregar_imagen button").attr('disabled', 'disabled');
 	$("#contenedor_actualizar_imagen input").attr('disabled', 'disabled');
 	$("#contenedor_actualizar_imagen button").attr('disabled', 'disabled');

 	$("#contenedor_actual_imagen").removeClass('hidden');

 	// if( _error_form_flash !== ''){
 	// 	$("#contenedor_actual_imagen").addClass('hidden');
 	// 	$("#contenedor_actual_imagen button").attr('disabled', 'disabled');
 	// 	$("#contenedor_actualizar_imagen").removeClass('hidden');
 	// 	$("#contenedor_actualizar_imagen input").removeAttr('disabled');
 	// 	$("#contenedor_actualizar_imagen button").removeAttr('disabled');
 	// }
 	
 	$("#actualizar_foto").on('click',  function(event) {
		swal({
			title: '¿Esta seguro?',
			text: "Seguro que desea actualizar la imagen actual",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.value) {
				$("#contenedor_actual_imagen").addClass('hidden');
				$("#contenedor_actual_imagen input").attr('disabled', 'disabled');
				$("#contenedor_actual_imagen button").attr('disabled', 'disabled');

				$("#contenedor_actualizar_imagen").removeClass('hidden');
				$("#contenedor_actualizar_imagen input").removeAttr('disabled');
				$("#contenedor_actualizar_imagen button").removeAttr('disabled');
			}
		});
 	});

 	if( $("#contenedor_actual_imagen input").val() == '' && _error_form_flash !== ''){
 		$("#contenedor_actual_imagen").addClass('hidden');
 		$("#contenedor_actual_imagen button").attr('disabled', 'disabled');
 		$("#contenedor_agregar_imagen").removeClass('hidden');
 		$("#contenedor_agregar_imagen input").removeAttr('disabled');
 		$("#contenedor_agregar_imagen button").removeAttr('disabled');
 	}



});
