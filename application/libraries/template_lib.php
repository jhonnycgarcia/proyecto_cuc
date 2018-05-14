<?php


/**
 * Funcion para validar los parametros de seguridad dentro del sistema en desarrollo
 */
Class Template_lib {


	function __construct(){
		$this->ci =& get_instance();				// Cargar librerias de CodeIgniter
		$this->ci->load->model('Configuraciones_M');		// Cargar modelo
		$this->ci->load->model('Template_M');		// Cargar modelo
	}

	/**
	 * Funcion para renderiza la vista
	 * @param  array  $config  			Variable de configuracion para la carga del template
	 * 
	 *                            		'e_header' [ARRAY]
	 *                            				'nombre'		=> Descripcion que aparecera en la DOM
	 *                            				'path'			=> Ubicacion en el servidor del archivo
	 *                            				'ext'			=> Extension del archivo JS, CSS
	 *                            				
	 *                            		'e_footer' [ARRAY]
	 *                            				'nombre'		=> Descripcion que aparecera en la DOM
	 *                            				'path'			=> Ubicacion en el servidor del archivo
	 *                            				'ext'			=> Extension del archivo JS, CSS
	 *                            				
	 *                            		'titulo_contenedor'		=> El titulo que aparecera sobre el conrenedor
	 *                            		'titulo_descripcion'	=> El texto que acompañara el titulo del contenedor
	 *                            		'contenido'				=> La vista a cargar
	 *                            		
	 *                              	dentro de esta variable se puede definir otras claves  que el usuario vaya a utilizar.
	 * 	
	 * 					
	 * @return [type]         [description]
	 */
	public function render($config = array() ){
		$this->configuracion();
		$this->ci->load->view('template/template',$config);
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

	function configuracion($retornar=false){
		$consulta = $this->ci->Configuraciones_M->consultar_lista(true);
		if( count($consulta)> 0){
			if( $retornar){
				echo json_encode($consulta[0]);
			}else{
				$consulta = $consulta[0];
				$configuracion['tema_template'] = $consulta['tema_template'];
				$configuracion['tiempo_max_inactividad'] = $consulta['tiempo_max_inactividad'];
				$configuracion['tiempo_max_alerta'] = $consulta['tiempo_max_alerta'];
				$configuracion['tiempo_max_espera'] = $consulta['tiempo_max_espera'];
				$configuracion['camara'] = $consulta['camara'];
				$this->ci->session->set_userdata('configuracion',$configuracion);
			}
		}
	}

	function obtener_items_menu($usuario_id = NULL, $padre = 0, $estatus = TRUE){
		if(is_null($usuario_id)) return NULL;
		$consultar = $this->ci->Template_M->obtener_items_menu($usuario_id,$padre,$estatus);
		if(is_null($consultar)) return NULL;
		return $consultar;
	}
}