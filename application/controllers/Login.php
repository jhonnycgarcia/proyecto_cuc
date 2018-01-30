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
		$this->ingresar();
	}

	public function ingresar(){
		$datos['form_action'] = 'validar_ingreso';
		$datos['error'] = '';
		$this->load->view('login/login_form',$datos);
	}

	function validar_ingreso(){
		if( !isset($_POST['usuario']) && !isset($_POST['contraseña']) )
			redirect('ingresar');

		var_export( $this->input->post() );
		// redirect('Dashboard');
	}

	public function salir(){
		redirect('ingresar');
	}

}
