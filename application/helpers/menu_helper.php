<?php

function imprimir_item($datos,$tipo = false){
	$link = "";
	if( $tipo ){
		$link = $datos['link'];
		$contenido[0] = "\n\t\t\t\t<i class='".$datos['icono']."'></i>\n";
		$contenido[1] = "\t\t\t\t<span>".$datos['menu']."</span>\n\t\t\t";
	}else{
		$link = "#";
		$contenido[0] = "\n\t\t\t\t<i class='".$datos['icono']."'></i>\n";
		$contenido[1] = "\t\t\t\t<span>".$datos['menu']."</span>\n";
		$contenido[2] = "\t\t\t\t<span class='pull-right-container'>\n"
						."\t\t\t\t\t<i class='fa fa-angle-left pull-right'></i>\n"
						."\t\t\t\t</span>\n\t\t\t";

	}
	return anchor($link, implode('', $contenido), array() );
}

