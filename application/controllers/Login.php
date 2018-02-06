<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Login_M');
	}

	public function index()
	{
		$this->ingresar();
	}

	/**
	 * Funcion para cargar el formulario de logeo
	 * @return [type] [description]
	 */
	public function ingresar(){
		if( $this->seguridad_lib->login_in() )								// Validar si se encuentra logeado
			redirect('Dashboard');

		$datos['form_action'] = 'validar_ingreso';

		if( $this->session->has_userdata('error') )
			$datos['error'] = $this->session->userdata('error');

		$this->load->view('login/login_form',$datos);
	}

	/**
	 * Funcion para validar los datos provenientes del formulario
	 * @return [type] [description]
	 */
	function validar_ingreso(){

		if( !isset($_POST['usuario']) && !isset($_POST['contraseña']) )			// Comprobar campos
			redirect('ingresar');

		if( $this->form_validation->run() == FALSE ){									
			$this->session->set_flashdata('error', validation_errors() );
			redirect('ingresar');
		}else{
			$data['usuario'] = strtolower( $this->input->post('usuario') );
			$data['clave'] = do_hash( $this->input->post('contraseña').SEMILLA, 'md5' );
			
			$answer = $this->Login_M->consultar($data);

			if( $answer == false ){
				$this->session->set_flashdata('error', '<b>Usuario y/o contraseña</b> invalida, favor intente nuevamente' );
				redirect('ingresar');
			}else{
				redirect('Dashboard');
			}
		}

	}

	/**
	 * Funcion para cerrar sesion dentro del sistema
	 * @return [type] [description]
	 */
	public function salir(){
		$this->seguridad_lib->bitacora_sesion( array( 'usuario_id' => $this->session->userdata('id_usuario'), 'accion' => 'SALIR' ) );
		$this->session->sess_destroy();
		redirect('ingresar');
	}

}
