<?php
require 'src/Cezpdf.php';

$pdf = new Cezpdf('LETTER','portrait');

$fonts = 'Helvetica';               // Establecer Fuente
$pdf->selectFont($fonts);
$pdf->ezSetCmMargins(3,2,2,2);      // Establecer Margenes

$data = array(
	array('nro' => 1,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 2,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 3,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 4,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 5,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 6,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 7,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 8,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 9,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 10,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 11,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 12,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 13,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 14,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 15,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 16,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 17,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 18,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 19,'cedula' => '21535233', 'nombre' => 'Jhonny')
	,array('nro' => 20,'cedula' => '21535233', 'nombre' => 'Jhonny')
	);

$e = array('nro' => 'Nro', 'cedula' => 'Cedula','nombre' => 'Nombre');

$pdf->ezTable($data, $e, 'Datos');


ob_end_clean();
$pdf->ezOutput(TRUE);
$pdf->ezStream(array('compress'=>0));