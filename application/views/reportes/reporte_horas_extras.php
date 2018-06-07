<?php
require APPPATH.'../assets/ezpdf/src/Cezpdf.php';
// foreach ($datos as $key => $value) {
// 	var_export($value);echo "<br><br>";
// }
// exit();

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

$fonts = APPPATH.'../assets/ezpdf/src/fonts/Helvetica.afm';               // Establecer Fuente
// $fonts = 'Helvetica';               // Establecer Fuente
$pdf->selectFont($fonts);
$pdf->ezSetCmMargins(2.5,2,2,2);      // Establecer Margenes
$pdf->addInfo ('Title',"Reporte Horas Extras");

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

// $pdf->ezText("Cedula =  ".$pdf->y."</b>\n",12,array('justification'=>'centre'));
$pdf->rectangle(33, 60, 175,40);
$pdf->addText(37,76,10,"Elaborado por:");
$pdf->rectangle(215, 60, 175,40);
$pdf->addText(219,76,10,"Validado por:");
$pdf->rectangle(397, 60, 182,40);
$pdf->addText(401,76,10,"Aprobado por:");

$pdf->closeObject();
$pdf->addObject($header_footer, "all");

// ******************************************************************



$r = (1/255) * 235;
$g = (1/255) * 237;
$b = (1/255) * 239;

