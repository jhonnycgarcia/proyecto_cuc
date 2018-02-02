<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seguridad_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function test(){
		$query = $this->db->get('seguridad.roles')->result_array();
		return $query;
	}

	function get_id_sistema_menu($metodo){
		$query = $this->db->select("a.sistema_id,a.id AS id_menu") /*sistema_id y id_menu*/
				->from("seguridad.menu AS a")
				->where( array("a.estatus" => '1') )
					->like('a.link',$metodo,'both')
				->get()->result_array();
		if( count($query) > 0 )
			$query = $query[0];
		return $query;
	}

	function get_acceso_usuario($datos)	{
		$ans = false;
		$query = $this->db->select() /* Buscar registro */
					->from('seguridad.roles_usuario_sistema AS a')
						->join("seguridad.roles_menu AS b","a.roles_id = b.roles_id")
					->where( array("a.sistema_id" => $datos['sistema_id'], "a.usuarios_id" => $datos['id_usuario'], "b.menu_id" => $datos['id_menu'] ) ) 
					->get()->result_array();
		if( count($query) > 0 )
			$ans = true;
		return $ans;
	}

}