<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trabajadores_M extends CI_Model {

	public $ans = null;
	public $estatus = false;

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function consultar_lista($opcion=null){
		$query = $this->db->select("a.id_trabajador ,a.dato_personal_id, b.cedula"
							.", CONCAT(b.p_apellido,' ',b.p_nombre) AS apellido_nombre"
							.", a.condicion_laboral_id, c.condicion_laboral"
							.", a.coordinacion_id, d.coordinacion"
							.", a.cargo_id, e.cargo"
							.", to_char(a.fecha_ingreso,'DD/MM/YYYY') AS fecha_ingreso, to_char(a.fecha_egreso,'DD/MM/YYYY') AS fecha_egreso"
							.", a.estatus, a.asistencia_obligatoria")
						->from("administrativo.trabajadores AS a")
							->join("administrativo.datos_personales AS b","a.dato_personal_id = b.id_dato_personal")
							->join("administrativo.condiciones_laborales AS c","a.condicion_laboral_id = c.id_condicion_laboral")
							->join("administrativo.coordinaciones AS d","a.coordinacion_id = d.id_coordinacion")
							->join("administrativo.cargos AS e","a.cargo_id = e.id_cargo");
		if($opcion){ $query = $this->db->where("a.estatus",'t');
		}elseif ($opcion === false) { $query = $this->db->where("a.estatus",'f');}
		$query = $this->db->get()->result_array();
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