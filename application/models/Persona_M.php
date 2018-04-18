<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona_M extends CI_Model {

	public $ans = null;
	public $estatus = false;

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function consultar_lista($opcion=null)
	{
		$query = $this->db->select("a.id_dato_personal, a.cedula, "
							."CONCAT(a.p_apellido,' ',a.s_apellido) AS apellidos, CONCAT(a.p_nombre,' ',a.s_nombre) AS nombres,"
							."a.fecha_nacimiento,a.email,a.sexo,a.estatus")
						->from("administrativo.datos_personales AS a")
						->order_by('a.cedula','ASC')->get()->result_array();
		return $query;
	}

	function consultar_persona($id=null)
	{
		if(!is_null($id)){
			$query=$this->db->select("a.id_dato_personal, a.cedula,"
							."a.p_apellido, a.s_apellido, a.p_nombre,a.s_nombre,"
							."a.fecha_nacimiento, a.email, a.direccion, a.telefono_1, a.telefono_2, a.sexo, a.imagen, a.estatus,"
							."b.estado_civil, c.tipo_sangre")
							->from("administrativo.datos_personales AS a")
								->join("estatico.estado_civil AS b","a.estado_civil_id = b.id_estado_civil")
								->join("estatico.tipos_sangre AS c","a.tipo_sangre_id = c.id_tipo_sangre")
							->where(array('id_dato_personal'=>$id))
							->get()->result_array();
			if(count($query)>0) $this->ans = $query[0];
		} 
		return $this->ans;
	}

	/**
	 * Funcion para consultar si la cedula existe en el sistema
	 * @return [type] [description]
	 */
	function check_cedula($cedula){
		$query=$this->db->get_where('administrativo.datos_personales',array('cedula' => $cedula))->result_array();
		if(count($query)>0) return FALSE;
		return TRUE;
	}

	/**
	 * Funcion para eliminar los campos vacios del arreglo
	 * @param  [ARRAY] 	$datos 			[description]
	 * @return [ARRAY]	$datos        	[description]
	 */
	function limpiar_datos($datos){
		foreach ($datos as $key => $value) {
			if(empty($value)) unset($datos[$key]);
			if( in_array($key, array('p_apellido','s_apellido','p_nombre','s_nombre','direccion'))) $datos[$key] = strtoupper($value);
		}
		return $datos;
	}

	function lista_tipos_sangre(){
		$query = $this->db->order_by('tipo_sangre','ASC')->get('estatico.tipos_sangre')->result_array();
		return $query;
	}

	function lista_estado_civil(){
		$query = $this->db->order_by('estado_civil','ASC')->get('estatico.estado_civil')->result_array();
		return $query;
	}

	function agregar_persona($datos){
		unset($datos['id_dato_personal']);
		$datos = $this->limpiar_datos($datos);
		$this->estatus = $this->db->insert("administrativo.datos_personales",$datos);
		return $this->estatus;
	}

}