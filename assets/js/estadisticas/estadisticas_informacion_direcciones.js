
// Chart Bar Desempeño
// var ctx = $("#chart_desempeno");
var _data_default_chart_desempeno = [ 100, 100, 100, 100,100];
var _chart_desempeno = new Chart($("#chart_desempeno"), {
    type: 'bar',
    data: {
        labels: [ "Requeridas","Trabajadas", "Faltantes", "Extras"],
        datasets: [{
            label: '%',
            data: [ 100, 100, 100, 100,100],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(201, 203, 207, 0.2)'
                // 'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgb(201, 203, 207)'
                // 'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            display: false
            ,position : 'bottom'
        }
        ,scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

// Char Doughnut
var _data_default_chart_asistencia = [50,50];
var _chart_asistencia = new Chart($("#chart_asistencia"),{
			type: 'doughnut',
			data: {
				datasets: [{
					data: [50,50],
					backgroundColor: [
					    'rgba(255, 99, 132, 1)',
               			'rgba(75, 192, 192, 1)'
                ],
					label: '#'
				}],
				labels: [
					'Inasistencia',
					'Asistencia',
				]
			},
			options: {
				responsive: true,
				legend: {
					position: 'bottom',
					display : true
				},
				title: {
					display: false,
					text: ''
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		});

// Objeto para realizar la carga delos datos
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
				console.log(data);	
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

// Objeto para realizar el lleano de los datos en la vista
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
						+'<td class="hidden" id="st_asistencia">'+val.st_asistencia+'</td>'
						+'<td class="hidden" id="st_desempeno">'+val.st_desempeno+'</td>'
						+'<td class="text-center col-md-4">'+val.direccion+'</td>'
						+'<td><span class="badge bg-red">'+val.por_inasistencias+'%</span></td>'
						+'<td><span class="badge bg-green">'+val.por_asistencias+'%</span></td>'
						+'<td><span class="badge bg-blue">'+val.por_horas_trabajadas+'%</span></td>'
						+'<td><span class="badge bg-yellow">'+val.por_horas_faltantes+'%</span></td>'
						// +'<td><span class="badge bg-gray">'+val.por_horas_trabajadas_djornada+'%</span></td>'
						+'<td><span class="badge bg-gray">'+val.por_horas_extras+'%</span></td>'
						+'<td><button type="button" class="btn btn-sm btn-default" onclick="actualizar_grafica(this)"><i class="fa fa-eye"></i></button></td>'
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

// Variable general para la configuracion de la tabla
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

	function actualizar_grafica(element){
		var _st_asistencia = $(element).parents('tr').find('td#st_asistencia').text();
		var _st_asistencia = _st_asistencia.split(',');
		var _st_desempeno = $(element).parents('tr').find('td#st_desempeno').text();
		var _st_desempeno = _st_desempeno.split(',');
		_chart_asistencia.data.datasets[0].data = _st_asistencia;
		_chart_desempeno.data.datasets[0].data = _st_desempeno;

		_chart_asistencia.update();
		_chart_desempeno.update();
	}

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
		_chart_asistencia.data.datasets[0].data = _data_default_chart_asistencia;
		_chart_desempeno.data.datasets[0].data = _data_default_chart_desempeno;
		_chart_asistencia.update();
		_chart_desempeno.update();
	});

});
