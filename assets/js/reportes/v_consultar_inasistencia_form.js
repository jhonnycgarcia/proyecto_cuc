$(document).ready(function() {

	$.validator.setDefaults({
		errorElement: "span",
		errorClass : 'has-error has-feedback',
		validClass : 'has-success has-feedback',
		highlight : function(element, errorClass, validClass){ //para los elementos no validados
			$(element)
				.closest('.form-group')
				.removeClass(validClass)
				.addClass(errorClass);
		},
		unhighlight : function(element, errorClass, validClass){ //para los elementos ya validados
			$(element)
				.closest('.form-group')
				.removeClass(errorClass)
				.addClass(validClass);

			$("div #"+element.id+"-error").appendTo('');
			// console.log(element.id);
		},
		errorPlacement: function(error, element) {
		    error.appendTo('div #'+error[0].id);
		    // $("span #"+error[0].id).removeAttr('class');
		    // error.appendTo("#form_errors");
		}
	});


	var _form = $("#form_consulta_asistencia").validate({
		rules : {
			fdesde : {
				required : true
			},
			fhasta : {
				required : true
			},
		}
	});

	$("input").on('change', function() {
		_form.form();
	});

	var _calendarios =  $(".input-daterange input").datepicker({autoclose: true
	 	,language:'es'
	 	,format: 'dd/mm/yyyy'
	 	,weekStart : 0
	 	,daysOfWeekDisabled:'[0,6]'
	 	,todayHighlight : true});
    _calendarios = $('.input-daterange').datepicker({});


    $("#limpiar").on('click', function(event) {
    	event.preventDefault();
    	$("#fhasta").val('');
    	$("#fdesde").val('');
    	$("#cargos_excluidos option").removeAttr('selected');
    	$('#fhasta').datepicker('clearDates');
    	$('#fdesde').datepicker('clearDates');
    	_form.resetForm();
    	$("input").removeClass('has-success,has-error');
    });
});
