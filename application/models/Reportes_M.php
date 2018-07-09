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
	function obtener_rango_fechas_asistencia($fdesde,$fhasta,$excluidos = array())
	{
		$query = $this->db->select("a.fecha")
						->from("asistencia.registros_asistencia AS a")
							->join("administrativo.trabajadores AS b","a.trabajador_id = b.id_trabajador")
						->where(array('a.estatus'=>'t'
							,'a.fecha >='=>$fdesde
							,'a.fecha <=' => $fhasta));
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("b.cargo_id",$excluidos);
		$query = $this->db->group_by('a.fecha')
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
	function nro_registros_asistencia_fechas($fdesde,$fhasta,$excluidos = array()){
		$query = $this->db->select("count(*) AS nro_registros")
						->from("asistencia.registros_asistencia AS a")
							->join("administrativo.trabajadores AS b","a.trabajador_id = b.id_trabajador")
						->where(array("a.estatus"=>true
							,"a.fecha >="=>$fdesde
							,"a.fecha <="=>$fhasta
							,"b.estatus"=>true));
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("b.cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if( count($query) == 0 ) return 0;
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
	
	function registros_asistencia_por_fecha($fecha,$excluidos = array())
	{	
		$query = $this->db->select("ROW_NUMBER() OVER (ORDER BY out_cedula) AS nro"
						.", b.out_id_trabajador AS id_trabajador"
						.", b.out_cedula AS cedula"
						.", out_fecha AS fecha"
						.", out_apellidos_nombres  AS apellidos_nombres "
						.", out_cargo AS cargo, out_cargo_id AS cargo_id "
						.", out_condicion_laboral AS condicion_laboral"
						.", out_condicion_laboral_id AS condicion_laboral_id "
						.", out_coordinacion AS coordinacion"
						.", out_coordinacion_id AS coordinacion_id "
						.", out_direccion AS direccion"
						.", out_direccion_id AS direccion_id "
						.", out_hora_entrada AS hora_entrada"
						.", out_hora_salida AS hora_salida "
						.", out_horas_trabajadas AS horas_trabajadas"
						.", out_horas_extras AS horas_extras "
						.", out_observaciones AS observaciones ")
						->from("( SELECT * FROM asistencia.consulta_registros_asistencia('{$fecha}') ) AS b");

		if( count($excluidos) > 0) $query = $this->db->where_not_in("b.out_cargo_id",$excluidos);

		$query = $this->db->get()->result_array();
		if (count($query)>0) {
			foreach ($query as $key => $value) {
				$f_hora = "".date('h:i:s A',strtotime($value['hora_entrada']))."";
				$query[$key]['hora_entrada'] = $f_hora;
				$f_hora = ($value['hora_salida'] != '00:00:00')
					?"".date('h:i:s A',strtotime($value['hora_salida'])).""
					:$value['hora_salida'];
				$query[$key]['hora_salida'] = $f_hora;
			}
		}
		return $query;
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
		$datos = array();
		$fechas = $this->obtener_rango_fechas_asistencia($fdesde,$fhasta,$excluidos);
		$nro_registros = $this->nro_registros_asistencia_fechas($fdesde,$fhasta,$excluidos);

		if( is_null($fechas) OR $nro_registros == 0 ) return NULL;

		foreach ($fechas as $key => $value) {
			$fechas[$key] += array('registros' => array() );

			$registros = $this->registros_asistencia_por_fecha($value['fecha'],$excluidos);
			$fechas[$key]['registros'] = $registros;

			var_export($fechas[$key]);echo "<br><br>";
			if(count($registros)>0){
				$datos[] = $fechas[$key];
			}
		}
		
		exit();
		return $datos;
	}

	/**
	 * Funcion para obtener el rango de fechas en donde existan trabajadores que no posean registros de asistencia
	 * @param  [type] $fdesde    [description]
	 * @param  [type] $fhasta    [description]
	 * @param  array  $excluidos [description]
	 * @return [type]            [description]
	 */
	function obtener_rango_fechas_inasistencia($fdesde,$fhasta,$excluidos = array())
	{
		$query = $this->db->select("a.out_fecha AS fecha")
						->from("asistencia.consulta_registros_inasistencias('{$fdesde}','{$fhasta}') AS a");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->group_by('a.out_fecha')
						->order_by('a.out_fecha','ASC')
						->get()->result_array();
		if(count($query)>0) return $query;
		return NULL;
	}


	function nro_registros_inasistencia_fechas($fdesde,$fhasta,$excluidos = array()){
		$query = $this->db->select("count(*) AS nro_registros")
						->from("asistencia.consulta_registros_inasistencias('{$fdesde}','{$fhasta}') AS a");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if( count($query) == 0 ) return 0;
		return $query[0]['nro_registros'];
	}

	function registros_inasistencia_por_fecha($fecha,$excluidos = array())
	{
		$query = $this->db->select("ROW_NUMBER() OVER (ORDER BY a.out_direccion"
								.", a.out_coordinacion"
								.", a.out_apellidos_nombres) AS nro"
							.", a.out_id_trabajador As id_trabajador, a.out_cedula AS cedula"
							.", a.out_apellidos_nombres AS apellidos_nombres"
							.", a.out_cargo_id AS cargo_id, a.out_cargo AS cargo"
							.", a.out_condicion_laboral_id AS condicion_laboral_id"
							.", a.out_condicion_laboral AS condicion_laboral"
							.", a.out_coordinacion_id AS coordinacion_id, a.out_coordinacion AS coordinacion"
							.", a.out_direccion_id AS direccion_id, a.out_direccion AS direccion"
							.", a.out_fecha AS fecha")
						->from("asistencia.consulta_registros_inasistencias('{$fecha}','{$fecha}') AS a");
		if( count($excluidos) > 0 ) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->order_by("a.out_direccion","ASC")
						->order_by("a.out_coordinacion","ASC")
						->order_by("a.out_apellidos_nombres","ASC")
						->get()->result_array();
		return $query;
	}

	/**
	 * Funcion para obtener los datos para el informe de registros de inasistencias
	 * @param  [type] $fdesde    [description]
	 * @param  [type] $fhasta    [description]
	 * @param  array  $excluidos [description]
	 * @return [type]            [description]
	 */
	function registros_inasistencia($fdesde,$fhasta,$excluidos = array() )
	{
		$datos = array();
		$fechas = $this->obtener_rango_fechas_inasistencia($fdesde,$fhasta,$excluidos);
		$nro_registros = $this->nro_registros_inasistencia_fechas($fdesde,$fhasta,$excluidos);

		if( is_null($fechas) OR $nro_registros == 0 ) return NULL;

		foreach ($fechas as $key => $value) {
			$fechas[$key] += array('registros' => array() );

			$registros = $this->registros_inasistencia_por_fecha($value['fecha'],$excluidos);
			$fechas[$key]['registros'] = $registros;
			if( count($registros) >0) { $datos[] = $fechas[$key]; }
		}

		return $datos;
	}

	/**
	 * Funcion para obtener el numero de registros que tienen horas extras
	 * @param  [type] $fecha     [description]
	 * @param  array  $excluidos [description]
	 * @return [type]            [description]
	 */
	function obtener_nro_registros_horas_extras($fecha,$excluidos = array() )
	{
		$fecha = explode('/', $fecha);
		if(!is_array($fecha)) return NULL;
		$query = $this->db->select("COUNT(*) AS nro")
						->from("asistencia.consultar_horas_extras('$fecha[0]','$fecha[1]')")
						->where("out_horas_extras > '00:00:00' ");
		if(count($excluidos)>0) $query = $this->db->where_not_in("out_cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if(count($query)>0) return $query[0]['nro'];
		return NULL;
	}

	/**
	 * Funcion para obtener el listado de trabajadores que poseen horas extras
	 * @param  [type] $fecha     [description]
	 * @param  array  $excluidos [description]
	 * @return [type]            [description]
	 */
	function obtener_trabajadores_horas_extras($fecha,$excluidos = array() )
	{
		$fecha = explode('/', $fecha);
		if(!is_array($fecha)) return NULL;
		$query = $this->db->select("ROW_NUMBER() OVER (ORDER BY a.out_direccion"
								.", a.out_coordinacion"
								.", a.out_apellidos_nombres ) AS nro"
							.", a.out_id_trabajador As id_trabajador, a.out_cedula AS cedula"
							.", a.out_apellidos_nombres AS apellidos_nombres"
							.", a.out_cargo_id AS cargo_id, a.out_cargo AS cargo"
							.", a.out_condicion_laboral_id AS condicion_laboral_id"
							.", a.out_condicion_laboral AS condicion_laboral"
							.", a.out_coordinacion_id AS coordinacion_id, a.out_coordinacion AS coordinacion"
							.", a.out_direccion_id AS direccion_id, a.out_direccion AS direccion"
							.", SUM(a.out_horas_diurnas)  AS total_horas_extras_diurnas"
							.", SUM(a.out_horas_nocturnas)  AS total_horas_extras_nocturnas"
							.", SUM(a.out_horas_extras)  AS total_horas_extras"
							.", '$fecha[0]/$fecha[1]'::VARCHAR AS periodo_laboral ")
						->from("asistencia.consultar_horas_extras('$fecha[0]','$fecha[1]') AS a");
		if(count($excluidos)>0) $query = $this->db->where_not_in("a.out_cargo_id",$excluidos);
		$query = $this->db->group_by(
								array(
									"a.out_id_trabajador"
									, "a.out_cedula"
									, "a.out_apellidos_nombres "
									, "a.out_cargo_id "
									, "a.out_cargo"
									, "a.out_condicion_laboral_id"
									, "a.out_condicion_laboral"
									, "a.out_coordinacion_id"
									, "a.out_coordinacion"
									, "a.out_direccion_id"
									, "a.out_direccion"
									)
								)
							->having("SUM(a.out_horas_extras) > '00:00:00'")
							->order_by("a.out_direccion ASC"
									.", a.out_coordinacion ASC"
									.", a.out_apellidos_nombres ASC"
								)
							->get()->result_array();
		if(count($query>0)) return $query;
		return NULL;
	}

	function obtener_registros_horas_extras_trabajador($fecha,$trabajador_id)
	{
		$fecha = explode('/', $fecha);
		if(!is_array($fecha)) return NULL;
		$query = $this->db->select("ROW_NUMBER() OVER (ORDER BY a.out_fecha) AS nro"
							.", a.out_fecha AS fecha"
							.", a.out_observaciones AS observaciones"
							.", a.out_hora_entrada AS hora_entrada"
							.", a.out_hora_salida AS hora_salida"
							.", a.out_horas_trabajadas AS horas_trabajadas"
							.", a.out_horas_diurnas AS horas_extras_diurnas"
							.", a.out_horas_nocturnas AS horas_extras_nocturnas"
							.", a.out_horas_extras AS horas_extras"
							.", (CASE WHEN ( EXTRACT(DOW FROM a.out_fecha) IN ('0','6') ) THEN 'X' 
								ELSE NULL END)::VARCHAR AS no_laborable")
						->from("asistencia.consultar_horas_extras('$fecha[0]','$fecha[1]') AS a")
						->where(array(
								"a.out_horas_extras >" => '00:00:00'
								, "a.out_id_trabajador" => $trabajador_id)
							)
						->order_by("a.out_fecha","ASC")
						->get()->result_array();
		if( count($query)>0 )
		{
			foreach ($query as $key => $value) {
				$f_hora = "".date('h:i:s A',strtotime($value['hora_entrada']))."";
				$query[$key]['hora_entrada'] = $f_hora;
				$f_hora = "".date('h:i:s A',strtotime($value['hora_salida']))."";
				$query[$key]['hora_salida'] = $f_hora;
			}
			return $query;
		}
		return array();
	}

	/**
	 * Funcion para obtener el calculo de horas extras
	 * @param  [type] $fecha    [description]
	 * @param  array  $excluidos [description]
	 * @return [type]            [description]
	 */
	function registro_horas_extras($fecha,$excluidos = array() )
	{
		$datos = array();
		$nro_registros = $this->obtener_nro_registros_horas_extras($fecha,$excluidos);
		$trabajadores = $this->obtener_trabajadores_horas_extras($fecha, $excluidos);
		if( (is_null($nro_registros)||$nro_registros == 0) || is_null($trabajadores) ) return NULL;

		foreach ($trabajadores as $key => $value) {
			$trabajadores[$key] += array('registros' => array() );
			$registros = $this->obtener_registros_horas_extras_trabajador($fecha,$value['id_trabajador']);
			$trabajadores[$key]['registros'] = $registros;
			if (count($registros)>0) { $datos[] =  $trabajadores[$key]; }
		}
		return $trabajadores;
	}

	function obtener_nro_registros_tipo_registro_por_fecha($fecha = NULL,$tipo_registro = NULL ,$excluidos = array())
	{
		if(is_null($fecha) || is_null($tipo_registro) ) return NULL;
		$condicion = array();
		$condicion['a.estatus'] = TRUE;
		$condicion['b.estatus'] = TRUE;
		$condicion['c.estatus'] = TRUE;
		$query = $this->db->select('COUNT(a.fecha) AS nro')
						->from("asistencia.registros_asistencia AS a")
							->join("administrativo.trabajadores AS b","a.trabajador_id = b.id_trabajador")
							->join("administrativo.datos_personales AS c","b.dato_personal_id = c.id_dato_personal")
						->where($condicion);
		if(count($excluidos)>0) $query = $this->db->where_not_in("b.cargo_id",$excluidos);
		$query = $this->db->get()->result_array();
		if (count($query)>0) return $query[0]['nro'];
		return NULL;
	}

}