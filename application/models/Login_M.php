<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Funcion para obtener los datos de un trabajador
	 * @param  [ARRAY] $datos [usuario] (VARCHAR)
	 *                        [clave]	(VARCHAR)
	 *                        
	 * @return [BOOLEAN]      [TRUE] 	= en caso de conseguir algun registro
	 *                        [FLASE]	= en caso de no conseguir ningun registro
	 */
	function obtener_usuario($datos){
		$ans = false;
		$query = $this->db->query("SELECT * FROM seguridad.obtener_usuario('{$datos['usuario']}','{$datos['clave']}'); ")->result_array();
		if( count($query) > 0 ){
			$ans = true;
			$this->session->set_userdata($query[0]);
			$this->seguridad_lib->registrar_bitacora( 								// Crear registro de Bitacora
				array(
						'fecha'				=> date('Y-m-d H:i:s'),
						'ip'				=> getenv('REMOTE_ADDR'),
						'accion'			=> 'INICIO DE SESION',
						'usuario'			=> $query[0]['usuario'],
						'descripcion'		=> 'El usuario "'.$query[0]['usuario'].'" procedió a iniciar sesión el '.date('Y-m-d')." a las ".date('H:i:s')." desde la IP ".getenv('REMOTE_ADDR'),
						'id_usuario' 		=> $query[0]['id_usuario']
					) 
				);
		}
		return $ans;
	}


	function obtener_usuario1($datos){
		$ans = false;
		$query = $this->db->select("a.id AS id_usuario, a.usuario, CONCAT(b.p_apellido,' ',b.p_nombre) AS apellidos_nombres, c.rol")
						->from("seguridad.usuarios AS a")
							->join("administrativo.trabajadores AS b", "a.trabajador_id = b.id")
							->join("seguridad.roles AS c", "a.rol_id = c.id")
						->where( array('a.clave' => $datos['clave'], 'a.usuario' => $datos['usuario'], 'a.logeado' => 'f')  )
						->get()->result_array();

		if( count($query) > 0 ){
			$ans = true;
			$this->session->set_userdata($query[0]);
		}

		return $ans;
	}

}