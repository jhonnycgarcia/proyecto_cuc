
function espera(opcion = false){
	if( opcion == false){
		$("#contenedor_carga").css({
			visibility: 'hidden',
			opacity: '0'
		});
	}else{
		$("#contenedor_carga").css({
			visibility: 'visible',
			opacity: '0.9'
		});
	}
}

function rellenar_tabla(e){
	$("#list>tbody").find('.odd').remove();
	var _nro = 1;
	$.each(e, function(index, val) {
		var _row = "";
		_row = "<tr>\n";
		_row += "<td>"+_nro+"</td>\n";
		_row += "<td>"+val.fecha+"</td>\n";
		_row += "<td>"+val.hora+"</td>\n";
		_row += "<td>"+val.apellidos_nombres+"</td>\n";
		_row += "<td>"+val.tipo_registro+"</td>\n";
		_row += "<td class='hidden' id='id_registro'>"+val.id_registro_asistencia+"</td>\n";
		_row += "<td>\n"
			+"<div class='btn-group' role='group'>\n"
				+"<button type='button' class='btn btn-sm btn-default' title='Detalles' id='detalles' onclick='detalles(this)'>\n"
					+"<span class='glyphicon glyphicon-search' aria-hidden='true'></span>\n"
				+"</button>\n"
				+"<button type='button' class='btn btn-sm btn-default' title='Desactivar' id='desactivar' onclick='desactivar(this)'>\n"
					+"<span class='glyphicon glyphicon-eye-close' aria-hidden='true'></span>\n"
				+"</button>\n"
			+"</div>\n"
			+"&nbsp;"
			+"</td>\n";
		_row += "</tr>\n";
		$("#list>tbody").append(_row);
		_nro++;
	});
}

function consultar_fecha(){
	var _fecha = $("#fecha").val();
	gestion_elemento("limpiar",true);
	espera(true);

	$.ajax({
		url: _base_url+"Asistencia/ajax_consultar_registros_dia",
		type: 'POST',
		dataType: 'JSON',
		data: { fecha : _fecha},
		asyc : false,
	})
	.done(function(data) {
		// console.log("success");
		// console.log(data);
		if( data == null ){
			$("#fecha").val('').datepicker("update");
			swal({
				type: 'info',
				title: 'Atención',
				text: 'No se consiguieron registros para la fecha deseada, favor intente nuevamente con otra fecha',
			  	confirmButtonText:'Aceptar',
			  	onClose : function(){
					$("#fecha").focus();
			  	}
			});
			gestion_elemento("fecha",true);
			gestion_elemento("limpiar",false);
		}else{
			rellenar_tabla(data);
		}
	})
	.fail(function() {
		swal({
			type: 'warning',
			title: 'Atención',
			text: 'Ocurrio un inconveniente al momento de realizar la consulta, favor intente nuevamente o pongase en contacto con los administradores para solventar este inconveniente',
		  	confirmButtonText:'Aceptar'
		});
		// console.log("error");
	}).always(function() {
		espera(false);
		// console.log("complete");
	});
}

function gestion_elemento(_element,_attr = false){
	if( _attr == false){ $("#"+_element).attr('disabled', 'disabled');
	}else{ $("#"+_element).removeAttr('disabled');}
}

function consultar_registro(_id_registro){
	espera(true);
	$.ajax({
		url: _base_url+"Asistencia/detalles_registro",
		type: 'POST',
		dataType: 'JSON',
		data: { id_registro : _id_registro},
		asyc : false,
	})
	.done(function(data) {
		// console.log("success");
		// console.log(data);
		var _html = '';
		_html =	"<b>Cedula:</b> <span>"+data.cedula+"</span><br>"
			+"<b>Apellidos y Nombres:</b> <span>"+data.apellidos_nombres+"</span><br>"
			+"<b>Fecha:</b> <span>"+data.fecha+"</span><br>"
			+"<b>Hora:</b> <span>"+data.hora+"</span><br>"
			+"<b>Tipo Registro:</b> <span>"+data.tipo_registro+"</span><br>"
			+"<b>Imagen:</b> <span>S/R</span><br>";

		if( data !== null){
			if( data.imagen == null ){ 
				swal({
					allowOutsideClick : false,
					allowEscapeKey  :false,
					allowEnterKey : false,
					title: '<b>Detalles</b>',
					html: _html,
					showCloseButton: true,
					showCancelButton: false,
					focusConfirm: false,
					confirmButtonText:
					'Aceptar',
					confirmButtonAriaLabel: 'Aceptar',
				});
			}else{
				swal({
					title: '<b>Detalles</b>',
					html: _html,
					imageUrl: data.imagen,
					imageWidth: 400,
					imageHeight: 200,
					imageAlt: 'Custom image',
					animation: false
				});
			}

		}else{
			swal({
				type: 'error',
				title: 'Atención',
				text: 'Ocurrio un inconveniente al momento de realizar la consulta, favor intente nuevamente y si el error persiste comuniquese con los administradores',
			  	confirmButtonText:'Aceptar'
			});	
		}
	})
	.fail(function(e) {
		// console.log("error");
		swal({
			type: 'error',
			title: 'Atención',
			text: 'Ocurrio un inconveniente, favor intente nuevamente',
		  	confirmButtonText:'Aceptar'
		});
	})
	.always(function() {
		// console.log("complete");
		espera(false);
	});
	
}

