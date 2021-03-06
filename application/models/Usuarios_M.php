<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Funcion para obtener todos los usuarios de la tabla USUARIOS
	 * @param  [type] $opcion [description]
	 * @return [type]         [description]
	 */
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

	/**
	 * Funcion para consultar los trabajadores que no posean usuario asignado
	 * @return [type] [description]
	 */
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

	/**
	 * Funcion para obtener los roles dentro del sistema
	 * @return [type] [description]
	 */
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

	/**
	 * Funcion de CALLBACK para validar que la clave actual coincida
	 * @param  [type] $id_usuario [description]
	 * @param  [type] $clave      [description]
	 * @return [type]             [description]
	 */
	function callback_check_clave_actual($id_usuario,$clave){
		$query = $this->db->get_where("seguridad.usuarios",array('id_usuario'=>$id_usuario,'clave'=>$clave))->result_array();
		if( count($query)> 0 ) return TRUE;
		return FALSE;
	}

	/**
	 * Funcion para asignar un usuario a un trabajador
	 * @param  [type] $datos [description]
	 * @return [type]        [description]
	 */
	function asignar_usuario($datos){
		unset($datos['id_usuario']);
		unset($datos['re_clave']);
		$datos['clave'] = do_hash($datos['clave'].SEMILLA,'md5');
		$query = $this->db->insert("seguridad.usuarios",$datos);
		return $query;
	}

	/**
	 * Funcion para consultar los datos de un usuario a detalle
	 * @param  [type] $id_usuario [description]
	 * @return [type]             [description]
	 */
	function consultar_usuario($id_usuario){
		$query = $this->db->select("a.id_usuario, a.usuario"
						.", a.rol_id, b.rol"
						.", a.trabajador_id, CONCAT(d.p_apellido,' ',d.p_nombre) AS apellidos_nombres"
						.", a.estatus, a.sesion_activa")
						->from("seguridad.usuarios AS a")
							->join("seguridad.roles AS b","a.rol_id = b.id_rol")
							->join("administrativo.trabajadores AS c","a.trabajador_id = c.id_trabajador")
							->join("administrativo.datos_personales AS d","c.dato_personal_id = d.id_dato_personal")
						->where( array("a.id_usuario" => $id_usuario) )
						->get()->result_array();
		if(count($query)>0) return $query[0];
		return NULL;
	}

	/**
	 * Funcion para actualizar los datos de un usuario
	 * @param  [type] $datos [description]
	 * @return [type]        [description]
	 */
	function editar_usuario($datos){
		$id_usuario = array_pop($datos);
		$query = $this->db->where(array("id_usuario"=>$id_usuario,"sesion_activa"=>FALSE))
							->update("seguridad.usuarios",$datos);
		return $query;
	}

	/**
	 * Funcion para eliminar un usuario
	 * @param  [type] $id_usuario [description]
	 * @return [type]             [description]
	 */
	function eliminar_usuario($id_usuario){
		$query = $this->db->where("id_usuario",$id_usuario)
						->delete("seguridad.usuarios");
		if($query!=FALSE) return TRUE;
		return $query;
	}			
}