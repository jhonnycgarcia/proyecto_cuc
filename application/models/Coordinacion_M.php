<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinacion_M extends CI_Model {

	public $ans = null;
	public $estatus = false;

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function consultar_lista( $opcion = null ){
		$query = $this->db->select('a.id_coordinacion, a.coordinacion, b.direccion, a.descripcion, a.estatus')
						->from('administrativo.coordinaciones AS a')
							->join('administrativo.direcciones AS b','a.direccion_id = b.id_direccion');
		if( $opcion ){ $query = $this->db->where( array('a.estatus' => 't') ); 
		}elseif( $opcion === false ){ $query = $this->db->where( array('a.estatus' => 'f') ); }
		$query = $this->db->order_by('a.id_coordinacion','ASC')->get()->result_array();
		return $query;
	}

}