<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Funcion para obtener todos los items de la tabla MENUS
	 * @param  boolean 	$opcion 
	 *         [description]
	 * @return array         
	 *         [description]
	 */
	function obtener_todos( $opcion = null ){
		if( is_null($opcion) ){ $query= $this->db->order_by('id_menu','ASC')->get('seguridad.menus')->result_array();
		}elseif( $opcion ){ $query = $this->db->order_by('id_menu','ASC')->get_where('seguridad.menus',array('estatus' => 't'))->result_array();
		}else{$query = $this->db->order_by('id_menu','ASC')->get_where('seguridad.menus',array('estatus' => 'f'))->result_array(); }
		return $query;
	}

	/**
	 * Funcion para formatear el array antes de crear un nuevo registro de item en MENUS
	 * @param  array 		$datos 			[description]
	 * @return array 		$datos       	[description]
	 */
	function formatear_datos($datos){
		if( $datos['visible_menu'] == 'f' ){
			$datos['posicion'] = 0;
			$datos['relacion'] = 0;
			$datos['icono'] = 'fa fa-cog'; }
		return $datos;
	}

	/**
	 * Funcion para agregar un nuevo item a la tabla MENUS
	 * @param  array 		$datos 		[description]
	 * @return boolean 		$ans 		[description]
	 */
	function agregar_item( $datos ){
		$ans = false;
		unset($datos['id_menu']);
		$id_rol_menu = array_pop($datos);
		$datos = $this->formatear_datos($datos);		// Formatear datos
		$status = $this->db->insert('seguridad.menus',$datos);
		if( $status ){
			$ans = true;
			$id = $this->db->insert_id();
			foreach ($id_rol_menu as $key => $value) {
				$data_id_rol_menu[] = array( 'rol_id' => $value, 'menu_id' => $id );
			}
			$this->agregar_rol_menu($data_id_rol_menu);
		}
		return $ans;
	}

	/**
	 * Funcion para insertar registros en la tabla ROLES_MENUS
	 * @param  array 		$datos 			[description]
	 */
	function agregar_rol_menu($datos){
		$query = $this->db->insert_batch('seguridad.roles_menus',$datos);
	}

	/**
	 * Funcion para obtener todos los detalles de un item de la tabla MENUS
	 * @param  integer 		$id 		[description]
	 * @return array/null   $query  	[description]
	 */
	function consultar_item($id = null){
		if( !is_null($id) ){
			$query = $this->db->get_where('seguridad.menus',array('id_menu' => $id) )->result_array();
			if( count($query) > 0 ){
				$query = $query[0];
				$rol_menu = $this->obtener_rol_menu($id);
				$query += array( 'rol_menu' => $rol_menu );
				return $query;
			}
		}else{ return null; }
	}

	/**
	 * Funcion para obtener todos los registros de la tabla ROLES_MENUS que dependan de un items de menu
	 * @param  integer 			$id 		[description]
	 * @return array     		$ans
	 */
	function obtener_rol_menu($id){
		$ans = array();
		$query = $this->db->get_where('seguridad.roles_menus',array('menu_id' => $id) )->result_array();
		if( count($query) > 0 ){
			foreach ($query as $key => $value) {
				$ans[] = $value['rol_id'];
			}
		}
		return $ans;
	}

	/**
	 * Funcion para actualizar los campos de un items de MENU
	 * @param  array 		$datos 		[description]
	 * @return boolean		$ans        [description]
	 */
	function actualizar_item($datos){
		$ans = false;
		$id = array_pop($datos);
		$id_roles = array_pop($datos);
		$status = $this->db->where("a.id_menu",$id)
							->update("seguridad.menus AS a",$datos);
		if( $status ){
			$ans = true;
			foreach ($id_roles as $key => $value) {
				$data_id_rol_menu[] = array( 'rol_id' => $value, 'menu_id' => $id );
			}
			$this->eliminar_rol_menu($id);
			$this->agregar_rol_menu($data_id_rol_menu);
		}
		return $ans;
	}

	/**
	 * Funcion para eliminar los registros de la tabla ROLES_MENUS que dependan del item a modificar
	 * @param  integer 		$id 		[El identificador del item a modificar]
	 */
	function eliminar_rol_menu($id){
		$query = $this->db->where( array("a.menu_id" => $id) )
							->delete("seguridad.roles_menus AS a");
	}

	/**
	 * Funcion para consultar si un item posee registros dependientes a de el
	 * @param  integer 		$id 		[El id del item de menu a consultar]
	 * @return boolean		$ans     	[TRUE en caso de conseguir registros,
	 *                            	 	FALSE en caso contratio]
	 */
	function consultar_items_dependientes($id){
		$ans = false;
		$query = $this->db->get_where("seguridad.menus AS a", array("a.relacion" => $id) )->result_array();
		if( count($query) > 0 )
			$ans = true;
		return $ans;
	}

	function eliminar_item($id,$relacion){
		$ans = false;
		if( $relacion == 0 ){
			$consultar = $this->consultar_items_dependientes($id);
			if( $consultar )
				return $ans = null;
		}
		
		$this->eliminar_rol_menu($id);
		$status = $this->db->where("a.id_menu",$id)->delete("seguridad.menus AS a");
		if( $status != false )
			$ans = true;
		return $ans;
	}

}