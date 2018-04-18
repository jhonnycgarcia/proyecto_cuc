<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Persona_M');
	}

	public function index(){
		$this->lista();
	}

	public function lista()
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Persona';
		$datos['titulo_descripcion'] = 'Lista de items';
		$datos['contenido'] = 'persona/persona_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$this->load->view('template/template',$datos);
	}

	public function consultar($id)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$persona = $this->Persona_M->consultar_persona($id);
		if(is_null($persona)){
			echo '<script language="javascript">
						alert("No se encontro el registro deseado, favor intente nuevamente");
						window.location="'.base_url('Persona').'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Persona';
			$datos['titulo_descripcion'] = 'Consultar';
			$datos['contenido'] = 'persona/persona_consultar';
			$datos['datos'] = $persona;

			$this->load->view('template/template',$datos);
		}
	}

	public function agregar()
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Persona';
		$datos['titulo_descripcion'] = 'Agregar';
		$datos['form_action'] = "Persona/validar_agregar";
		$datos['btn_action'] = "Registrar";
		$datos['contenido'] = "persona/persona_form";

		$datos['p_apellido'] = set_value('p_apellido');
		$datos['s_apellido'] = set_value('s_apellido');
		$datos['p_nombre'] = set_value('p_nombre');
		$datos['s_nombre'] = set_value('s_nombre');
		$datos['cedula'] = set_value('cedula');
		$datos['fecha_nacimiento'] = set_value('fecha_nacimiento');
		$datos['email'] = set_value('email');
		$datos['telefono_1'] = set_value('telefono_1');
		$datos['telefono_2'] = set_value('telefono_2');
		$datos['direccion'] = set_value('direccion');
		$datos['id_dato_personal'] = set_value('id_dato_personal');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'Input Mask JS','path' => base_url('assets/AdminLTE/plugins/input-mask/jquery.inputmask.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'Input Mask Extension JS','path' => base_url('assets/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/persona/v_persona_form.js'), 'ext' =>'js');
		
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');

		$this->load->view('template/template',$datos);
	}

	public function validar_agregar(){
		if( count( $this->input->post() ) == 0 ) redirect("Persona");

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){ $this->agregar(); }
		else{
			var_export($_POST);
		}
	}


}