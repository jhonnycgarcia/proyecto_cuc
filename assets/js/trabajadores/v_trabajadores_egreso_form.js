$(document).ready(function() {
	var _form = $("#form_trabajadores");

	_form.validate({
		rules : {
			fecha_egreso : {
				required : true,
				minlength : 9,
				maxlength : 10
			}
		}
	});

	_form.on('submit', function(event) {
		if ( _form.valid() == false ){ event.preventDefault(); }

		if( _form.valid() == true){
			var _ans = confirm("¿Esta seguro?");
			if( _ans == false ){ event.preventDefault(); }
		}
	});

	var _fecha_inicio = $("input[name='fecha_ingreso']").val();

	 $("input[name='fecha_egreso']").datepicker({autoclose: true
	 	,language:'es'
	 	,format: 'dd/mm/yyyy'
	 	,daysOfWeekDisabled:'[0,6]'
	 	,todayHighlight : true
	 	,startDate : _fecha_inicio 
	 });



});
