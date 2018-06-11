$(document).ready(function() {
	
	var _ansmerror = false;

	var _form = $("#form_trabajadores").validate({
		rules : {
			fecha_egreso : {
				required : true,
				minlength : 9,
				maxlength : 10
			}
		}
	});
	_form.form();


	$("#form_trabajadores").on('submit',function(event) {
		if( !_form.valid() && !_ansmerror){ 
			_ansmerror = false; 
			return false;
		}else if( _form.valid() && !_ansmerror ){
			var _ans1 = swal({
				title: '¿Esta seguro?',
				text: "",
				type: 'warning',
				confirmButtonText: 'Estoy seguro',
				showCancelButton: true,
				cancelButtonText: 'No',
				confirmButtonColor: '#3085d6'
			}).then((result)=> {
				if(result.value){_ansmerror = true; _form.submit();}
			});
			return false;
		}else if( _form.valid() && _ansmerror ){
			espera(true);
			return true;
		}else{
			return false;
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
