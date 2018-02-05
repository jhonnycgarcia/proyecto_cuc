<?php


/**
 * Funcion para validar los parametros de seguridad dentro del sistema en desarrollo
 */
Class Template_lib {

	public function render($config = array() ){
		// echo "string";
	}

	function cargar_etiquetas($etiquetas){
		if( is_array($etiquetas) AND count($etiquetas) > 0 ){
			foreach ($etiquetas as $key => $row) {
				$ext = NULL;
				$path = NULL;
				$nombre = NULL;

				if( array_key_exists('ext', $row) )
					$ext = $row['ext'];
				if( array_key_exists('path', $row) )
					$path = $row['path'];
				if( array_key_exists('nombre', $row) )
					$nombre = $row['nombre'];

				if( is_null($nombre) AND !is_null($ext) AND !is_null($path) ){
					$this->imprimir_etiqueta(NULL,$path,$ext);
				}elseif ( !is_null($nombre) AND !is_null($ext) AND !is_null($path) ) {
					$this->imprimir_etiqueta($nombre,$path,$ext);
				}
			}

		}
	}

	function imprimir_etiqueta($titulo = NULL,$path,$extension){

		$extension = strtoupper($extension); // convertir a mayusculas
	 
		// Titulo de la etiqueta
		$e_titulo [0] = "	<!-- ";
		$e_titulo [1] = "";
		$e_titulo [2] = " -->";

		// Etiqueta LINK
		$e_link [0] = "	<link rel='stylesheet' href=' ";
		$e_link [1] = "";
		$e_link [2] = "'>";

		// Etiqueta SCRIPT
		$e_script [0] = "	<script src=' ";
		$e_script [1] = "";
		$e_script [2] = "'></script>";

		if( strtoupper($extension) == 'CSS' ):

			if( !is_null($titulo) ): // el titulo no este vacio
				$e_titulo[1] = $titulo;
				echo implode('', $e_titulo)."\n";
			endif;

			$e_link[1] = $path;
			echo implode('', $e_link)."\n";

		;elseif( strtoupper($extension) == 'JS' ):

			if( !is_null($titulo) ): // el titulo no este vacio
				$e_titulo[1] = $titulo;
				echo implode('', $e_titulo)."\n";
			endif;

			$e_script [1] = $path;
			echo implode('', $e_script)."\n";
		endif;
	}
}