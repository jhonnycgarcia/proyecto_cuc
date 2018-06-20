var datos_generales = {
	default_progressbar : 5
	,cargar_datos_generales : function (){
		$.ajax({
			url: _base_url+'Estadisticas/ajax_cargar_datos_generales',
			type: 'POST',
			dataType: 'JSON',
			// async : false
		})
		.done(function(data) {
			rellenar_datos.rellenar_datos_generales(data);
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
	}
	,cargar_datos_nro_registros : function(){
		$.ajax({
			url: _base_url+'Estadisticas/ajax_cargas_nro_registros_asistencia_fecha',
			type: 'POST',
			dataType: 'JSON',
			data: { fecha: null },
		})
		.done(function(data) {
			// console.log("success");
			rellenar_datos.rellenar_nro_registros(data);
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
		
	}
	,cargar_datos_tb_direcciones : function (){
		$.ajax({
			url: _base_url+'Estadisticas/ajax_cargar_datos_tb_direcciones',
			dataType: 'JSON',
		})
		.done(function(data) {
			rellenar_datos.rellenar_tb_direcciones(data);
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
	}
	,cargar_datos_tb_coordinaciones : function (element){
		var _id_direccion = $(element).parents('tr').find('td.hidden').text();
		$.ajax({
			url: _base_url+'Estadisticas/ajax_cargar_datos_tb_coordinaciones',
			type : 'POST',
			dataType: 'JSON',
			data: { direccion_id: _id_direccion },
		})
		.done(function(data) {
			rellenar_datos.rellenar_tb_coordinaciones(data);
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
	}
}

var rellenar_datos = {
	rellenar_datos_generales : function(data){
		$("#dato_general_personas").empty().html(data.nro_personas);
		$("#dato_general_trabajadores").empty().html(data.nro_trabajadores);
		$("#dato_general_direcciones").empty().html(data.nro_direcciones);
		$("#dato_general_coordinaciones").empty().html(data.nro_coordinaciones);
	}
	,rellenar_nro_registros : function(data){
		$("#contador_nro_asistencias").find('span.info-box-number').empty().html(data.nro_asistencias);
		$("#contador_nro_inasistencias").find('span.info-box-number').empty().html(data.nro_inasistencias);
	}
	,rellenar_tb_direcciones : function(data){
		$("#tb_direcciones > tbody").empty();
		_tb_direcciones._fnClearTable();
		_tb_direcciones.fnDestroy();

		$.each(data, function(index, val) {
			index++;
			var _pgbar = val.porcentaje;
			if (val.porcentaje == 0) { _pgbar = datos_generales.default_progressbar;}
			$("#tb_direcciones > tbody").append(
				'<tr>'
				+'<td>'+index+'</td>'
				+'<td class="hidden">'+val.id_direccion+'</td>'
				+'<td><h6>'+val.direccion+'</h6></td>'
				+'<td>'
                    +'<div class="progress progress-xs">'
                    +'<div class="progress-bar progress-bar-yellow" style="width:'+_pgbar+'%"></div>'
                    +'</div>'
                +'</td>'
				+'<td>'
					+'<a href="javascript:void(0);" onclick="datos_generales.cargar_datos_tb_coordinaciones(this)">'
						+'<span class="badge bg-yellow">'+val.porcentaje+'%</span>'
					+'</a>'
				+'</td>'
				+'</tr>'
			);
		});

		_tb_direcciones.dataTable({
			"oLanguage":_oLanguage
			,"lengthMenu": [ 5 ]
		});
	}
	,rellenar_tb_coordinaciones : function(data){
		// $("#btn_informe_general_coordinaciones").removeAttr('disabled');
		$("#tb_coordinaciones tbody").empty();
		_tb_coordinaciones._fnClearTable();
		_tb_coordinaciones.fnDestroy();

		$.each(data, function(index, val) {
			index++;
			var _pgbar = val.porcentaje;
			if (val.porcentaje == 0) { _pgbar = datos_generales.default_progressbar;}
			$("#tb_coordinaciones > tbody").append(
				'<tr>'
				+'<td>'+index+'</td>'
				+'<td class="hidden">'+val.id_coordinacion+'</td>'
				+'<td><h6>'+val.coordinacion+'</h6></td>'
				+'<td>'
                    +'<div class="progress progress-xs">'
                    +'<div class="progress-bar progress-bar-teal" style="width:'+_pgbar+'%"></div>'
                    +'</div>'
                +'</td>'
				+'<td>'
					+'<a href="javascript:void(0);" onclick="datos_generales.cargar_datos_tb_coordinaciones(this)">'
						+'<span class="badge bg-teal">'+val.porcentaje+'%</span>'
					+'</a>'
				+'</td>'
				+'</tr>'
			);
		});

		_tb_coordinaciones.dataTable({
					"oLanguage":_oLanguage
					,"lengthMenu": [ 5,10 ]
			});
	}
}

var _oLanguage = { 
					"oPaginate": { 
								"sPrevious": "Anterior", 
								"sNext": "Siguiente", 
								"sLast": "Ultima", 
								"sFirst": "Primera" 
					}, 
					"sLengthMenu": 'Mostrar <select class="form-control input-sm" >'+ 
									'<option value="3">3</option>'+ 
									'<option value="5">5</option>'+ 
									'</select> registros',

					"sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)", 

					"sInfoFiltered": " - filtrados de _MAX_ registros", 

					"sInfoEmpty": "No hay resultados de búsqueda", 

					"sZeroRecords": "No hay registros a mostrar", 

					"sProcessing": "Espere, por favor...", 

					"sSearch": "Buscar: " } 


	var _tb_direcciones = $("#tb_direcciones").dataTable({
			"oLanguage":_oLanguage
			,"lengthMenu": [ 5 ]
		});

	var _tb_coordinaciones = $("#tb_coordinaciones").dataTable({
		"oLanguage":_oLanguage
		,"lengthMenu": [ 5 ]
	});

$(document).ready(function() {
	var _load_dt_general, _load_dt_nro_registros, _load_dt_direcciones;
	// Cargar datos generales
	datos_generales.cargar_datos_generales();
	_load_dt_general = setInterval(function () {
		datos_generales.cargar_datos_generales();
	},60000);

	// Cargar nro de registros del dia
	datos_generales.cargar_datos_nro_registros();
	_load_dt_nro_registros = setInterval(function () {
		datos_generales.cargar_datos_nro_registros();
	},60000);

	// Cargar datos tabla control de asistencia por Direcciones
	datos_generales.cargar_datos_tb_direcciones();
	_load_dt_direcciones = setInterval(function () {
		datos_generales.cargar_datos_tb_direcciones();
	},60000);
});