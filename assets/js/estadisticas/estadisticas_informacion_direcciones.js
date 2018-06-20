


	var cargar_datos = {
		cargar_direcciones : function(_mes, _ano){
			$.ajax({
				url: _base_url+'Estadisticas/ajax_informacion_general_direcciones',
				type: 'POST',
				dataType: 'JSON',
				asyc : false,
				data: { mes: _mes, ano : _ano},
			})
			.done(function(data) {
				// console.log("success");
				// console.log(data);
				rellenar.tabla_direcciones(data);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				// console.log("complete");
			});
			
		}
	}

	var rellenar = {
		tabla_direcciones : function(data){
			$("#tb_direcciones > tbody").empty();
			_tb_direcciones._fnClearTable();
			_tb_direcciones.fnDestroy();
			var _contador = 1;
			$.each(data, function(index, val) {

				$("#tb_direcciones > tbody").append(
					'<tr>'
						+'<td>'+_contador+'</td>'
						+'<td class="hidden">['+val.id_direccion+']</td>'
						+'<td>'+val.direccion+'</td>'
						+'<td><span class="badge bg-red">'+val.nro_inasistencias+'</span></td>'
						+'<td><span class="badge bg-green">'+val.nro_asistencias+'</span></td>'
						+'<td><span class="badge bg-blue">'+val.nro_horas_trabajadas+'</span></td>'
						+'<td><span class="badge bg-gray">'+val.nro_horas_jornada_trabajadas+'</span></td>'
						+'<td><span class="badge bg-yellow">'+val.nro_horas_jornada_faltantes+'</span></td>'
						+'<td><span class="badge bg-purple">'+val.nro_horas_extras+'</span></td>'
						// +'<td><button type="button" class="btn btn-sm btn-default">Ver <i class="fa fa-level-down"></i></button></td>'
					+'</tr>'
				);
				_contador++;
			});
			_tb_direcciones.dataTable({
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
									'<option value="10">10</option>'+ 
									'</select> registros',

					"sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)", 

					"sInfoFiltered": " - filtrados de _MAX_ registros", 

					"sInfoEmpty": "No hay resultados de búsqueda", 

					"sZeroRecords": "No hay registros a mostrar", 

					"sProcessing": "Espere, por favor...", 

					"sSearch": "Buscar: " } 


	var _tb_direcciones = $("#tb_direcciones").dataTable({
		"oLanguage":_oLanguage
		,"lengthMenu": [ 5,10 ]
	});

	$("#fecha_consulta").datepicker({autoclose: true
	 	,language:'es'
	 	,format: 'mm/yyyy'
	 	,startView : 1
	 	,minViewMode : 1
	 	,weekStart : 0
	 	,todayHighlight : true});

$(document).ready(function() {

	var _str = $("#fecha_consulta").val();
	var _array = _str.split("/");
	cargar_datos.cargar_direcciones(_array[0],_array[1]);


	$("#consultar").on('click', function() {
		_str = $("#fecha_consulta").val();
		_array = _str.split("/");
		espera(true);
		cargar_datos.cargar_direcciones(_array[0],_array[1]);
		espera(false);
	});

});
