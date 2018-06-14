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
$pdf->addInfo ('Title',"Reporte General de Trabajadores Activos");
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

// $pdf->ezText("<b>Informe Personal</b>\n",12,array('justification'=>'centre'));

if( !is_null($datos) && count($datos)>0 ){
	$_i = 0;
	foreach ($datos as $key_dir => $value_dir) {
		if($_i>0) $pdf->ezSetDy(-20);

		if ($value_dir['nro_trabajadores_total'] >0) {
			// $pdf->ezText("<b>".$value_dir['direccion']."</b>\n",12,array('justification'=>'centre'));
			$row = array( array("a"=>"<b>".$value_dir['direccion']."</b>") );
			$pdf->ezTable(
				$row
				,array("a"=>"")
				,""
				,array(
					'showHeadings' => 0
					,'shadeHeadingCol'=> array($r,$g,$b)
					,'xOrientation' => 'centre'
					,'fontSize' => 12
					,'gridlines'=> EZ_GRIDLINE_DEFAULT
					,'width' => 550
					,'maxWidth' => 550
					,'cols' => array(
						'a' => array('justification' => 'center','bgcolor'=>array($r,$g,$b))
					)
				)
			);

			$row = array( array("a"=>'Nro Coordinaciones'
				,'b'=>$value_dir['nro_coordinaciones'] 
				,'c'=>'Nro Trabajadores' 
				,'d'=>$value_dir['nro_trabajadores_total'] )
			);
			$pdf->ezTable(
				$row
				,array("a"=>"",'b'=>'','c'=>'','d'=>'')
				,""
				,array(
					'showHeadings' => 0
					,'shadeHeadingCol'=> array($r,$g,$b)
					,'xOrientation' => 'centre'
					,'fontSize' => 8
					,'gridlines'=> EZ_GRIDLINE_DEFAULT
					,'width' => 550
					,'maxWidth' => 550
					,'cols' => array(
						'a' => array('width'=> 120,'justification' => 'center','bgcolor'=>array($r,$g,$b))
						,'b' => array('width'=> 150,'justification' => 'center')
						,'c' => array('width'=> 80,'justification' => 'center','bgcolor'=>array($r,$g,$b))
						,'d' => array('width'=> 200,'justification' => 'center')
					)
				)
			);

			if( !is_null($value_dir['coordinaciones']) ){
				foreach ($value_dir['coordinaciones'] as $key_cor => $value_cor) {
					$pdf->ezSetDy(-10);
					$row = array( array("a"=>$value_cor['coordinacion']) );
					$pdf->ezTable(
						$row
						,array("a"=>"")
						,""
						,array(
							'showHeadings' => 0
							,'shadeHeadingCol'=> array($r,$g,$b)
							,'xOrientation' => 'centre'
							,'fontSize' => 10
							,'gridlines'=> EZ_GRIDLINE_DEFAULT
							,'width' => 550
							,'maxWidth' => 550
							,'cols' => array(
								'a' => array('justification' => 'center','bgcolor'=>array($r,$g,$b))
							)
						)
					);

					$row =$value_cor['trabajadores'];
					$pdf->ezTable(
						$row
						,array(
							'nro'=>'Nro'
							,'cedula'=>'Cedula'
							,'apellido_nombre'=>'Apellidos y Nombres'
							,'cargo'=>'Cargo'
							,'condicion_laboral'=>'Condición Laboral'
						)
						,""
						,array(
							'showHeadings' => 1
							,'shadeHeadingCol'=> array($r,$g,$b)
							,'xOrientation' => 'centre'
							,'fontSize' => 8
							,'gridlines'=> EZ_GRIDLINE_DEFAULT
							,'width' => 550
							,'maxWidth' => 550
							,'cols' => array(
								'cedula' => array('width'=> 60,'justification' => 'center')
								,'cargo' => array('width'=> 80,'justification' => 'center')
								,'condicion_laboral' => array('width'=> 110,'justification' => 'center')
								,'apellido_nombre' => array('width'=> 270,'justification' => 'left')
							)
						)
					);


				}
			}
		}




		$_i++;
	}

}

// ****************** Cerrar el PDF *********************************
ob_end_clean();
$pdf->ezOutput(TRUE);
$pdf->ezStream(array('compress'=>0,'Content-Disposition'=>'Listado_general_trabajadores.pdf'));
// ******************************************************************