function detalles(e){
	var _id = $(e).parent().parent().parent().find('#id_registro').html();
	if( _id !== null && _id !== '' ){
		consultar_registro(_id);
	}else{
		swal({
			type: 'error',
			title: 'Oops...',
			text: 'Ocurrio un inconveniente, favor intente nuevamente',
		  	confirmButtonText:'Aceptar'
		});
	}
}

function desactivar(e){
	var _id = $(e).parent().parent().parent().find('#id_registro').html();
	swal({
		title: '¿Esta seguro que desea desactivar este registro?',
		html: "Si el registro a desactivar es de <b>ENTRADA</b>, seran desactivados tanto <b>ENTRADA</b> como <b>SALIDA</b> de esa fecha, en caso de ser <b>SALIDA</b> solo sera desactivado ese registro.<br> <u>Tenga en cuenta que estos cambios son irreversibles.</u>",
		type: 'warning',
		allowOutsideClick : false,
		allowEscapeKey  :false,
		allowEnterKey : false,
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, estoy seguro',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		
		if (result.value) {

			swal.showLoading();
			$.ajax({
				url: _base_url+"Asistencia/ajax_desactivar_registro_dia",
				type: 'POST',
				dataType: 'JSON',
				data: { id_registro: _id },
				asyc : false
			})
			.done(function(data,error) {
				swal(
				  'Desactivado!',
				  'Se desactivo el registro selccionado',
				  'success'
				).then( (result) => {
					console.log(result.value);
					if(result.value){
						espera(true);
						location.reload(true);
					}
				}
				);
			})
			.fail(function(e) {
				swal(
				  'Error',
				  'Ocurrio un inconveniente al momento de procesar su solicitud, favor intente nuevamente y su el problema persiste pongase en contacto con los Administradores',
				  'error'
				);
			})
			.always(function() {
				swal.hideLoading();
			});
		}
	});
}

$(document).ready(function() {

	var _form = $("#consulta_fecha").validate({
		errorElement: "span",
		rules : {
			fecha : {
				required : true,
				dateITA:true
			}
		},		
		unhighlight : function(element){ 
			$("div #"+element.id+"-error").appendTo('');
		},
		errorPlacement: function(error, element) {
		    error.appendTo('div #'+error[0].id);
		    gestion_elemento("consultar",false);
		},
		success : function(element){
		    gestion_elemento("consultar",true);
			$("#consulta_fecha").on('submit', function(event) {
				event.preventDefault();
			});
		}
	});
	_form.form();

	$("#fecha").on('change',  function(event) {
		_form.form();
	});

	$("#limpiar").appendTo("#list_filter").removeClass('hidden').attr('disabled', 'disabled');
	$("#limpiar").on('click', function(event) {
		event.preventDefault();
		$("#fecha").val('');
		$("#fecha").datepicker('clearDates');
		gestion_elemento("fecha",true);
		$("#fecha").focus();
		gestion_elemento("limpiar",false);
		$("#list>tbody").find('tr').remove();
		
	});

	$("#consultar").on('click', function(event) {
		gestion_elemento("consultar",false);
		gestion_elemento("fecha",false);
		if( _form.valid() == true ){
			consultar_fecha();
		}else{
			_form.form();
		}
	});

	$("#fecha").datepicker({autoclose: true
				,language:'es'
				,format: 'dd/mm/yyyy'
				,daysOfWeekDisabled:'[0,6]'
	 			,todayHighlight : true});
	
});