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
		// var_export($metodo);echo "<br><br>";
		// var_export($query);echo "<br><br>";
		// exit();
		return $query[0]['id'];
	}

	function obtener_rol_usuario($id_usuario){
		$query = $this->db->select('a.id')
							->from('seguridad.usuarios AS a')
							->where('a.id',$id_usuario )
							->get()->result_array();
		return $query[0]['id'];
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