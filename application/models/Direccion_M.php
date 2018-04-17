<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Direccion_M extends CI_Model {

	public $ans = null;
	public $estatus = false;

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function obtener_todos( $opcion = null ){
		if( is_null($opcion) ){ $query = $this->db->order_by('id_direccion','ASC')->get('administrativo.direcciones')->result_array();
		}elseif( $opcion ){ $query = $this->db->order_by('id_direccion','ASC')->get_where('administrativo.direcciones',array('estatus' => 't'))->result_array();
		}else{ $query = $this->db->order_by('id_direccion','ASC')->get_where('administrativo.direcciones',array('estatus' => 'f'))->result_array(); }
		return $query;
	}

	function consultar_direccion($id = null ){
		if( !is_null($id) ){
			$query = $this->db->get_where('administrativo.direcciones',array('id_direccion' => $id))->result_array();
			if( count($query) > 0 ) $this->ans = $query[0];
		} return $this->ans;
	}

	function agregar_direccion($datos){
		unset($datos['id_direccion']);
		$this->estatus = $this->db->insert('administrativo.direcciones',$datos);
		return $this->estatus;
	}

	function editar_direccion($datos){
		$id = array_pop($datos);
		$this->estatus = $this->db->where('id_direccion',$id)->update('administrativo.direcciones',$datos);
		return $id;
	}

	function consular_dependencias($id){
		$query = $this->db->get_where('administrativo.coordinaciones',array('direccion_id' => $id) )->result_array();
		if( count($query) > 0 ) $this->estatus = true;
		return $this->estatus;
	}

	function eliminar_direccion($id){
		$dependencia = $this->consular_dependencias($id);
		if( $dependencia ) return $this->ans;
		$query = $this->db->where('id_direccion',$id)->delete('administrativo.direcciones');
		if( $query != false) $this->estatus = true;
		return $this->estatus;
	}
	
}