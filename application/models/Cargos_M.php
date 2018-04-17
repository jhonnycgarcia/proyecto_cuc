<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos_M extends CI_Model {

	public $ans = null;
	public $estatus = false;

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function consultar_lista($opcion=null){
		if(is_null($opcion)){$query=$this->db->order_by('cargo','ASC')->get('administrativo.cargos')->result_array();
		}elseif($opcion){$query=$this->db->order_by('cargo','ASC')->get_where('administrativo.cargos',array('estatus'=>'t'))->result_array();
		}else{$query=$this->db->order_by('cargo','ASC')->get_where('administrativo.cargos',array('estatus'=>'f'))->result_array();}
		return $query;
	}

	function agregar_cargo($datos){
		unset($datos['id_cargo']);
		$this->estatus = $this->db->insert('administrativo.cargos',$datos);
		return $this->estatus;
	}

	function consultar_cargo($id=null){
		if( !is_null($id)){
			$query=$this->db->get_where('administrativo.cargos',array('id_cargo'=>$id))->result_array();
			if( count($query)>0) $this->ans=$query[0];
		}
		return $this->ans;
	}

	function editar_cargo($datos){
		$id=array_pop($datos);
		$this->estatus=$this->db->where('id_cargo',$id)->update('administrativo.cargos',$datos);
		return $this->estatus;
	}

	function consultar_dependencias($id){
		$query = $this->db->get_where('administrativo.trabajadores',array('cargo_id' => $id) )->result_array();
		if( count($query) > 0 ) $this->estatus = true;
		return $this->estatus;
	}

	function eliminar_cargo($id){
		$dependencia=$this->consultar_dependencias($id);
		if($dependencia) return $this->ans;
		$query=$this->db->where('id_cargo',$id)->delete('administrativo.cargos');
		if($query!=false) $this->estatus=true;
		return $this->estatus;
	}
}