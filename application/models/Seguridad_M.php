<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seguridad_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function verificar_acceso($id_rol_usuario,$id_menu){
		$ans = false;
		$query = $this->db->get_where('seguridad.roles_menu AS a', array('rol_id' => $id_rol_usuario, 'a.menu_id' => $id_menu ) )->result_array();
		if( count($query) > 0 )
			$ans = true;
		return $ans;
	}

	function obtener_id_item($metodo){
		$query = $this->db->select('a.id')
							->from('seguridad.menus AS a')
							->where('a.estatus','t')
								->like('a.link',$metodo,'both')
							->get()->result_array();
		return $query[0]['id'];
	}

	function obtener_rol_usuario($id_usuario){
		$query = $this->db->select('a.id')
							->from('seguridad.usuarios AS a')
							->where('a.id',$id_usuario )
							->get()->result_array();
		return $query[0]['id'];
	}

	function registro_bitacora_sesion($datos){
		if( strtolower($datos['accion']) == 'salir' ){
			$this->estatus_logeo($datos['usuario_id']);
		}else{
			$this->estatus_logeo($datos['usuario_id'], true );
		}

		$this->db->insert('seguridad.bitacora_session',$datos);
	}

	function estatus_logeo($usuario_id,$estatus = false ){
		$query = $this->db->set('logeado',$estatus)
						->where('id',$usuario_id)
						->update('seguridad.usuarios');
	}

}