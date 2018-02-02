<?php


/**
 * Funcion para validar los parametros de seguridad dentro del sistema en desarrollo
 */
Class Seguridad_lib {

	public $db;
	public $ci;

	function __construct( $config = array() ){
		if( array_key_exists('db', $config) )
			$this->db = $config['db'];
		$this->ci =& get_instance();				// Cargar librerias de CodeIgniter
		$this->ci->load->model('Seguridad_M');		// Cargar modelo
	}


	/**
	 * Funcion para validar si se encuentra iniciada una session en el sistema
	 * @param  boolean 		$retornar 		[si esta declarada en TRUE retorna el resultado de la consulta]
	 * @return mix			$ans            booleano en caso de requerirlo o redirecciona a la base url
	 */
	function login_in( $redireccionar = false ){
		$data = $this->ci->session->userdata();
		$ans = false;
		if ( array_key_exists('id_usuario', $data) ) 			// No hay ningun usuario registrado
			$ans = true;
		if( !$ans AND $redireccionar )									// Si se desea redireccionar
			redirect( base_url() );
		return $ans;
	}


	function acceso_metodo($metodo){
		$metodo = str_replace('::', '/', $metodo);
		$id_usuario = $this->ci->session->userdata('id_usuario');
		$login = $this->login_in(true);									// Validar logeo
		// $ans = $this->validar_acceso_metodo($id_usuario,$metodo);		// validar acceso 
	}

	/**
	 * Funcion para validar el acceso a una funcion consultado la base de datos
	 * @param  integer 			$id_usuario 				[id del usuario logeado]
	 * @param  string 			$metodo     				[nombre del controlador y metodo]
	 * @return mix(boolean-False or Redirect)             	[false en caso de no tener acceso]
	 */
	// function validar_acceso_metodo($id_usuario,$metodo){
	// 	$ans = false;
	// 	$id_sistema_menu = $this->ci->Seguridad_M->get_id_sistema_menu($metodo);
	// 	if( count($id_sistema_menu) < 0 )
	// 		return $ans;
	// 	$id_sistema_menu += array('id_usuario' => $id_usuario);			// Concatenar id_usuario en los datos de la opcion MENU
	// 	$validar = $this->ci->Seguridad_M->get_acceso_usuario($id_sistema_menu);
	// 	if( !$validar )
	// 		redirect( base_url() );
	// }


}