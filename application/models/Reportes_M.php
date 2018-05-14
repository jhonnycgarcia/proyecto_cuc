<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Funcion para obtener los cargos activos en el sistema y ser mostrados en el 
	 * formulario de consulta de repostes
	 * @return [type] [description]
	 */
	function obtener_cargos(){
		$query = $this->db->select("a.id_cargo, a.cargo")
						->from("administrativo.cargos AS a")
							->join("administrativo.trabajadores AS b","a.id_cargo = b.cargo_id")
						->where( array('a.estatus'=>'t','b.estatus'=>'t') )
						->order_by('a.cargo','ASC')
						->get()->result_array();
		return $query;
	}

	/**
	 * Funcion para obtener el rango de fechas del periodo seleccionado en el formulario
	 * @param  [type] $fdesde [description]
	 * @param  [type] $fhasta [description]
	 * @return [type]         [description]
	 */
	function obtener_rango_fechas($fdesde,$fhasta)
	{
		$query = $this->db->select("a.fecha")
						->from("asistencia.registros_asistencia AS a")
						->where(array('a.estatus'=>'t'
							,'a.fecha >='=>$fdesde
							,'a.fecha <=' => $fhasta))
						->group_by('a.fecha')
						->order_by('a.fecha','ASC')
						->get()->result_array();
		if(count($query)>0) return $query;
		return NULL;
	}

	/**
	 * Funcion para obtener el numero de registros de asistencia existentes entre el periodo
	 * seleccionado a traves del formulario
	 * @param  [type] $fdesde    [description]
	 * @param  [type] $fhasta    [description]
	 * @param  array  $excluidos [description]
	 * @return [type]            [description]
	 */
	function nro_registros_fechas($fdesde,$fhasta,$excluidos = array()){
		$query = $this->db->select("count(*) AS nro_registros")
						->from("asistencia.registros_asistencia AS a")
							->join("administrativo.trabajadores AS b","a.trabajador_id = b.id_trabajador")
						->where(array("a.estatus"=>true
							,"a.fecha >="=>$fdesde
							,"a.fecha <="=>$fhasta
							,"b.estatus"=>true));
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("b.cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		return $query[0]['nro_registros'];
	}

	/**
	 * Funcion para obtener los registros de asistencia de una fecha en especifica y por tipo 
	 * de registro
	 * @param  [type] $fecha         [description]
	 * @param  [type] $tipo_registro [description]
	 * @param  [type] $excluidos     [description]
	 * @return [type]                [description]
	 */
	function registros_asistencia_por_fecha($fecha,$tipo_registro,$excluidos)
	{
		$query = $this->db->select("a.trabajador_id, a.hora, c.cedula"
						.", CONCAT(c.p_apellido,' ',c.p_nombre) AS apellidos_nombres"
						.", b.cargo_id, d.cargo"
						.", b.coordinacion_id, e.coordinacion"
						.",to_char(a.fecha,'DD/MM/YYYY') AS fecha "
						.",  a.observaciones, a.tipo_registro")
						->from("asistencia.registros_asistencia AS a")
							->join("administrativo.trabajadores AS b","a.trabajador_id = b.id_trabajador")
							->join("administrativo.datos_personales AS c","b.dato_personal_id = c.id_dato_personal")
							->join("administrativo.cargos AS d","b.cargo_id = d.id_cargo")
							->join("administrativo.coordinaciones AS e","b.coordinacion_id = e.id_coordinacion")
						->where("a.fecha",$fecha)
						->where("a.estatus",'t')
						->where("b.estatus",'t')
						->where("a.tipo_registro",$tipo_registro)
						->order_by('a.hora','ASC');

		if( count($excluidos) > 0) $query = $this->db->where_not_in("b.cargo_id",$excluidos);

		$query = $this->db->get()->result_array();
		if( count($query) > 0 ) $query = $this->formateo_hora($query);
		return $query;
	}

	/**
	 * Funcion para formatear el tipo de hora de 24h a 12h para los reportes
	 * @param  [type] $datos [description]
	 * @return [type]        [description]
	 */
	function formateo_hora($datos){
		foreach ($datos as $key => $value) {
			$f_hora = "".date('h:i:s A',strtotime($value['hora']))."";
			$datos[$key]['hora'] = $f_hora;
		}
		return $datos;
	}

	/**
	 * Funcion para obtener todos los registros de asistencia en un periodo establecido
	 * y darles formatos para luego ser mostrados en el reporte de asistencia
	 * @param  [type] $fdesde    [description]
	 * @param  [type] $fhasta    [description]
	 * @param  array  $excluidos [description]
	 * @return [type]            [description]
	 */
	function registros_asistencia($fdesde,$fhasta,$excluidos = array() ){
		$fechas = $this->obtener_rango_fechas($fdesde,$fhasta);
		$nro_registros = $this->nro_registros_fechas($fdesde,$fhasta,$excluidos);

		if( is_null($fechas) OR $nro_registros == 0 ) return NULL;

		foreach ($fechas as $key => $value) {
			$fechas[$key] += array('entrada' => array(), 'salida' => array() );

			$entradas = $this->registros_asistencia_por_fecha($value['fecha'],'ENTRADA',$excluidos);
			$fechas[$key]['entrada'] = $entradas;
			$salida = $this->registros_asistencia_por_fecha($value['fecha'],'SALIDA',$excluidos);
			$fechas[$key]['salida'] = $salida;
		}
		
		return $fechas;
	}
}