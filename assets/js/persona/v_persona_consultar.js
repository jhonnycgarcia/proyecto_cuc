$(document).ready(function() {
	$("#list").DataTable({
		"searching": false
		,"pageLength": 3
		,"oLanguage": { 
					"oPaginate": { 
								"sPrevious": "Anterior", 
								"sNext": "Siguiente", 
								"sLast": "Ultima", 
								"sFirst": "Primera" 
					}, 
					"sLengthMenu": 'Mostrar <select class="form-control input-sm" >'+ 
									'<option value="3" selected>3</option>'+ 
									'<option value="5">5</option>'+ 
									'</select> registros',

					"sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)", 

					"sInfoFiltered": " - filtrados de _MAX_ registros", 

					"sInfoEmpty": "No hay resultados de búsqueda", 

					"sZeroRecords": "No hay registros a mostrar", 

					"sProcessing": "Espere, por favor...", 

					"sSearch": "Buscar: ", 

				}
		,"lengthMenu": [3,5]
	});

	$("#btn_informe").on('click', function(event) {
		var _id = $(this).attr('data-worker');
		window.open(_base_url+'Reportes/consultar_persona_informe/'+_id,'Informe Personal');
	});
});