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

		$this->template_lib->render($datos);
	}

	public function consultar($id=NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect("Persona");
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',"Persona");

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

			$this->template_lib->render($datos);
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

		$datos['cedula_config'] = array();

		$datos['p_apellido'] = set_value('p_apellido');
		$datos['s_apellido'] = set_value('s_apellido');
		$datos['p_nombre'] = set_value('p_nombre');
		$datos['s_nombre'] = set_value('s_nombre');
		$datos['cedula'] = set_value('cedula');
		$datos['fecha_nacimiento'] = set_value('fecha_nacimiento');
		$datos['estado_civil_id'] = set_value('estado_civil_id');
		$datos['tipo_sangre_id'] = set_value('tipo_sangre_id');
		$datos['sexo'] = set_value('sexo');
		$datos['email'] = set_value('email');
		$datos['telefono_1'] = set_value('telefono_1');
		$datos['telefono_2'] = set_value('telefono_2');
		$datos['direccion'] = set_value('direccion');
		$datos['id_dato_personal'] = set_value('id_dato_personal');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Additional Method JS','path' => base_url('assets/jqueryvalidate/dist/additional-methods.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Input Mask JS','path' => base_url('assets/AdminLTE/plugins/input-mask/jquery.inputmask.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'Input Mask Extension JS','path' => base_url('assets/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/persona/v_persona_form.js'), 'ext' =>'js');
		

		$this->template_lib->render($datos);
	}

	/**
	 * Funcion de callback para verificar si la cedula se encuentra registrada
	 * @param  [string] 	$cedula 			[description]
	 * @return [boolean]	$consulta         	[description]
	 */
	public function check_cedula($cedula = NULL)
	{	
		$ans = FALSE;
		$this->form_validation->set_message('check_cedula', 'La <b>{field}</b> ingresada ya se encuentra registrada.');

		if( !is_null($cedula) ) $ans = $this->Persona_M->check_cedula($cedula);
		return $ans;
	}

	public function validar_agregar(){
		if( count( $this->input->post() ) == 0 ) redirect("Persona");

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){ $this->agregar(); }
		else{
			$add=$this->Persona_M->agregar_persona($this->input->post());
			if($add){ redirect("Persona");
			}else{
				echo '<script language="javascript">
						alert("No se pudo registrar la persona, favor intente nuevamente");
						window.location="'.base_url('Persona').'";
					</script>'; }
		}
	}

	public function editar($id=NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect("Persona");
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',"Persona");

		$item = $this->Persona_M->consultar_persona($id);
		if(is_null($item)){
			echo '<script language="javascript">
						alert("No se encontro el item deseado, favor intente nuevamente");
						window.location="'.base_url('Persona').'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Persona';
			$datos['titulo_descripcion'] = 'Editar';
			$datos['form_action'] = "Persona/validar_editar";
			$datos['btn_action'] = "Actualizar";
			$datos['contenido'] = "persona/persona_form";

			$datos['cedula_config'] = array('readonly' => 'readonly');

			$datos['p_apellido'] = set_value('p_apellido',$item['p_apellido']);
			$datos['s_apellido'] = set_value('s_apellido',$item['s_apellido']);
			$datos['p_nombre'] = set_value('p_nombre',$item['p_nombre']);
			$datos['s_nombre'] = set_value('s_nombre',$item['s_nombre']);
			$datos['cedula'] = set_value('cedula',$item['cedula']);
			$datos['fecha_nacimiento'] = set_value('fecha_nacimiento',$item['fecha_nacimiento']);
			$datos['estado_civil_id'] = set_value('estado_civil_id',$item['estado_civil_id']);
			$datos['tipo_sangre_id'] = set_value('tipo_sangre_id',$item['tipo_sangre_id']);
			$datos['sexo'] = set_value('sexo',$item['sexo']);
			$datos['email'] = set_value('email',$item['email']);
			$datos['telefono_1'] = set_value('telefono_1',$item['telefono_1']);
			$datos['telefono_2'] = set_value('telefono_2',$item['telefono_2']);
			$datos['direccion'] = set_value('direccion',$item['direccion']);
			$datos['id_dato_personal'] = set_value('id_dato_personal',$item['id_dato_personal']);

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Additional Method JS','path' => base_url('assets/jqueryvalidate/dist/additional-methods.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'Input Mask JS','path' => base_url('assets/AdminLTE/plugins/input-mask/jquery.inputmask.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'Input Mask Extension JS','path' => base_url('assets/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/persona/v_persona_form.js'), 'ext' =>'js');
			
			$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');

			$this->template_lib->render($datos);
		}
	}

	public function validar_editar(){
		if( count( $this->input->post() ) == 0 ) redirect("Persona");

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$id = $this->seguridad_lib->execute_encryp($this->input->post('id_dato_personal'),'encrypt',"Persona");
			$this->editar($id);
		}else
		{
			$up = $this->Persona_M->editar_persona($this->input->post());
			if($up){ redirect("Persona");
			}else{
				echo '<script language="javascript">
						alert("No se pudo actualizar los datos, favor intente nuevamente");
						window.location="'.base_url('Persona').'";
					</script>'; }
		}
	}

	public function eliminar($id=NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect("Persona");
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',"Persona");

		$item = $this->Persona_M->consultar_persona($id);
		if( !is_null($item) ){
			$delete = $this->Persona_M->eliminar_persona($id);
			if( is_null($delete) ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que hay elementos que dependen de este items");
						window.location="'.base_url('Persona').'";
					</script>'; 
			}elseif( $delete === FALSE ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción, favor intente nuevamente");
						window.location="'.base_url('Persona').'";
					</script>';
			}else{
				redirect('Persona'); }
		}else{
			echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que no se encontro el registro solicitado, favor intente nuevamente");
						window.location="'.base_url('Persona').'";
					</script>'; }
	}


}