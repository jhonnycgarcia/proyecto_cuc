<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_M extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function get_config(){
		$sql = $this->db->get_where("seguridad.configuraciones",array('estatus'=>'t'))->result_array();
		return $sql[0];
	}
}