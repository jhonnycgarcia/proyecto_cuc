<?php
require APPPATH.'../assets/ezpdf/src/Cezpdf.php';

//FUNCION PARA LA FECHA
function FechaEs ($sintax,$date = '') {
    // En caso de qe no este seteada la fecha pongo la fecha actual
    $date = ($date) ? $date : time();
    // Pongo los meses y dias en un array
    $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    $dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');

    // Remplazando sintaxis [En el array $meses resto uno ya que como saben los array cuentan desde 0]
    $fechaes = str_replace('&diatexto',$dias[date('w',$date)],$sintax);
    $fechaes = str_replace('&dianum',date('d',$date),$fechaes);
    $fechaes = str_replace('&mestexto',$meses[date('m',$date)-1],$fechaes);
    $fechaes = str_replace('&mesnum',date('m',$date),$fechaes);
    $fechaes = str_replace('&año',date('Y',$date),$fechaes);

    return ($fechaes) ? $fechaes : '<b>Sintax Error</b>: sintax error in <b>'.__FILE__.'</b> in function <b>FechaEs(int sintax,int time)</b>';
}
$f_fecha=FechaEs('&diatexto &dianum de &mestexto del &año');

// ****************** Abrir el PDF **********************************
$pdf = new Cezpdf('LETTER','portrait');

$fonts = 'Helvetica';               // Establecer Fuente
$pdf->selectFont($fonts);
$pdf->ezSetCmMargins(2,2,2,2);      // Establecer Margenes
// ******************************************************************
$newp = 0;
foreach ($datos as $key => $value) {
	if($newp >=1){
		$pdf->ezNewPage();
	}

	$f_fecha = FechaEs('&diatexto &dianum de &mestexto del &año',strtotime($value['fecha']) );
	
	if( array_key_exists('entrada', $value) AND count($value['entrada']) > 0 ){
		$pdf->ezText("Registros de Entrada\n",12,array('justification'=>'centre'));
		$pdf->ezText($f_fecha."\n",12,array('justification'=>'centre'));

		$pdf->ezTable($value['entrada']
			,array(
				'hora' => 'Hora',
				'cedula' => 'Cédula',
				'apellidos_nombres' => 'Apellidos y Nombres',
				'cargo' => 'Cargo',
				'coordinacion' => 'Coordinación',
				'observaciones' => 'Observaciones',
			)
			,''
			,array(
				'showHeadings' => 1,
				'xOrientation' => 'centre',
				'fontSize' => 7,
				'gridlines'=> EZ_GRIDLINE_DEFAULT,
				'width' => 550,
				'maxWidth' => 550,
				'cols' => array(
							'cedula' => array(
											'justification' => 'center',
											'width' => 50
										),
							'hora' => array(
											'justification' => 'center',
											'width' => 60
										),
							'apellidos_nombres' => array(
											'justification' => 'left',
											'width' => 100
										),
							'cargo' => array(
											'justification' => 'center',
											'width' => 60
										),
							'coordinacion' => array(
											'justification' => 'center',
											'width' => 150
										)
						)
			)
		);

	}

	if( (array_key_exists('entrada', $value) AND count($value['entrada']) > 0) AND
		(array_key_exists('salida', $value) AND count($value['salida'] ) > 0) ){
		$pdf->ezNewPage();
	}

	if ( array_key_exists('salida', $value) AND count($value['salida'] ) > 0 ) {
		$pdf->ezText("Registros de Salida\n",12,array('justification'=>'centre'));
		$pdf->ezText($f_fecha."\n",12,array('justification'=>'centre'));
		
		$pdf->ezTable($value['salida']
			,array(
				'hora' => 'Hora',
				'cedula' => 'Cédula',
				'apellidos_nombres' => 'Apellidos y Nombres',
				'cargo' => 'Cargo',
				'coordinacion' => 'Coordinación',
				'observaciones' => 'Observaciones',
			)
			,''
			,array(
				'showHeadings' => 1,
				'xOrientation' => 'centre',
				'fontSize' => 7,
				'gridlines'=> EZ_GRIDLINE_DEFAULT,
				'width' => 550,
				'maxWidth' => 550,
				'cols' => array(
							'cedula' => array(
											'justification' => 'center',
											'width' => 50
										),
							'hora' => array(
											'justification' => 'center',
											'width' => 60
										),
							'apellidos_nombres' => array(
											'justification' => 'left',
											'width' => 100
										),
							'cargo' => array(
											'justification' => 'center',
											'width' => 60
										),
							'coordinacion' => array(
											'justification' => 'center',
											'width' => 150
										)
						)
			)
		);
	}

	$newp++;
}


// ****************** Cerrar el PDF *********************************
ob_end_clean();
$pdf->ezOutput(TRUE);
$pdf->ezStream(array('compress'=>0,'Content-Disposition'=>'Reporte_asistencia.pdf'));
// ******************************************************************


