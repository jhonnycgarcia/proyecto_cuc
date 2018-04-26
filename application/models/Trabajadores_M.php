<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trabajadores_M extends CI_Model {

	public $ans = null;
	public $estatus = false;

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Funcion para obtener el listado de trabajadores
	 * @param  [BOOLEAN-NULL] 		$opcion   	[valor para establecer clausula del where]
	 *                                     		't' 	= para obtener solos los registros que se encuentren activos
	 *                                     		'f' 	= para obtener solo los registros que se encuentren en false
	 *                                     		null 	=  para obtener todos los registros, sin clausula.
	 *                                     		
	 * @param  [ARRAY] 				$order_by 	[clausulas para establecer el orden de los registros]
	 *                                			esta variable solo acepta dos posiciones ['campo'] y ['orden']
	 *                                			'campo'	= el campo mendiante el cual se organizaran los registros
	 *                                			'orden'	= el orden que se utilizara ya sea 'ASC' o 'DESC'
	 *                                			
	 * @return [ARRAY]           				[se retornan el resultado de la consulta]
	 */
	function consultar_lista($opcion=null,$order_by=null){
		$query = $this->db->select("a.id_trabajador ,a.dato_personal_id, b.cedula"
							.", CONCAT(b.p_apellido,' ',b.p_nombre) AS apellido_nombre"
							.", a.condicion_laboral_id, c.condicion_laboral"
							.", a.coordinacion_id, d.coordinacion"
							.", a.cargo_id, e.cargo"
							.", to_char(a.fecha_ingreso,'DD/MM/YYYY') AS fecha_ingreso"
							.", to_char(a.fecha_egreso,'DD/MM/YYYY') AS fecha_egreso"
							.", a.estatus, a.asistencia_obligatoria")
						->from("administrativo.trabajadores AS a")
							->join("administrativo.datos_personales AS b","a.dato_personal_id = b.id_dato_personal")
							->join("administrativo.condiciones_laborales AS c","a.condicion_laboral_id = c.id_condicion_laboral")
							->join("administrativo.coordinaciones AS d","a.coordinacion_id = d.id_coordinacion")
							->join("administrativo.cargos AS e","a.cargo_id = e.id_cargo");
		if($opcion){ $query = $this->db->where("a.estatus",'t');
		}elseif ($opcion === false) { $query = $this->db->where("a.estatus",'f');}
		if(!is_null($order_by)){ $query = $this->db->order_by($order_by['campo'],$order_by['orden']);}
		$query = $this->db->get()->result_array();
		return $query;
	}

	/**
	 * Funcion para obtener los datos de un registro de PERSONAS en especifico.
	 * @param  [INTEGER] 			$id_dato_personal 		[ID del registro a consultar]
	 * 
	 * @return [ARRAY]                   					[se retornan el resultado de la consulta]
	 */
	function consultar_personal($id_dato_personal){
		$query = $this->db->select("a.id_dato_personal, a.cedula"
							.", CONCAT(a.p_apellido,' ',a.s_apellido,' ',a.p_nombre,' ',a.s_nombre) AS apellidos_nombres")
						->from("administrativo.datos_personales AS a")
						->where( array('a.estatus' => 'f',"a.id_dato_personal"=>$id_dato_personal) )
						->get()->result_array();
		if(count($query)>0) return $query[0];
		return NULL;
	}

	/**
	 * Funcion para obtener los datos de un registro de TRABAJADORES en especifico
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function consultar_trabajador($id){
		$query = $this->db->select("a.id_trabajador "
							.", a.dato_personal_id, b.cedula"
							.", CONCAT(b.p_apellido,' ',b.s_apellido,' ',b.p_nombre,' ',b.s_nombre) AS apellidos_nombres"
							.", a.coordinacion_id, e.coordinacion, e.direccion_id, f.direccion "
							.", a.condicion_laboral_id, d.condicion_laboral, a.cargo_id, c.cargo"
							.", to_char(a.fecha_ingreso,'DD/MM/YYYY') AS fecha_ingreso"
							.", to_char(a.fecha_egreso,'DD/MM/YYYY') AS fecha_egreso"
							.", a.asistencia_obligatoria")
						->from("administrativo.trabajadores AS a")
							->join("administrativo.datos_personales AS b","a.dato_personal_id = b.id_dato_personal")
							->join("administrativo.cargos AS c","a.cargo_id = c.id_cargo")
							->join("administrativo.condiciones_laborales AS d","a.condicion_laboral_id = d.id_condicion_laboral")
							->join("administrativo.coordinaciones AS e","a.coordinacion_id = e.id_coordinacion")
							->join("administrativo.direcciones AS f","e.direccion_id = f.id_direccion")
						->where( array('a.id_trabajador' => $id) )
						->get()->result_array();
		if( count($query)>0 ) return $query[0];
		return NULL;
	}

	/**
	 * Funcion para obtener todas las coordinaciones ACTIVAS
	 * @return [type] [description]
	 */
	function obtener_coordinaciones(){
		$query = $this->db->order_by('coordinacion','ASC')
							->get_where('administrativo.coordinaciones',array('estatus'=>'t'))->result_array();
		return $query;
	}

	/**
	 * Funcion para obtener todas las condiciones laborales
	 * @return [type] [description]
	 */
	function obtener_condiciones_laborales(){
		$query = $this->db->order_by('condicion_laboral','ASC')
							->get('administrativo.condiciones_laborales')->result_array();
		return $query;
	}

	/**
	 * Funcion para obtener todos los cargos ACTIVOS
	 * @return [type] [description]
	 */
	function obtener_cargos(){
		$query = $this->db->order_by('cargo','ASC')
							->get_where('administrativo.cargos',array('estatus'=>'t'))->result_array();
		return $query;
	}

	/**
	 * Funcion de CALLBACK para verificar que la persona a registrar no se encuentre activa como trabajador
	 * @param  [type] $id_dato_personal [description]
	 * @return [type]                   [description]
	 */
	function check_persona_na($id_dato_personal){
		$query = $this->db->get_where('administrativo.trabajadores'
			,array('estatus'=>'t','dato_personal_id'=>$id_dato_personal))
						->result_array();
		if(count($query)>0) return FALSE;
		return TRUE;
	}

	/**
	 * Funcion para actualizar el estatus de la persona luego de ingresarlo o egresarlo como trabajador
	 * @param  [type] $id_dato_personal [description]
	 * @return [type]                   [description]
	 */
	function estatus_persona($id_dato_personal,$opcion = false){
		$query = $this->db->where('id_dato_personal',$id_dato_personal)
						->update("administrativo.datos_personales",array('estatus'=>$opcion));
	}

	/**
	 * Funcion para activar-desactivar el usuario asignado a un trabajador
	 * @param  [type]  $id_trabajador [description]
	 * @param  boolean $opcion        [description]
	 * @return [type]                 [description]
	 */
	function estatus_usuario($id_trabajador,$opcion=false){
		$sql = $this->db->get_where('seguridad.usuarios',array('trabajador_id'=>$id_trabajador,'estatus'=>'t'))->result_array();
		if(count($sql)>0){
			$sql = $this->db->where('trabajador_id',$id_trabajador)
				->update("seguridad.usuarios",array('estatus'=>$opcion));
		}
	}

	/**
	 * Funcion para ingresar una persona como trabajador
	 * @param  [type] $datos [description]
	 * @return [type]        [description]
	 */
	function registrar_trabajador($datos){
		unset($datos['id_trabajador']);
		$sql = $this->db->insert('administrativo.trabajadores',$datos);
		return $sql;
	}

	/**
	 * Funcion para egresar trabajadores
	 * @param  [type] $datos [description]
	 * @return [type]        [description]
	 */
	function egresar_trabajador($datos){
		$formato = array('estatus'=>'f','fecha_egreso'=>$datos['fecha_egreso']);
		$id_trabajador = $datos['id_trabajador'];
		$sql = $this->db->where("id_trabajador",$id_trabajador)
						->update("administrativo.trabajadores",$formato);
		return $sql;
	}

	/**
	 * Funcion para editar el campo ASISTENCIA_OBLIGATORIA (AO) de un registro de TRABAJADORES
	 * @param  INTEGER  	$id_trabajador 		[description]
	 * 
	 * @param  boolean 		$opcion        		[description]
	 * 
	 * @return BOOLEAN 							true = en caso de exito
	 *                            				false = en caso de error
	 *                                 
	 */
	function editar_ao_trabajador($id_trabajador,$opcion = FALSE){
		$sql = $this->db->where('id_trabajador',$id_trabajador)
						->update('administrativo.trabajadores',array('asistencia_obligatoria'=>$opcion));
		return $sql;
	}
}