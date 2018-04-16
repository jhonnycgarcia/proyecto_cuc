<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Direccion_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function obtener_todos( $opcion = null ){
		if( is_null($opcion) ){ $query = $this->db->order_by('id_direccion','ASC')->get('administrativo.direcciones')->result_array();
		}elseif( $opcion ){ $query = $this->db->order_by('id_direccion','ASC')->get_where('administrativo.direcciones',array('estatus' => 't'))->result_array();
		}else{ $query = $this->db->order_by('id_direccion','ASC')->get_where('administrativo.direcciones',array('estatus' => 'f'))->result_array(); }
		return $query;
	}
	
}