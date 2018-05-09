<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Funcion para consultar los registros de asistencia de una cedula
	 * @param  [type] $cedula [description]
	 * @return [type]         [description]
	 */
	function consultar_cedula($cedula){
		$query = $this->db->select("a.cedula, b.id_trabajador"
						.", CONCAT(a.p_apellido,' ',a.s_apellido) AS apellidos "
						.", CONCAT(a.p_nombre,' ',a.s_nombre) AS nombres "
						.", b.cargo_id, c.cargo"
						.", b.condicion_laboral_id, d.condicion_laboral"
						.", b.coordinacion_id, e.coordinacion")
						->from("administrativo.datos_personales AS a")
							->join("administrativo.trabajadores AS b","a.id_dato_personal = b.dato_personal_id")
							->join("administrativo.cargos AS c","b.cargo_id = c.id_cargo")
							->join("administrativo.condiciones_laborales AS d","b.condicion_laboral_id = d.id_condicion_laboral")
							->join("administrativo.coordinaciones AS e","b.coordinacion_id = e.id_coordinacion")
						->where(
							array("a.cedula"=>$cedula
								,"a.estatus"=>'t'
								,"b.estatus"=>'t'
							)
						)
						->get()->result_array();
		if( count($query)>0){
			$query = $query[0];

			$consulta = $this->fecha_ultimo_registro($query['id_trabajador'],1);
			if( !is_null($consulta) ){					// Registros anteriores a hoy pendientes
				$query += array('bloqueo'=>TRUE
					,'fecha'=>$consulta['fecha']
					,'tipo_registro'=>'ENTRADA');
				return $query;
			}
			$consulta = $this->fecha_ultimo_registro($query['id_trabajador'],2);
			if( !is_null($consulta) ){					// Registro del dia de hoy por cerrar
				if($consulta['nro_registros'] == 2){		// Dia cerrado
					$query += array('bloqueo'=>TRUE
						,'fecha'=> NULL
						,'tipo_registro'=> NULL);					
				}else{										// Dia por cerrar
					$query += array('bloqueo'=>FALSE
						,'fecha'=>$consulta['fecha']
						,'tipo_registro'=>'ENTRADA');
				}
				return $query;
			}

			$consulta = $this->fecha_ultimo_registro($query['id_trabajador']);
			if( is_null($consulta) ){					// No hay registros pendientes
				$query += array('bloqueo'=>FALSE
					,'fecha'=> NULL
					,'tipo_registro'=>NULL);
				return $query;
			}
		}else{
			return NULL;}
	}

	/**
	 * Funcion para obtener registros pendientes de asistencia de una cedula a consultar
	 * @param  [type]  $id_trabajador [description]
	 * @param  integer $opcion        [description]
	 * @return [type]                 [description]
	 */
	function fecha_ultimo_registro($id_trabajador, $opcion = 0){
		$query = $this->db->select("to_char(a.fecha,'DD/MM/YYYY') AS fecha"
							.", COUNT(a.fecha) AS nro_registros")
						->from("asistencia.registros_asistencia AS a")
							->join("administrativo.trabajadores AS b","a.trabajador_id = b.id_trabajador")
						->where(
							array("a.estatus"=>'t'
								,"a.trabajador_id"=>$id_trabajador
								,"b.estatus"=>"t"
							)
						);
		if( $opcion == 1 ){ $query = $this->db->where("a.fecha <>",date('d-m-Y')); }
		if( $opcion == 2 ){ $query = $this->db->where("a.fecha",date('d-m-Y')); }
		if( $opcion != 2 ){ $query = $this->db->having("COUNT(a.fecha) < 2"); }

		$query = $this->db->limit(1)
						->group_by("a.fecha")
						->get()->result_array();
		if( count($query)> 0 ) return $query[0];
		return NULL;
	}

	/**
	 * Funcion para obtener los ultimos registros de asistencia
	 * @param  integer $cantidad [description]
	 * @return [type]            [description]
	 */
	function ultimos_registros($cantidad = 3){
		$query = $this->db->select("a.id_registro_asistencia, c.cedula"
							.", to_char(a.fecha,'DD-MM-YYYY') AS fecha"
							.", to_char(a.hora,'HH12:MI') AS hora"
							.", a.tipo_registro"
							.", CONCAT(c.p_apellido,' ',c.p_nombre) AS apellido_nombre")
						->from("asistencia.registros_asistencia AS a")
							->join("administrativo.trabajadores AS b","a.trabajador_id = b.id_trabajador")
							->join("administrativo.datos_personales AS c","b.dato_personal_id = c.id_dato_personal")
						->where(array("a.estatus"=>'t',"b.estatus"=>"t"))
						->order_by("a.id_registro_asistencia","DESC")
						->limit($cantidad)
						->get()->result_array();
		if(count($query)>0){
			$cadena = "";
			foreach ($query as $key => $value) {
				if ($value['tipo_registro'] == "ENTRADA") {
					$cadena .= "<span class='label label-primary'>{$value['fecha']} - ";
					$cadena .= "{$value['cedula']} - ";
					$cadena .= "{$value['apellido_nombre']} - ";
					$cadena .= "{$value['tipo_registro']} - ";
					$cadena .= "{$value['hora']} ";
					$cadena .= "</span> &nbsp;&nbsp;";
				}else{
					$cadena .= "<span class='label label-danger'>{$value['fecha']} - ";
					$cadena .= "{$value['cedula']} - ";
					$cadena .= "{$value['apellido_nombre']} - ";
					$cadena .= "{$value['tipo_registro']} - ";
					$cadena .= "{$value['hora']} ";
					$cadena .= "</span> &nbsp;&nbsp;";
				}
			}
			return $cadena;
		} 
		return NULL;
	}

	/**
	 * Funcion para registrar la asistencia
	 * @param  [type] $datos [description]
	 * @return [type]        [description]
	 */
	function registrar_asistencia($datos){
		$query = $this->db->insert("asistencia.registros_asistencia",$datos);
		return $query;
	}


}