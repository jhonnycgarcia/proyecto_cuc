<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Condicion_Laboral_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function consultar_lista($opcion=null){
		if(is_null($opcion)){$query=$this->db->order_by('id_condicion_laboral','ASC')->get('administrativo.condiciones_laborales')->result_array();
		}elseif($opcion){$query=$this->db->order_by('id_condicion_laboral','ASC')->get_where('administrativo.condiciones_laborales',array('estatus'=>'t'))->result_array();
		}else{$query=$this->db->order_by('id_condicion_laboral','ASC')->get_where('administrativo.condiciones_laborales',array('estatus'=>'f'))->result_array();}
		return $query;
	}

	function agregar_condicion_laboral($datos){
		unset($datos['id_condicion_laboral']);
		$query = $this->db->insert('administrativo.condiciones_laborales',$datos);
		return $query;
	}

	function consultar_condicion_laboral($id=null){
		if( !is_null($id)){
			$query=$this->db->get_where('administrativo.condiciones_laborales',array('id_condicion_laboral'=>$id))->result_array();
			if( count($query)>0) return $query[0];
		}
		return NULL;
	}

	function editar_condicion_laboral($datos){
		$id=array_pop($datos);
		$query=$this->db->where('id_condicion_laboral',$id)->update('administrativo.condiciones_laborales',$datos);
		return $query;
	}

	function consultar_dependencias($id){
		$query = $this->db->get_where('administrativo.trabajadores',array('condicion_laboral_id' => $id) )->result_array();
		if( count($query) > 0 ) return TRUE;
		return FALSE;
	}

	function eliminar_condicion_laboral($id){
		$dependencia=$this->consultar_dependencias($id);
		if($dependencia) return NULL;
		$query=$this->db->where('id_condicion_laboral',$id)->delete('administrativo.condiciones_laborales');
		if($query!=false) return TRUE;
		return $query;
	}
}