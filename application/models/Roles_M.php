<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function obtener_todos($opcion = null ){
		if( is_null($opcion) ){ $query = $this->db->order_by('id_rol','ASC')->get('seguridad.roles')->result_array();
		}elseif ( $opcion) {	$query = $this->db->order_by('id_rol','ASC')->get_where('seguridad.roles',array('estatus'=>'t'))->result_array();
		}else{ $query = $this->db->order_by('id_rol','ASC')->get_where('seguridad.roles',array('estatus'=>'f'))->result_array();}
		// $query = $this->db->query("SELECT * FROM seguridad.lista_roles(".$opcion.");")->result_array();
		return $query;
	}

	function agregar_item($datos){
		unset($datos['id']);
		if( empty($datos['descripcion']) )
			unset($datos['descripcion']);
		
		$status = $this->db->insert('seguridad.roles',$datos);
		return $status;
	}

	function consultar_item($id = 0 ){
		if( $id != 0 ){
			$query = $this->db->get_where('seguridad.roles',array('id_rol' => $id))->result_array();
			if( count($query) >  0 )
				return $query[0];
		}
		// $query = $this->db->query("SELECT * FROM seguridad.consultar_item_roles({$id});")->result_array();
		// if( count($query) > 0 )
		// 	return $query[0];
		return null;
	}

	function actualizar_item($datos){
		$id = array_pop($datos);
		if( empty($datos['descripcion']) )
			unset($datos['descripcion']);
		$status = $this->db->where('a.id',$id)
							->update('seguridad.roles AS a',$datos);
		return $status;
	}

	function consultar_dependencias($id){
		$query = $this->db->get_where("seguridad.usuarios AS a",array("a.rol_id" => $id) )->result_array();
		$query2 = $this->db->get_where("seguridad.roles_menu AS a",array('a.rol_id' => $id) )->result_array();
		if( (count($query) > 0) || (count($query2) > 0) )
			return true;
		return false;
	}

	function eliminar_item($id){
		$dependencia = $this->consultar_dependencias($id);
		if( $dependencia ){
			return null;
		}else{
			$status = $this->db->where('id',$id)->delete('seguridad.roles');
			if( $status != false )
				return true;
			return $status;
		}
	}
}