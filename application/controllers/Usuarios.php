<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Usuarios_M');
	}

	public function index()
	{
		$this->lista();
	}

	public function lista(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Usuarios';
		$datos['titulo_descripcion'] = 'Lista de items';
		$datos['contenido'] = 'usuarios/usuarios_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function asignar(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Usuarios';
		$datos['titulo_descripcion'] = 'Asignar';
		$datos['contenido'] = 'usuarios/usuarios_form';
		$datos['form_action'] = 'Usuarios/validar_asignar';

		$datos['trabajador_id'] = set_value('trabajador_id');
		$datos['usuario'] = set_value('usuario');
		$datos['clave'] = set_value('clave');
		$datos['re_clave'] = set_value('re_clave');
		$datos['rol_id'] = set_value('rol_id');
		$datos['id_usuario'] = set_value('id_usuario');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/usuarios/v_usuarios_form.js'), 'ext' =>'js');
		
		$this->template_lib->render($datos);
	}

	public function check_usuario($usuario){
		$consulta = $this->Usuarios_M->callback_check_usuario($usuario);
		return $consulta;
	}

	public function validar_asignar(){
		if(count($this->input->post())==0) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$this->asignar();
		}else{
			$add = $this->Usuarios_M->asignar_usuario($this->input->post());
			if( $add ){ redirect(__CLASS__);
			}else{	
				echo '<script language="javascript">
						alert("No se pudo asignar el usuario, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; }
		}

	}


}