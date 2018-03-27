<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index(){
		// $this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso
		$this->load->view('template/template');
	}
}
