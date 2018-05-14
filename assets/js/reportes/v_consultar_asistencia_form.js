$(document).ready(function() {

	$("#form_consulta_asistencia").validate({
		rules : {
			fdesde : {
				required : true
			},
			fhasta : {
				required : true
			},
		}
	});

	var _calendarios =  $(".input-daterange input").datepicker({autoclose: true
	 	,language:'es'
	 	,format: 'dd/mm/yyyy'
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
    });
});
