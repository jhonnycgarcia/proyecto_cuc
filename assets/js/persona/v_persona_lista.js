$(document).ready(function() {


	$("a[data='eliminar']").on('click', function(event) {
		event.preventDefault();
		var _href = $(this).attr('href');
		swal({
			title: '¿Esta seguro que desea eliminar este registro?',
			text: "Luego de ejecutar esta acción no podra deshacer los cambios realizados.",
			type: 'warning',
			confirmButtonText: 'Estoy seguro',
			showCancelButton: true,
			cancelButtonText: 'No',
			confirmButtonColor: '#3085d6',
  			cancelButtonColor: '#d33'
		})
		.then((result) => {
			if(!result.value){
				event.preventDefault();
			}else{
				espera(true);
				// $(location).attr('href', $(this).attr('href'));
				window.location.href = $(this).attr('href');
				// console.log($(this).attr('href'));
			}
		});
	});

	$("a[data='ingresar']").on('click',  function(event) {
				event.preventDefault();
		var _href = $(this).attr('href');
		swal({
			title: '¿Esta seguro?',
			text: "",
			type: 'question',
			confirmButtonText: 'Estoy seguro',
			showCancelButton: true,
			cancelButtonText: 'No',
			confirmButtonColor: '#3085d6',
  			cancelButtonColor: '#d33'
		})
		.then((result) => {
			if(!result.value){
				event.preventDefault();
			}else{
				espera(true);
				// $(location).attr('href', $(this).attr('href'));
				window.location.href = $(this).attr('href');
				// console.log($(this).attr('href'));
			}
		});
	});
});
