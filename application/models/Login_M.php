<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}


	function consultar($datos){
		$ans = false;
		$a = $this->obtener_usuario($datos);
		$b = $this->obtener_admin($datos);

		if( $a ||$b )
			$ans = true;
		
		return $ans;
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
		$query = $this->db->select("a.id AS id_usuario, a.usuario, CONCAT(b.p_apellido,' ',b.p_nombre) AS apellidos_nombres, c.rol")
						->from("seguridad.usuarios AS a")
							->join("administrativo.trabajadores AS b", "a.trabajador_id = b.id")
							->join("seguridad.roles AS c", "a.rol_id = c.id")
						->where( array('a.clave' => $datos['clave'], 'a.usuario' => $datos['usuario']) )
						->get()->result_array();

		if( count($query) > 0 ){
			$ans = true;
			$this->session->set_userdata($query[0]);
		}

		return $ans;
	}

	/**
	 * Funcion para obtener los datos del administrador
	 * @param  [ARRAY] $datos [usuario] (VARCHAR)
	 *                        [clave]	(VARCHAR)
	 *                        
	 * @return [BOOLEAN]      [TRUE] 	= en caso de conseguir algun registro
	 *                        [FLASE]	= en caso de no conseguir ningun registro
	 */
	function obtener_admin($datos){
		$ans = false;
		$query = $this->db->select("a.id AS id_usuario, a.usuario, 'WebMaster'::VARCHAR AS apellidos_nombres, b.rol")
						->from('seguridad.usuarios AS a')
							->join("seguridad.roles AS b", "a.rol_id = b.id")
						->where( array('a.clave' => $datos['clave'], 'a.usuario' => $datos['usuario']) )
						->get()->result_array();

		if( count($query) > 0 ){
			$ans = true;
			$query = $query[0];
			$this->session->set_userdata($query);
			$this->seguridad_lib->bitacora_sesion( array( 'usuario_id' => $query['id_usuario'], 'accion' => 'INGRESAR' ) );
		}

		return $ans;
	}
}