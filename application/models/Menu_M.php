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
			$this->agregar_rol_menu($data_id_rol_menu);
		}
		return $ans;
	}

	function agregar_rol_menu($datos){
		$query = $this->db->insert_batch('seguridad.roles_menu',$datos);
	}

	function consultar_item($id){
		$query = $this->db->query("SELECT * FROM seguridad.consultar_item_menu({$id});")->result_array();
		if( count($query) > 0 ){
			$query = $query[0];
			$rol_menu = $this->obtener_rol_menu($id);
			$query += array( 'rol_menu' => $rol_menu );
			return $query;
		}else{
			return null;
		}
	}

	function obtener_rol_menu($id){
		$ans = array();
		$query = $this->db->select()
						->from('seguridad.roles_menu AS a')
						->where( array('a.menu_id' => $id ) )
						->get()->result_array();
		if( count($query) > 0 ){
			foreach ($query as $key => $value) {
				$ans[] = $value['rol_id'];
			}
		}
		return $ans;
	}

	function actualizar_item($datos){
		$ans = false;
		$id = array_pop($datos);
		$id_roles = array_pop($datos);

		$status = $this->db->where("a.id",$id)
							->update("seguridad.menus AS a",$datos);
		if( $status ){
			$ans = true;
			foreach ($id_roles as $key => $value) {
				$data_id_rol_menu[] = array( 'rol_id' => $value, 'menu_id' => $id );
			}
			$this->eliminar_rol_menu($id);
			$this->agregar_rol_menu($data_id_rol_menu);
		}
		return $ans;
	}

	function eliminar_rol_menu($id){
		$query = $this->db->where( array("a.menu_id" => $id) )
							->delete("seguridad.roles_menu AS a");
	}

	function consultar_items_dependientes($id){
		$ans = false;
		$query = $this->db->get_where("seguridad.menus AS a", array("a.relacion" => $id) )->result_array();
		if( count($query) > 0 )
			$ans = true;
		return $ans;
	}

	function eliminar_item($id,$relacion){
		$ans = false;
		if( $relacion == 0 ){
			$consultar = $this->consultar_items_dependientes($id);
			if( $consultar )
				return $ans = null;
		}
		
		$this->eliminar_rol_menu($id);
		$status = $this->db->where("a.id",$id)->delete("seguridad.menus AS a");
		if( $status != false )
			$ans = true;
		return $ans;
	}

}