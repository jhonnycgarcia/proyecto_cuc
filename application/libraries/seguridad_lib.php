<?php


/**
 * Funcion para validar los parametros de seguridad dentro del sistema en desarrollo
 */
Class Seguridad_lib {

	public $ci;
	public $row_bitacora = array(
			'fecha' 		=> '',
			'ip'			=> '',
			'accion'		=> '',
			'usuario'		=> '',
			'descripcion'	=> ''
		);

	function __construct(){
		$this->ci =& get_instance();				// Cargar librerias de CodeIgniter
		$this->ci->load->model('Seguridad_M');		// Cargar modelo
	}

	/**
	 * Funcion para verificar si existe una sesion activa
	 * @param  boolean $redireccionar [description]
	 * @return [type]                 [description]
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

	/**
	 * Funcion para verificar el acceso a los metodos
	 * @param  [type] $metodo [description]
	 * @return [type]         [description]
	 */
	function acceso_metodo($metodo){
		$metodo = str_replace('::', '/', $metodo);
		$metodo = str_replace('/index', '', $metodo);

		$id_usuario = $this->ci->session->userdata('id_usuario');
		$login = $this->login_in(true);									// Validar logeo
		$ans = $this->validar_acceso_metodo($id_usuario,$metodo,true);		// validar acceso 
	}

	/**
	 * Funcion para consultar en la base de datos los accesos a los metodos
	 * @param  [type]  $id_usuario  [description]
	 * @param  [type]  $metodo      [description]
	 * @param  boolean $redireccion [description]
	 * @return [type]               [description]
	 */
	function validar_acceso_metodo($id_usuario,$metodo, $redireccion = false){
		$id_menu = $this->ci->Seguridad_M->obtener_id_item($metodo);
		$id_rol_usuario = $this->ci->Seguridad_M->obtener_rol_usuario($id_usuario);
		$consultar = $this->ci->Seguridad_M->verificar_acceso($id_rol_usuario,$id_menu);

		if( !$consultar && !$redireccion ){
			return false;
		}elseif( !$consultar && $redireccion ){
			redirect( base_url() );
		}elseif( $consultar ){
			return true;
		}
	}


//////////////////////////////////////////////////////////////
// Funciones para crear registros de bitacora en el sistema //
//////////////////////////////////////////////////////////////

	/**
	 * Funcion para formatear los datos recibidos al formato de la tabla de bitacora
	 * @param  [Array] $datos [description]
	 * @return [Array]        [description]
	 */
	function formatear_variable($datos){
		foreach ($this->row_bitacora as $key => $value) {
			if( array_key_exists($key, $datos) )
				$this->row_bitacora[$key] = $datos[$key];
		}
		return $this->row_bitacora;
	}

	/**
	 * Funcion para generar los registros de la tabla bitacora del sistema
	 * @param  [Array] $datos [description]
	 * @return [type]        [description]
	 */
	function registrar_bitacora($datos){
		if( in_array($datos['accion'], array('INICIO DE SESION','CIERRE DE SESION') ) ){	// Caso de que sea inicio o cierre de sesion
			$estatus = false;
			$id_usuario = array_pop($datos);											
			$this->row_bitacora = $this->formatear_variable( $datos);					// Formatear datos
			if( $datos['accion'] == "INICIO DE SESION"){$estatus = true;}
			$this->ci->Seguridad_M->registrar_bitacora_sesion($this->row_bitacora,$id_usuario,$estatus);		// Generar registro
		}else{																	// los demas casos
			$this->row_bitacora = $this->formatear_variable( $datos);					// Formatear datos
			var_export($this->row_bitacora);
		}
	}

}