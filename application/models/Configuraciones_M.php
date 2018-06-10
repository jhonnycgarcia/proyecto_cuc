<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuraciones_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Funcion para obtener todos lsos registros de la tabla configuraciones
	 * @param  [type] $opcion [description]
	 * @return [type]         [description]
	 */
	function consultar_lista($opcion=null){

		$query = $this->db->select("a.id_configuracion, a.tema_template"
							.", a.tiempo_max_inactividad, a.tiempo_max_alerta"
							.", a.tiempo_max_espera, a.estatus, a.camara"
							.", a.hora_inicio, a.hora_fin"
							.", (a.hora_fin - a.hora_inicio)::INTERVAL AS duracion_jornada");

		if(is_null($opcion)){$query=$this->db->order_by('a.id_configuracion','ASC')->get('seguridad.configuraciones AS a')->result_array();
		}elseif($opcion){$query=$this->db->order_by('a.id_configuracion','ASC')->get_where('seguridad.configuraciones AS a',array('a.estatus'=>'t'))->result_array();
		}else{$query=$this->db->order_by('a.id_configuracion','ASC')->get_where('seguridad.configuraciones AS a',array('a.estatus'=>'f'))->result_array();}
		return $query;
	}

	/**
	 * Funcion para consultar un registro de configuraciones y obtener sus detalles
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function consultar_configuracion($id=null)
	{
		$query = $this->db->select("a.id_configuracion, a.tema_template"
							.", a.tiempo_max_inactividad, a.tiempo_max_alerta"
							.", a.tiempo_max_espera, a.estatus, a.camara"
							.", a.hora_inicio, a.hora_fin"
							.", (a.hora_fin - a.hora_inicio)::INTERVAL AS duracion_jornada")
					->get_where("seguridad.configuraciones AS a"
						,array('a.id_configuracion'=>$id))
					->result_array();
		if(count($query)>0) return $query[0];
		return NULL;
	}

	/**
	 * Funcion para agregar un nuevo registro a la tabla configuraciones
	 * @param  [type] $datos [description]
	 * @return [type]        [description]
	 */
	function agregar_configuracion($datos){
		unset($datos['id_configuracion']);
		$query = $this->db->insert("seguridad.configuraciones",$datos);
		return $query;
	}

	/**
	 * Funcion para actualizar los valores de un registro de configuracions
	 * @param  [type] $datos [description]
	 * @return [type]        [description]
	 */
	function editar_configuracion($datos){
		$id_configuracion = array_pop($datos);
		$query = $this->db->where('id_configuracion',$id_configuracion)
						->update("seguridad.configuraciones",$datos);
		return $query;
	}

	/**
	 * Funcion para activar un registro de configuraciones
	 * @param  [type] $id_configuracion [description]
	 * @return [type]                   [description]
	 */
	function activar_configuracion($id_configuracion){
		$sql = $this->db->update("seguridad.configuraciones",array('estatus'=>'f'));
		if($sql){
			$sql = $this->db->where("id_configuracion",$id_configuracion)
							->update("seguridad.configuraciones",array('estatus'=>'t'));
			if($sql) {return TRUE;}
			else{ return FALSE;}
		}
		return FALSE;
	}

	/**
	 * Funcion para eliminar un registro de configuraciones
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function eliminar_configuracion($id){
		$query = $this->db->where('id_configuracion',$id)
						->delete("seguridad.configuraciones");
		return $query;
	}

}