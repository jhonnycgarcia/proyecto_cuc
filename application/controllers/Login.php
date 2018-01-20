<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
	}

	public function index()
	{
		$datos['form_action'] = 'Login/validar_login';
		$this->load->view('login/login_form',$datos);
	}

	function validar_login(){
		redirect('Dashboard');
	}

}
