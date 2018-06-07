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


	var _form = $("#form_horas_extras").validate({
		rules : {
			fecha : {
				required : true
			}
		}
	});

	$("input").on('change', function() {
		_form.form();
	});

	$("#fecha").datepicker({autoclose: true
	 	,language:'es'
	 	,format: 'mm/yyyy'
	 	,startView : 1
	 	,minViewMode : 1
	 	,weekStart : 0
	 	,todayHighlight : true});


    $("#limpiar").on('click', function(event) {
    	event.preventDefault();
    	$("#fecha").val('');
    	$("#cargos_excluidos option").removeAttr('selected');
    	$('#fecha').datepicker('clearDates');
    	_form.resetForm();
    	$("input").removeClass('has-success,has-error');
    });
});
