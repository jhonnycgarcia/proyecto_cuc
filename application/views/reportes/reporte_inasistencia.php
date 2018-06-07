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
$pdf->addInfo ('Title',"Reporte de Inasistencias");
// ******************************************************************

// ****************** Header y Footer *******************************
$header_footer = $pdf->openObject();


$header_cgp = APPPATH.'../assets/images/logo_cabecera_cgp.jpg';
$pdf->AddJpegFromFile( $header_cgp,50,710,82);
$header_atv =  APPPATH.'../assets/images/logo_cabecera_atv.jpg';
$pdf->AddJpegFromFile( $header_atv,500,710,70);
// $pdf->line(30,780,582,780);
// $pdf->line(30,710,582,710);

$footer =  APPPATH.'../assets/images/footer2018.jpg';
$pdf->AddJpegFromFile( $footer,30,12,550);
// $pdf->line(30,30,582,30);

$page_num = 'Página {PAGENUM} de {TOTALPAGENUM}';
$pdf->ezStartPageNumbers(270, 5, 8, '', $page_num, 1);

$pdf->closeObject();
$pdf->addObject($header_footer, "all");

// ******************************************************************

$newp = 0;
foreach ($datos as $key => $value) {
	if($newp >=1){
		$pdf->ezNewPage();
	}

	$f_fecha = FechaEs('&diatexto &dianum de &mestexto del &año',strtotime($value['fecha']) );
	
	if( array_key_exists('registros', $value) AND count($value['registros']) > 0 ){
		$pdf->ezText("Inasistencias del día <b>".$f_fecha."</b>\n",12,array('justification'=>'centre'));

		$pdf->ezTable($value['registros']
			,array(
				'nro' => '#',
				'cedula' => 'Cédula',
				'apellidos_nombres' => 'Apellidos y Nombres',
				'cargo' => 'Cargo',
				'coordinacion' => 'Coordinación',
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
											'width' => 300
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


