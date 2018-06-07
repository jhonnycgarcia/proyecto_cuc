<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_M extends CI_Model {

	public $status = false;

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
		$query = $this->db->select("a.id_usuario,a.usuario, a.rol_id, b.rol, CONCAT(d.p_apellido,' ',d.p_nombre)::VARCHAR AS apellidos_nombres"
						.",c.cargo_id, e.cargo, c.coordinacion_id, f.coordinacion")
						->from("seguridad.usuarios AS a")
							->join("seguridad.roles AS b","a.rol_id = b.id_rol")
							->join("administrativo.trabajadores AS c","a.trabajador_id = c.id_trabajador")
							->join("administrativo.datos_personales AS d","d.id_dato_personal = c.dato_personal_id")
							->join("administrativo.cargos AS e","c.cargo_id = e.id_cargo")
							->join("administrativo.coordinaciones AS f","c.coordinacion_id = f.id_coordinacion")
						->where( array("a.usuario" => $datos['usuario']
								,"a.clave" => $datos['clave']
								,"a.estatus" => TRUE
								,"c.estatus" => TRUE
								,"d.estatus" => TRUE
								) 
							)
						->get()->result_array();
		if( count($query) > 0 ){
			$this->status = true;
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
		return $this->status;
	}

}