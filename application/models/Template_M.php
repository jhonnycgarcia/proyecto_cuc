<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Funcion para obtener la configuracion activa del sistema
	 * @return [type] [description]
	 */
	function get_config(){
		$sql = $this->db->get_where("seguridad.configuraciones",array('estatus'=>'t'))->result_array();
		return $sql[0];
	}

	/**
	 * Funcion para obtener el rol del usuario dentro del sistema
	 * @param  [type] $usuario_id [description]
	 * @return [type]             [description]
	 */
	function obtener_rol_usuario($usuario_id){
		$query = $this->db->select('a.rol_id')
						->from("seguridad.usuarios AS a")
						->where(array('a.estatus'=>'t','a.id_usuario'=>$usuario_id))
						->get()->result_array();
		if( count($query)>0 ) return $query[0]["rol_id"];
		return NULL;
	}

	/**
	 * Funcion para obtener todos los items del menu segun el rol del usuario
	 * @param  [type]  $usuario_id [description]
	 * @param  integer $padre      [description]
	 * @param  boolean $estatus    [description]
	 * @return [type]              [description]
	 */
	function obtener_items_menu($usuario_id = NULL,$padre = 0, $estatus = TRUE){
		$condicion = array();
		$condicion['a.estatus'] = $estatus;
		$condicion['a.relacion'] = $padre;
		$condicion['a.visible_menu'] = TRUE;
		$rol_usuario = $this->obtener_rol_usuario($usuario_id);
		if(is_null($rol_usuario)) return NULL;
		$condicion['b.rol_id'] = $rol_usuario;

		$query = $this->db->select("a.id_menu AS id, a.menu, a.link, a.icono"
						.", a.relacion, a.posicion")
					->from("seguridad.menus AS a")
						->join("seguridad.roles_menus AS b","a.id_menu = b.menu_id")
					->where($condicion)
					->order_by('a.posicion','ASC')
					->order_by('a.menu','ASC')
					->get()->result_array();
		if( count($query)>0 ) return $query;
		return NULL;
	}
}