$newp = 0;
foreach ($datos as $key => $value) {
	if($newp >=1){
		$pdf->ezNewPage();
	}

	$pdf->ezText("<b>CONTROL DE HORAS EXTRAS</b>\n",14,array('justification'=>'centre'));

	$row = array(
			array("cedula" => $value['cedula']
				,"apellidos_nombres" => $value['apellidos_nombres']
				,"condicion_laboral" =>$value['condicion_laboral']
				,"cargo" => $value['cargo']
				)
		);
	$pdf->ezTable(
		$row
		, array(
			"cedula" => "<b>CEDULA</b>"
			,"apellidos_nombres" => "<b>APELLIDOS Y NOMBRES</b>"
			,"condicion_laboral" => "<b>TIPO TRABAJADOR</b>"
			,"cargo" => "<b>CARGO</b>"
		)
		,""
		// ,"<b>CONTROL DE HORAS EXTRAS</b>"
		, array(
			'showHeadings' => 1
			,'xOrientation' => 'centre'
			// ,'shadeHeadingCol'=> array(172,214,241)
			,'shadeHeadingCol'=> array($r,$g,$b)
			// ,'shadeHeadingCol'=> array(0.8,0.8,0.8)
			,'titleFontSize' => 10
			,'fontSize' => 7
			,'width' => 550
			,'maxWidth' => 550
			,'cols' => array(
				"cedula" => array(
							'justification' => 'center'
							,'width' => 60
						)
				,"condicion_laboral" => array(
							'justification' => 'center',
							'width' => 80
						)
				,"cargo" => array(
							'justification' => 'center',
							'width' => 80
						)
			)
		)
	);

	$fperiodo = FechaEs('&mestexto &año',strtotime('01/'.$vale['periodo_laboral']) );
	$row = array(
			array(
				"unidad" => "CGP"
				,"ubicacion" => $value['coordinacion']
				,"periodo" => $fperiodo
			)
	);
	$pdf->ezTable(
		$row
		, array(
			"unidad" => "<b>UNIDAD ADMINISTRATIVA</b>"
			,"ubicacion" => "<b>UBICACION FISICA</b>"
			,"periodo" => "<b>PERIODO LABORA</b>"
		)
		,""
		, array(
			'showHeadings' => 1
			,'xOrientation' => 'centre'
			,'shadeHeadingCol'=> array($r,$g,$b)
			// ,'shadeHeadingCol'=> array(0.52,1.34,2.46)
			,'titleFontSize' => 10
			,'fontSize' => 7
			,'width' => 550
			,'maxWidth' => 550
			,'cols' => array(
				"unidad" => array(
							'justification' => 'center'
							,'width' => 100
						)
				,"periodo" => array(
							'justification' => 'center'
							,'width' => 80
						)
			)
		)
	);

	if( array_key_exists('registros', $value) AND count($value['registros']) > 0 )
	{
		$pdf->ezTable(
			$value['registros']
			, array(
				"fecha" => "<b>DIA</b>"
				,"observaciones" => "<b>JUSTIFICACION</b>"
				,"hora_entrada" => "<b>ENTRADA</b>"
				,"hora_salida" => "<b>SALIDA</b>"
				,"no_laborable" => "<b>NO LABORAL</b>"
				,"horas_extras_diurnas" => "<b>DIURNAS</b>"
				,"horas_extras_nocturnas" => "<b>NOCTURNAS</b>"
				// ,"horas_extras" => "<b>EXTRAS</b>"
			)
			,""
			, array(
				'showHeadings' => 1
				,'xOrientation' => 'centre'
				,'shadeHeadingCol'=> array($r,$g,$b)
				// ,'shadeHeadingCol'=> array(0.52,1.34,2.46)
				,'titleFontSize' => 10
				,'fontSize' => 7
				,'width' => 550
				,'maxWidth' => 550
				,'cols' => array(
					"fecha" => array(
								'justification' => 'center'
								,'width' => 60
							)
					,"hora_entrada" => array(
								'justification' => 'center'
								,'width' => 60
							)
					,"hora_salida" => array(
								'justification' => 'center'
								,'width' => 60
							)
					,"no_laborable" => array(
								'justification' => 'center'
								,'width' => 60
							)
					,"horas_extras_diurnas" => array(
								'justification' => 'center'
								,'width' => 60
							)
					,"horas_extras_nocturnas" => array(
								'justification' => 'center'
								,'width' => 60
							)
					,"horas_extras" => array(
								'justification' => 'center'
								,'width' => 60
							)
				)
			)
		);
	}

	$row = array(
			array("a" => "<b>SUB-TOTAL</b>","b" => $value['total_horas_extras_diurnas'],"c"=>$value['total_horas_extras_nocturnas'])
			// ,array("a" => "<b>TOTAL HORAS NOCTURNAS</b>","b" => $value['total_horas_extras_nocturnas'])
			// ,array("a" => "<b>TOTAL HORAS EXTRAS</b>","b" => $value['total_horas_extras'])
	);
	$pdf->ezTable(
		$row
		, array(
			"a" => ""
			,"b" => ""
			,"c" => ""
		)
		,""
		, array(
			'showHeadings' => 0
			,'xPos' => 461
			,'titleFontSize' => 10
			,'fontSize' => 7
			,'width' => 550
			,'gridlines'=> 27
			,'maxWidth' => 550
			,'cols' => array(
				"a" => array(
							'justification' => 'center'
							,'width' => 120
							,'bgcolor'=> array($r,$g,$b)
							// ,'bgcolor'=> array(0.52,1.34,2.46)
						)
				,"b" => array(
							'justification' => 'center'
							,'width' => 60
						)
				,"c" => array(
							'justification' => 'center'
							,'width' => 60
						)
			)
		)
	);

	$row = array(
			array("a" => "<b>TOTAL HORAS EXTRAS</b>","b" => $value['total_horas_extras'])
	);
	$pdf->ezTable(
		$row
		, array(
			"a" => ""
			,"b" => ""
		)
		,""
		, array(
			'showHeadings' => 0
			,'xPos' => 461
			,'titleFontSize' => 10
			,'fontSize' => 7
			,'width' => 550
			,'gridlines'=> 27
			,'maxWidth' => 550
			,'cols' => array(
				"a" => array(
							'justification' => 'center'
							,'width' => 120
							,'bgcolor'=> array($r,$g,$b)
							// ,'bgcolor'=> array(0.52,1.34,2.46)
						)
				,"b" => array(
							'justification' => 'center'
							,'width' => 120
						)
			)
		)
	);

/*	$pdf->ezText("\n",12,array('justification'=>'centre'));

	$row = array(
		array('a'=> "Elaborado por:", "b" => "", "c"=>"Validado por:","d"=>"","e"=>"Aprobado por:","f"=>"")
	);
	$pdf->ezTable(
		$row
		, array(
			"a" => ""
			// ,"b" => ""
			,"c" => ""
			// ,"d" => ""
			,"e" => ""
			// ,"f" => ""
		)
		,""
		, array(
			'showHeadings' => 0
			,'xOrientation' => 'centre'
			,'shadeHeadingCol'=> array(0.52,1.34,2.46)
			,'titleFontSize' => 10
			,'fontSize' => 7
			,'rowGap' => 15
			,'colGap' => 5 
			,'width' => 550
			,'maxWidth' => 550
			,'cols' => array(
				"a" => array(
							'justification' => 'left'
							,'width' => 182
							// ,'width' => 60
						)
				// ,"b" => array(
				// 			'justification' => 'left'
				// 			,'width' => 122
				// 		)
				,"c" => array(
							'justification' => 'left'
							,'width' => 182
							// ,'width' => 60
						)
				// ,"d" => array(
				// 			'justification' => 'left'
				// 			,'width' => 122
				// 		)
				,"e" => array(
							'justification' => 'left'
							,'width' => 182
							// ,'width' => 60
						)
				// ,"f" => array(
				// 			'justification' => 'left'
				// 			,'width' => 122
				// 		)
			)
		)
	);*/

	$newp++;
}


// ****************** Cerrar el PDF *********************************
ob_end_clean();
$pdf->ezOutput(TRUE);
$pdf->ezStream(array('compress'=>0,'Content-Disposition'=>'Reporte_asistencia.pdf'));
// ******************************************************************


