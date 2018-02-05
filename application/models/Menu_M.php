<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function obtener_todos(){
		$query = $this->db->query("SELECT * FROM seguridad.lista_menu();")->result_array();
		return $query;
	}

	function agregar_item( $datos ){
		$ans = false;
		unset($datos['id']);
		$id_rol_menu = array_pop($datos);
		$status = $this->db->insert('seguridad.menus',$datos);
		if( $status ){
			$ans = true;
			$id = $this->db->insert_id();
			foreach ($id_rol_menu as $key => $value) {
				$data_id_rol_menu[] = array( 'rol_id' => $value, 'menu_id' => $id );
			}
			$this->db->insert_batch('seguridad.roles_menu',$data_id_rol_menu);
		}
		return $ans;
	}

}