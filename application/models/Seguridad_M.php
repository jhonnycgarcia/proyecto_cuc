<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seguridad_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function verificar_acceso($id_rol_usuario,$id_menu){
		$ans = false;
		$query = $this->db->get_where('seguridad.roles_menus AS a', 
			array('a.rol_id' => $id_rol_usuario, 'a.menu_id' => $id_menu ) 
			)->result_array();
		if( count($query) > 0 )
			$ans = true;
		return $ans;
	}

	function obtener_id_item($metodo){
		$query = $this->db->select('a.id_menu')
							->from('seguridad.menus AS a')
							->where('a.estatus','t')
								->like('a.link',$metodo,'both')
							->get()->result_array();
		return $query[0]['id_menu'];
	}

	function obtener_rol_usuario($id_usuario){
		$query = $this->db->select('a.id_usuario')
							->from('seguridad.usuarios AS a')
							->where('a.id_usuario',$id_usuario )
							->get()->result_array();
		return $query[0]['id_usuario'];
	}


	/**
	 * Funcion para generar bitacora de registro de inicio o cierre de sesion
	 * @param  array  $datos          [description]
	 * @param  integer  $id_usuario     [description]
	 * @param  boolean $estatus_sesion [description]
	 */
	function registrar_bitacora_sesion($datos,$id_usuario,$estatus_sesion = false){
		$this->db->insert('seguridad.bitacora',$datos);
		$this->estatus_logeo($id_usuario,$estatus_sesion);
	}

	/**
	 * Funcion para cambiar el estatatus del usuario dentro del sistema a "Autenticado" y "No autenticado"
	 * @param  integer  	$usuario_id [description]
	 * @param  boolean 		$estatus    [description]
	 */
	function estatus_logeo($usuario_id,$estatus = false ){
		$query = $this->db->set('sesion_activa',$estatus)
						->where('id_usuario',$usuario_id)
						->update('seguridad.usuarios');
	}

}