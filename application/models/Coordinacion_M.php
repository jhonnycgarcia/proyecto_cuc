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

	/**
	 * Funcion para obtener listado de coordinaciones segun direccion
	 * @param  INTEGER $id_direccion [description]
	 * @param  BOOLEAN $estatus      [description]
	 * @return ARRAY / NULL              [description]
	 */
	function obtener_coordinaciones_por_direcciones($id_direccion = NULL, $estatus = NULL){
		$condicion = array();
		if(is_null($id_direccion)) return NULL;
		$condicion['direccion_id'] = $id_direccion;
		$condicion['estatus'] = (!is_null($estatus) && is_bool($estatus) )?$estatus:NULL;
		$query = $this->db->get_where('administrativo.coordinaciones',$condicion)
					->result_array();
		if(count($query)>0) return $query;
		return NULL;
	}

	function agregar_coordinacion($datos){
		unset($datos['id_coordinacion']);
		$query = $this->db->insert('administrativo.coordinaciones',$datos);
		return $query;
	}

	function consultar_coordinacion($id=null){
		if( !is_null($id)){
			$query = $this->db->select("a.id_coordinacion, a.coordinacion, a.descripcion,a.direccion_id, a.estatus")
								->from("administrativo.coordinaciones AS a")
								->where( array('a.id_coordinacion' => $id) )
								->get()->result_array();
			if( count($query)>0) return $query[0];
		} return NULL;
	}

	function editar_coordinacion($datos){
		$id=array_pop($datos);
		$sql=$this->db->where('id_coordinacion',$id)->update('administrativo.coordinaciones',$datos);
		return $sql;
	}

	function consultar_dependencias($id){
		$query = $this->db->get_where('administrativo.trabajadores',array('coordinacion_id' => $id) )->result_array();
		if( count($query) > 0 ) return TRUE;
		return FALSE;
	}

	function eliminar_coordinacion($id){
		$dependencia=$this->consultar_dependencias($id);
		if($dependencia) return $this->ans;
		$query=$this->db->where('id_coordinacion',$id)->delete('administrativo.coordinaciones');
		if($query!=false) return TRUE;
		return $query;
	}

}