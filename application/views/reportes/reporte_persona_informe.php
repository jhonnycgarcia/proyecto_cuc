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
$pdf->ezSetCmMargins(3,2,2,2);      // Establecer Margenes
$pdf->addInfo ('Title',"Informe Personal");
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
$r = (1/255) * 235;
$g = (1/255) * 237;
$b = (1/255) * 239;

$pdf->ezText("<b>Informe Personal</b>\n",12,array('justification'=>'centre'));

$row = array( array("a"=>"Datos Personales") );
$pdf->ezTable(
	$row
	,array("a"=>"")
	,""
	,array(
		'showHeadings' => 0
		,'shadeHeadingCol'=> array($r,$g,$b)
		,'xOrientation' => 'centre'
		// ,'xOrientation' => 'left'
		// ,'xPos' => 220
		,'fontSize' => 7
		,'gridlines'=> EZ_GRIDLINE_DEFAULT
		,'width' => 550
		,'maxWidth' => 550
		,'cols' => array(
			'a' => array('justification' => 'center','bgcolor'=>array($r,$g,$b))
		)
	)
);

$row = array( 
	array("a"=>$datos['p_apellido']
		,"b"=>$datos['s_apellido']
	) 
);
$pdf->ezTable(
	$row
	,array("a"=>"Primer Apellido",'b'=>'Segundo Apellido')
	,""
	,array(
		'showHeadings' => 1
		,'shadeHeadingCol'=> array($r,$g,$b)
		,'xOrientation' => 'centre'
		,'xOrientation' => 'left'
		,'xPos' => 511
		,'fontSize' => 7
		,'gridlines'=> EZ_GRIDLINE_DEFAULT
		,'width' => 550
		,'maxWidth' => 550
		,'cols' => array(
			'a' => array('width' => 240)
			,'b' => array('width' => 240)
		)
	)
);

$row = array( 
	array("a"=>$datos['p_nombre']
		,"b"=>$datos['s_nombre']
	) 
);
$pdf->ezTable(
	$row
	,array("a"=>"Primer Nombre",'b'=>'Segundo Nombre')
	,""
	,array(
		'showHeadings' => 1
		,'shadeHeadingCol'=> array($r,$g,$b)
		,'xOrientation' => 'centre'
		,'xOrientation' => 'left'
		,'xPos' => 511
		,'fontSize' => 7
		,'gridlines'=> EZ_GRIDLINE_DEFAULT
		,'width' => 550
		,'maxWidth' => 550
		,'cols' => array(
			'a' => array('width' => 240)
			,'b' => array('width' => 240)
		)
	)
);

$row = array( 
	array("a"=>$datos['cedula']
		,"b"=>$datos['fecha_nacimiento']
		,"c"=>$datos['estado_civil']
		,"d"=>$datos['tipo_sangre']
	) 
);
$pdf->ezTable(
	$row
	,array("a"=>"Cedula",'b'=>'Fecha Nacimiento','c'=>'Estado Civil','d'=>'Tipo Sangre')
	,""
	,array(
		'showHeadings' => 1
		,'shadeHeadingCol'=> array($r,$g,$b)
		,'xOrientation' => 'centre'
		,'xOrientation' => 'left'
		,'xPos' => 511
		,'fontSize' => 7
		,'gridlines'=> EZ_GRIDLINE_DEFAULT
		,'width' => 550
		,'maxWidth' => 550
		,'cols' => array(
			'a' => array('width' => 120)
			,'b' => array('width' => 120)
			,'c' => array('width' => 120)
			,'d' => array('width' => 120)
		)
	)
);

if( !is_null($datos['imagen']) ){
	$foto = APPPATH.'../assets/images/fotos/'.$datos['imagen'];
  	$data = @getimagesize($foto);
  	if( $data ){
		$pdf->AddJpegFromFile($foto,511,593,65,73);
  	}
}else{
	$pdf->addText(528,625,12,"<b>FOTO</b>");
	$pdf->line(511,593,581,666);
	$pdf->line(581,593,511,666);
}

$pdf->rectangle(511, 593, 70,73);

$row = array( 
	array("a"=>$datos['telefono_1']
		,"b"=>$datos['telefono_2']
		,"c"=>$datos['sexo']
		,"d"=>$datos['email']
	) 
);
$pdf->ezTable(
	$row
	,array("a"=>"Telefono Principal",'b'=>'Telefono Secundario','c'=>'Sexo','d'=>'Email')
	,""
	,array(
		'showHeadings' => 1
		,'shadeHeadingCol'=> array($r,$g,$b)
		,'xOrientation' => 'centre'
		,'xOrientation' => 'left'
		,'xPos' => 581
		,'fontSize' => 7
		,'gridlines'=> EZ_GRIDLINE_DEFAULT
		,'width' => 550
		,'maxWidth' => 550
		,'cols' => array(
			'a' => array('width' => 120)
			,'b' => array('width' => 120)
			,'c' => array('width' => 120)
			,'d' => array('width' => 190)
		)
	)
);

$row = array( array("a"=>$datos['direccion']) );
$pdf->ezTable(
	$row
	,array("a"=>"Dirección")
	,""
	,array(
		'showHeadings' => 1
		,'shadeHeadingCol'=> array($r,$g,$b)
		,'xOrientation' => 'centre'
		// ,'xOrientation' => 'left'
		// ,'xPos' => 220
		,'fontSize' => 7
		,'gridlines'=> EZ_GRIDLINE_DEFAULT
		,'width' => 550
		,'maxWidth' => 550
		,'cols' => array(
			'a' => array()
		)
	)
);


if(!is_null($datos['historial']) && count($datos['historial']) >0 ){
	$pdf->ezSetDy(-10);
	$pdf->ezText("<b>Historial</b>\n",12,array('justification'=>'centre'));

	$pdf->ezTable(
		$datos['historial']
		,array(
			"nro"=>"#"
			,"cargo"=>"Cargo"
			,"condicion_laboral"=>"Condición Laboral"
			,"coordinacion"=>"Coordinación"
			,"fecha_ingreso"=>"Fecha Ingreso"
			,"fecha_egreso"=>"Fecha Egreso"
		)
		,""
		,array(
			'showHeadings' => 1
			,'shadeHeadingCol'=> array($r,$g,$b)
			,'xOrientation' => 'centre'
			,'fontSize' => 7
			,'gridlines'=> EZ_GRIDLINE_DEFAULT
			,'width' => 550
			,'maxWidth' => 550
			,'cols' => array(
				'condicion_laboral' => array('width' => 100)
				,'cargo' => array('width' => 80)
				,'fecha_ingreso' => array('width' => 60)
				,'fecha_egreso' => array('width' => 60)
			)
		)
	);
}

// ****************** Cerrar el PDF *********************************
ob_end_clean();
$pdf->ezOutput(TRUE);
$pdf->ezStream(array('compress'=>0,'Content-Disposition'=>'Informe_personal.pdf'));
// ******************************************************************
