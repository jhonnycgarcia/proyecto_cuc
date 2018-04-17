<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Condicion_Laboral_M extends CI_Model {

	public $ans = null;
	public $estatus = false;

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
		$this->estatus = $this->db->insert('administrativo.condiciones_laborales',$datos);
		return $this->estatus;
	}

	function consultar_condicion_laboral($id=null){
		if( !is_null($id)){
			$query=$this->db->get_where('administrativo.condiciones_laborales',array('id_condicion_laboral'=>$id))->result_array();
			if( count($query)>0) $this->ans=$query[0];
		}
		return $this->ans;
	}

	function editar_condicion_laboral($datos){
		$id=array_pop($datos);
		$this->estatus=$this->db->where('id_condicion_laboral',$id)->update('administrativo.condiciones_laborales',$datos);
		return $this->estatus;
	}

	function consultar_dependencias($id){
		$query = $this->db->get_where('administrativo.trabajadores',array('condicion_laboral_id' => $id) )->result_array();
		if( count($query) > 0 ) $this->estatus = true;
		return $this->estatus;
	}

	function eliminar_condicion_laboral($id){
		$dependencia=$this->consultar_dependencias($id);
		if($dependencia) return $this->ans;
		$query=$this->db->where('id_condicion_laboral',$id)->delete('administrativo.condiciones_laborales');
		if($query!=false) $this->estatus=true;
		return $this->estatus;
	}
}