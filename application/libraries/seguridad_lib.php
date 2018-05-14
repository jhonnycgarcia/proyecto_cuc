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

	/*
		$option 		=	OPENSSL_RAW_DATA		Retorna la cadena como un array
						0							Retorna la cadena como codigo Base64


		$output 		=	false 					En caso de producirse un error o no recibir parametro
							TEXTO 					Cadena encriptada
	 */
	public  $cadena 				= null;				// Datos a encriptar
	public  $encrypt_method 		= 'AES-256-CBC';	// Metodo de encriptado
	// public  $key 					= SEMILLA;		// Llave para encriptar
	// public  $key 					= 'oW%c76+jb2';		// Llave para encriptar
	// public  $iv						= null;		// Un Vector de Inicialización no NULL
	// public  $iv						= 'A)2!u467a^';		// Un Vector de Inicialización no NULL
	// public  $action					= null;				// Accion a ejecutar
	public  $output 				= false;			// Respuesta predeterminada
	public  $options				= 0;				// Tipo de retorno de datos
	public  $secret_key				= null;
	public  $secret_iv				= null;

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
		if ( array_key_exists('id_usuario', $data) ){		// Hay un usuario activo
			$consultar = $this->ci->Seguridad_M->verificar_estatus_activo($data['id_usuario']);
			if( $consultar ) $ans = true;
			if( !$consultar ){ 
				redirect( base_url('salir') );
			}
		} 			
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

	////////////////////////////////////////////////////////////////////
	// Funciones para encriptar y desencriptar los parametros por ULR //
	////////////////////////////////////////////////////////////////////

	/**
	 * Funcion para gestionar el proceso de encriptacion y desencriptacion de datos
	 * @param  [type] $cadena     [description]
	 * @param  [type] $accion     [description]
	 * @param  [type] $controller [description]
	 * @return [type]             [description]
	 */
	function execute_encryp($cadena=NULL,$accion=NULL,$controller=NULL){
		if( is_null($cadena) || ($cadena === FALSE) 
			|| is_null($accion) || is_null($controller) ) return NULL;


	   	// Encriptar la llave
	   	$this->secret_key = hash('sha256',SEMILLA);				
	    // Encriptar el vector inicial
	    $this->secret_iv = substr(hash('sha256',$this->ci->session->userdata('usuario').$controller),0,16);		

	    if(strtolower($accion) == 'encrypt'){
	    	return $this->encrypt($cadena);
	    }elseif (strtolower($accion) == 'decrypt' ) {
	    	$ans =  $this->decrypt($cadena);
	    	if(is_null($ans)){
				echo '<script language="javascript">
					alert("No se encontro el registro deseado, favor intente nuevamente");
					window.location="'.base_url($controller).'";
				</script>'; 
				}
			return $ans;
	    }else{ return NULL; }
	}

	/**
	 * Funcion para encriptar los datos y crear una cadena
	 * @param  [type] $cadena [description]
	 * @return [type]         [description]
	 */
	function encrypt($cadena){
		$cadena = trim(strval($cadena));
		$out = openssl_encrypt(
			$cadena
			,$this->encrypt_method
			,$this->secret_key
			,$this->options
			,$this->secret_iv
		);
		$out = base64_encode($out);
		return $out;
	}

	/**
	 * Funcion para descencriptar los datos
	 * @param  [type] $cadena [description]
	 * @return [type]         [description]
	 */
	function decrypt($cadena){

		$cadena = base64_decode($cadena);
		if( $cadena === FALSE) return NULL;			// error en desencriptar base64

		$cadena = preg_replace('([^A-Za-z0-9=+/])', '',$cadena);
		if( $cadena === FALSE) return NULL;			// error en sustituir caracteres especiales
		
		if( strlen($cadena)<24) return NULL;		// error en la cantidad de caracteres a procesar
		// var_export($cadena);exit();

		$cadena = trim(strval($cadena));
		$out = openssl_decrypt(
			$cadena
			,$this->encrypt_method
			,$this->secret_key
			,$this->options
			,$this->secret_iv
		);
		// var_export($out);exit();
		if($out === FALSE ) return NULL;
		return $out;
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