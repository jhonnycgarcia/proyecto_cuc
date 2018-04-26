<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Template_M");
	}

	public function index()
	{
		$datos['heading'] = "404";
		$datos['message'] = "Acceso denegado";
		$this->load->view("errors/cli/error_404",$datos);
	}

	public function config_template(){
		$config = $this->Template_M->get_config();
		echo json_encode($config);
	}

}