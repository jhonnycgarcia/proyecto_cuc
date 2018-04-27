<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function consultar_lista($opcion = null){
		$query = $this->db->select("a.id_usuario, a.usuario, a.estatus, c.rol, a.sesion_activa")
						->from("seguridad.usuarios AS a")
							->join("administrativo.trabajadores AS b","a.trabajador_id = b.id_trabajador")
							->join("seguridad.roles AS c","a.rol_id = c.id_rol");
		if( $opcion === TRUE ){ $query = $this->db->where("a.estatus",'t');}
		if( $opcion === FALSE ){ $query = $this->db->where("a.estatus",'f');}
		$query = $this->db->where('b.estatus','t')
							->get()->result_array();
		return $query;
	}


	function consultar_trabajadores(){
		$query = $this->db->select("a.id_trabajador"
						.", CONCAT(b.p_apellido,' ',b.p_nombre,' - ',c.coordinacion) AS trabajador")
					->from("administrativo.trabajadores AS a")
						->join("administrativo.datos_personales AS b","a.dato_personal_id = b.id_dato_personal")
						->join("administrativo.coordinaciones As c","a.coordinacion_id = c.id_coordinacion")
					->where( array( 'a.estatus'=>'t' ) )
					->where('a.id_trabajador NOT IN (SELECT a.trabajador_id FROM seguridad.usuarios AS a)')
					->order_by('b.p_apellido','ASC')
					->get()->result_array();
		return $query;
	}

	function consultar_roles(){
		$query = $this->db->order_by('rol','ASC')
						->get_where("seguridad.roles",array('estatus'=>'t'))->result_array();
		return $query;
	}

	/**
	 * Funcion para el uso de CALLBACK
	 * @param  [type] $usuario [description]
	 * @return [type]          [description]
	 */
	function callback_check_usuario($usuario){
		$query = $this->db->get_where("seguridad.usuarios",array('usuario'=>$usuario))->result_array();
		if( count($query)>0) return FALSE;
		return TRUE;
	}

	function asignar_usuario($datos){
		unset($datos['id_usuario']);
		unset($datos['re_clave']);
		$datos['clave'] = do_hash($datos['clave'].SEMILLA,'md5');
		$query = $this->db->insert("seguridad.usuarios",$datos);
		return $query;
	}
}