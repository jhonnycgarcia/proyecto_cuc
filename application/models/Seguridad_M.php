<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seguridad_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function verificar_estatus_activo($usuario_id){
		$query = $this->db->get_where("seguridad.usuarios AS a"
							,array("a.estatus"=>TRUE,"a.sesion_activa"=>TRUE,"a.id_usuario"=>$usuario_id)
						)
						->result_array();
		if( count($query)>0) return TRUE;
		return FALSE;
	}

	function verificar_acceso($id_rol_usuario,$id_menu){
		if( is_null($id_rol_usuario) || is_null($id_menu) ) return FALSE;
		$query = $this->db->get_where('seguridad.roles_menus AS a', 
			array('a.rol_id' => $id_rol_usuario, 'a.menu_id' => $id_menu ) 
			)->result_array();
		if(count($query)>0) return TRUE;
		return FALSE;
	}

	function obtener_id_item($metodo){
		$query = $this->db->select('a.id_menu')
							->from('seguridad.menus AS a')
							->where('a.estatus','t')
								->like('a.link',$metodo,'both')
							->limit(1)
							->get()->result_array();
		if(count($query)>0) return $query[0]['id_menu'];
		return NULL;
	}

	function obtener_rol_usuario($id_usuario){
		$query = $this->db->select('a.rol_id')
							->from('seguridad.usuarios AS a')
							->where('a.id_usuario',$id_usuario )
							->get()->result_array();
		if(count($query)>0) return $query[0]['rol_id'];
		return FALSE;
	}

	/**
	 * Funcion para generar bitacora de peticiones
	 * @param  array $datos [description]
	 */
	function registrar_bitacora($datos){
		$this->db->insert('seguridad.bitacora',$datos);
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