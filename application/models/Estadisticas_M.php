<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadisticas_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Funcion para obtener el numero total de trabajadores por direcciones
	 *
	 * Esta funcion permite filtrar si se desea obtener el listado general o solo el listado de 
	 * aquellos que deben registrar asistencia
	 *
 	 * @param  integer $direccion_id [description]
	 * @return array               [description]
	 */
	function nro_total_trabajadores_por_direccion($direccion_id = NULL, $ao = NULL){
		if(is_null($direccion_id)) return NULL;
		$condicion = array();
		$condicion['f.id_direccion'] = $direccion_id;
		$condicion['a.estatus'] = TRUE;
		if( !is_null($ao) ||is_bool($ao) ) $condicion['a.asistencia_obligatoria'] = $ao;
		$condicion['b.estatus'] = TRUE;
		$condicion['d.estatus'] = TRUE;
		$condicion['f.estatus'] = TRUE;

		$query = $this->db->select("COUNT(*) AS nro_registros")
						->from("administrativo.trabajadores AS a")
							->join("administrativo.datos_personales AS b","a.dato_personal_id = b.id_dato_personal")
							->join("administrativo.condiciones_laborales AS c","a.condicion_laboral_id = c.id_condicion_laboral")
							->join("administrativo.coordinaciones AS d","a.coordinacion_id = d.id_coordinacion")
							->join("administrativo.cargos AS e","a.cargo_id = e.id_cargo")
							->join("administrativo.direcciones AS f","d.direccion_id = f.id_direccion")
						->where($condicion)
						->get()->result_array();
		if(count($query)>0) return $query[0]['nro_registros'];
		return 0;
	}

	/**
	 * Funcion para obtener el numero de trabajadores presentes por direcciones
	 * @param  [type] $fecha        [description]
	 * @param  [type] $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return [type]               [description]
	 */
	function nro_registros_asistencia_por_fecha_direccion($fecha = NULL,$direccion_id = NULL,$excluidos = array())
	{	
		if(is_null($fecha) ||is_null($direccion_id)) return NULL;
		$condicion = array();
		$condicion['b.out_direccion_id'] = $direccion_id;

		$query = $this->db->select("COUNT(*) AS nro_registros")
						->from(" asistencia.consulta_registros_asistencia('{$fecha}') AS b")
						->where($condicion);

		if( count($excluidos) > 0) $query = $this->db->where_not_in("b.out_cargo_id",$excluidos);

		$query = $this->db->get()->result_array();
		if (count($query)>0) return $query[0]['nro_registros'];
		return 0;
	}

	/**
	 * Funcion para obtener el numero de inasistencias por mes y año de una direccion
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return [type]               [description]
	 */
	function nro_registros_asistencia_por_mes_ano_direccion($mes = NULL,$ano = NULL,$direccion_id = NULL,$excluidos = array())
	{	
		if(is_null($mes) || is_null($ano) || is_null($direccion_id)) return NULL;
		$condicion = array();
		$condicion['b.out_direccion_id'] = $direccion_id;

		$query = $this->db->select("COUNT(*) AS nro_registros")
						->from(" asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS b")
						->where($condicion);

		if( count($excluidos) > 0) $query = $this->db->where_not_in("b.out_cargo_id",$excluidos);

		$query = $this->db->get()->result_array();
		if (count($query)>0) return $query[0]['nro_registros'];
		return 0;
	}

	/**
	 * Funcion para obtener el numero de registros de inasistencias por direcciones
	 * @param  [type] $fecha        [description]
	 * @param  [type] $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return [type]               [description]
	 */
	function nro_registros_inasistencia_por_fecha_direccion($fecha = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($fecha) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("COUNT(*) as nro_registros")
						->from("asistencia.consulta_registros_inasistencias('{$fecha}','{$fecha}') AS a")
						->where('a.out_direccion_id',$direccion_id);
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro_registros'];
		return 0;
	}

	/**
	 * Funcion para obtener el numero de registros de inasistencias por mes, ano y direccion
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return integer               [description]
	 */
	function nro_registros_inasistencia_por_mes_ano_direccion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("COUNT(*) as nro_registros")
						->from("asistencia.consulta_registros_inasistencias_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id);
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro_registros'];
		return 0;
	}

	/**
	 * Funcion para obtener el numero de horas trabajadas por direccion en un mes y año especifico
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return time               [description]
	 */
	function nro_horas_trabajadas_por_mes_ano_direcion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("SUM(a.out_horas_trabajadas) AS nro_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro_horas'];
		return "00:00:00";
	}

	/**
	 * Funcion para obtener el numero de horas trabajas por mes y año de una direccion expresado en valor UNIX
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return integer               [description]
	 */
	function int_horas_trabajadas_por_mes_ano_direcion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("EXTRACT(EPOCH FROM SUM(a.out_horas_trabajadas) ) AS int_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['int_horas'];
		return "0";
	}

	/**
	 * Funcion para obtener el numero de horas trabajadas pertenecientes a la jornada laboral
	 * por mes y año de una coordinacion
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return time               [description]
	 */
	function nro_horasd_jornada_trabajadas_por_mes_ano_direcion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("SUM(a.out_horas_jornada_trabajada) AS nro_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro_horas'];
		return "00:00:00";
	}

	/**
	 * Funcion para obtener el numero de horas trabajas perteneceientes a la jornada labora 
	 * por mes y año de una direccion expresado en valor UNIX
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return integer               [description]
	 */
	function int_horasd_jornada_trabajadas_por_mes_ano_direcion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("EXTRACT(EPOCH FROM SUM(a.out_horas_jornada_trabajada) ) AS int_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['int_horas'];
		return "0";
	}


	/**
	 * Funcion para obtener el numero de horas trabajas fuera del horario de la jornada laboral
	 * por mes y año de una coordinacion
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return time               [description]
	 */
	function nro_horasf_jornada_trabajadas_por_mes_ano_direcion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("SUM(a.out_horas_fuera_jornada) AS nro_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro_horas'];
		return "00:00:00";
	}

	/**
	 * Funcion para obtener el numero de horas trabajas fuera del horario de la jornada laboral
	 * por mes y año de una direccion expresado en valor UNIX
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return integer               [description]
	 */
	function int_horasf_jornada_trabajadas_por_mes_ano_direcion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("EXTRACT(EPOCH FROM SUM(a.out_horas_fuera_jornada) ) AS int_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['int_horas'];
		return "0";
	}

	/**
	 * Funcion para obtener el numero de horas faltantes por mes y año de una direccion
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return time               [description]
	 */
	function nro_horas_faltantes_por_mes_ano_direccion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("SUM(a.out_horas_faltantes) AS nro_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro_horas'];
		return "00:00:00";
	}

	/**
	 * Funcion para obtener el numero dehoras faltantes  
	 * por mes y año de una direccion expresado en valor UNIX
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return integer               [description]
	 */
	function int_horas_faltantes_por_mes_ano_direccion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("EXTRACT(EPOCH FROM SUM(a.out_horas_faltantes)) AS int_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['int_horas'];
		return "0";
	}

	/**
	 * Funcion para obtener el numero de horas faltantes del horario de la joranda labora 
	 * por mes y año de una direccion
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return time               [description]
	 */
	function nro_horas_jornada_faltantes_por_mes_ano_direccion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("SUM(a.out_horas_faltantes) AS nro_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro_horas'];
		return "00:00:00";
	}

	/**
	 * Funcion para obtener el numero de horas faltantes del horario de la joranda labora 
	 * por mes y año de una direccion expresado en valor UNIX
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return integer               [description]
	 */
	function int_horas_jornada_faltantes_por_mes_ano_direccion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("EXTRACT(EPOCH FROM SUM(a.out_horas_faltantes)) AS int_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['int_horas'];
		return "0";
	}


	/**
	 * Funcion para obtener el numero de horas extras realizadas
	 * por mes y año de una coordinacion
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return time               [description]
	 */
	function nro_horas_horas_extras_por_mes_ano_direcion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("SUM(a.out_horas_extras) AS nro_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro_horas'];
		return "00:00:00";
	}

	/**
	 * Funcion para obtener el numero de horas extras realizadas
	 * por mes y año de una direccion expresado en valor UNIX
	 * @param  integer $mes          [description]
	 * @param  integer $ano          [description]
	 * @param  integer $direccion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return integer               [description]
	 */
	function int_horas_horas_extras_por_mes_ano_direcion($mes = NULL,$ano = NULL, $direccion_id = NULL,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("EXTRACT(EPOCH FROM SUM(a.out_horas_extras)) AS int_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['int_horas'];
		return "0";
	}



	/**
	 * Funcion para obtener el numero de registros de asistencia por fecha
	 * @param  [type] $fecha     [description]
	 * @param  array  $excluidos [description]
	 * @return [type]            [description]
	 */
	function nro_registros_asistencia_por_fecha($fecha = NULL,$excluidos = array())
	{	
		if(is_null($fecha) ) return NULL;
		$condicion = array();

		$query = $this->db->select("COUNT(*) AS nro_registros")
						->from("( SELECT * FROM asistencia.consulta_registros_asistencia('{$fecha}') ) AS b");

		if( count($excluidos) > 0) $query = $this->db->where_not_in("b.out_cargo_id",$excluidos);

		$query = $this->db->get()->result_array();
		if (count($query)>0) return $query[0]['nro_registros'];
		return 0;
	}

	/**
	 * Funcion para obtener el numero de registros de inasistencias por fecha
	 * @param  [type] $fecha    [description]
	 * @param  array  $excluidos [description]
	 * @return [type]            [description]
	 */
	function nro_registros_inasistencia_fechas($fecha,$excluidos = array()){
		$query = $this->db->select("count(*) AS nro_registros")
						->from("asistencia.consulta_registros_inasistencias('{$fecha}','{$fecha}') AS a");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if( count($query) == 0 ) return 0;
		return $query[0]['nro_registros'];
	}

	/**
	 * Funcion para obtener el numero total de trabajadores por coordinacion
	 *
	 * Esta funcion permite filtrar si se desea obtener el listado general o solo el listado de 
	 * aquellos que deben registrar asistencia
	 * 
	 * @param  integer $direccion_id [description]
	 * @return array               [description]
	 */
	function nro_total_trabajadores_por_coordinacion($coordinacion_id = NULL, $ao = NULL){
		if(is_null($coordinacion_id)) return NULL;
		$condicion = array();
		$condicion['d.id_coordinacion'] = $coordinacion_id;
		$condicion['a.estatus'] = TRUE;
		if( !is_null($ao) ||is_bool($ao) ) $condicion['a.asistencia_obligatoria'] = $ao;
		$condicion['b.estatus'] = TRUE;
		$condicion['d.estatus'] = TRUE;
		$condicion['f.estatus'] = TRUE;

		$query = $this->db->select("COUNT(*) AS nro_registros")
						->from("administrativo.trabajadores AS a")
							->join("administrativo.datos_personales AS b","a.dato_personal_id = b.id_dato_personal")
							->join("administrativo.condiciones_laborales AS c","a.condicion_laboral_id = c.id_condicion_laboral")
							->join("administrativo.coordinaciones AS d","a.coordinacion_id = d.id_coordinacion")
							->join("administrativo.cargos AS e","a.cargo_id = e.id_cargo")
							->join("administrativo.direcciones AS f","d.direccion_id = f.id_direccion")
						->where($condicion)
						->get()->result_array();
		if(count($query)>0) return $query[0]['nro_registros'];
		return 0;
	}

	/**
	 * Funcion para obtener el numero de trabajadores presentes por coordinaciones
	 * @param  [type] $fecha        [description]
	 * @param  [type] $coordinacion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return [type]               [description]
	 */
	function nro_registros_asistencia_por_fecha_coordinacion($fecha = NULL,$coordinacion_id = NULL,$excluidos = array())
	{	
		if(is_null($fecha) ||is_null($coordinacion_id)) return NULL;
		$condicion = array();
		$condicion['b.out_coordinacion_id'] = $coordinacion_id;

		$query = $this->db->select("COUNT(*) AS nro_registros")
						->from(" asistencia.consulta_registros_asistencia('{$fecha}') AS b")
						->where($condicion);

		if( count($excluidos) > 0) $query = $this->db->where_not_in("b.out_cargo_id",$excluidos);

		$query = $this->db->get()->result_array();
		if (count($query)>0) return $query[0]['nro_registros'];
		return 0;
	}

	/**
	 * Funcion para obtener el numero de registros de inasistencias por coordinaciones
	 * @param  [type] $fecha        [description]
	 * @param  [type] $coordinacion_id [description]
	 * @param  array  $excluidos    [description]
	 * @return [type]               [description]
	 */
	function nro_registros_inasistencia_por_fecha_coordinacion($fecha = NULL, $coordinacion_id = NULL,$excluidos = array())
	{
		if(is_null($fecha) ||is_null($coordinacion_id)) return NULL;

		$query = $this->db->select("COUNT(*) as nro_registros")
						->from("asistencia.consulta_registros_inasistencias('{$fecha}','{$fecha}') AS a")
						->where('a.out_coordinacion_id',$coordinacion_id);
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro_registros'];
		return 0;
	}


	function nro_horas_requeridas_por_mes_ano_direccion($mes = NULL,$ano = NULL, $direccion_id = NULL ,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("SUM(a.out_horas_requeridas) AS nro_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro_horas'];
		return "00:00:00";
	}

	function int_horas_requeridas_por_mes_ano_direccion($mes = NULL,$ano = NULL, $direccion_id = NULL ,$excluidos = array())
	{
		if(is_null($mes) ||is_null($ano) ||is_null($direccion_id)) return NULL;

		$query = $this->db->select("EXTRACT(EPOCH FROM SUM(a.out_horas_requeridas)) AS int_horas")
						->from("asistencia.consulta_registros_asistencia_mes_ano('{$mes}','{$ano}') AS a")
						->where('a.out_direccion_id',$direccion_id)
						->group_by("a.out_direccion_id");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['int_horas'];
		return "0";
	}

}