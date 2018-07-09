$(document).ready(function() {


	$("a[data='egresar']").on('click', function(event) {
		event.preventDefault();
		swal({
			title: '¿Esta seguro que desea egresar a este trabajador?',
			text: "Luego de ejecutar esta acción no podra deshacer los cambios realizados.",
			type: 'question',
			confirmButtonText: 'Egresar',
			showCancelButton: true,
			cancelButtonText: 'Cancelar',
			confirmButtonColor: '#3085d6',
  			cancelButtonColor: '#d33'
		})
		.then((result) => {
			if(result.value){
				espera(true);
				window.location.href = $(this).attr('href');
			}
		});
	});

	$("#btn_informe").appendTo("#list_filter");
	$("#btn_informe").on('click',  function(event) {
		window.open(_base_url+'Reportes/reporte_general_trabajadores','_blank');
	});

});
