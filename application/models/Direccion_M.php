<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Direccion_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function obtener_todos( $opcion = 3 ){
		$query = $this->db->query("SELECT * FROM administrativo.lista_direcciones({$opcion});")->result_array();
		return $query;
	}
}