<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinacion_M extends CI_Model {

	public $ans = null;
	public $estatus = false;

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function consultar_lista( $opcion = null ){
		$query = $this->db->select('a.id_coordinacion, a.coordinacion, b.direccion, a.descripcion, a.estatus')
						->from('administrativo.coordinaciones AS a')
							->join('administrativo.direcciones AS b','a.direccion_id = b.id_direccion');
		if( $opcion ){ $query = $this->db->where( array('a.estatus' => 't') ); 
		}elseif( $opcion === false ){ $query = $this->db->where( array('a.estatus' => 'f') ); }
		$query = $this->db->order_by('a.id_coordinacion','ASC')->get()->result_array();
		return $query;
	}

	function obtener_direcciones($opcion=null){
		if(is_null($opcion)){ $query = $this->db->order_by('direccion','ASC')->get('administrativo.direcciones')->result_array();
		}elseif($opcion === TRUE){$query=$this->db->order_by('direccion','ASC')->get_where('administrativo.direcciones',array('estatus'=>'t'))->result_array();
		}else{$query=$this->db->order_by('direccion','ASC')->get_where('administrativo.direcciones',array('estatus'=>'f'))->result_array();}
		return $query;
	}

	function agregar_coordinacion($datos){
		unset($datos['id_coordinacion']);
		$this->estatus = $this->db->insert('administrativo.coordinaciones',$datos);
		return $this->estatus;
	}

	function consultar_coordinacion($id=null){
		if( !is_null($id)){
			$query = $this->db->select("a.id_coordinacion, a.coordinacion, a.descripcion,a.direccion_id, a.estatus")
								->from("administrativo.coordinaciones AS a")
								->where( array('a.id_coordinacion' => $id) )
								->get()->result_array();
			if( count($query)>0) $this->ans = $query[0];
		} return $this->ans;
	}

	function editar_coordinacion($datos){
		$id=array_pop($datos);
		$this->estatus=$this->db->where('id_coordinacion',$id)->update('administrativo.coordinaciones',$datos);
		return $this->estatus;
	}

	function consultar_dependencias($id){
		$query = $this->db->get_where('administrativo.trabajadores',array('coordinacion_id' => $id) )->result_array();
		if( count($query) > 0 ) $this->estatus = true;
		return $this->estatus;
	}

	function eliminar_coordinacion($id){
		$dependencia=$this->consultar_dependencias($id);
		if($dependencia) return $this->ans;
		$query=$this->db->where('id_coordinacion',$id)->delete('administrativo.coordinaciones');
		if($query!=false) $this->estatus=true;
		return $this->estatus;
	}

}