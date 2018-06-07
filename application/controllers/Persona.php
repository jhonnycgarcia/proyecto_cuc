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
		$datos['titulo_descripcion'] = 'Lista del personal';
		$datos['contenido'] = 'persona/persona_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'SweetAlert JS','path' => base_url('assets/sweetalert2/sweetalert2.all.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/persona/v_persona_lista.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function consultar($id = NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$persona = $this->Persona_M->consultar_persona($id);
		if(is_null($persona)){
			$merror['title'] = 'Error';
			$merror['text'] = 'No se encontro el registro deseado, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);
		}else{
			$this->load->model('Trabajadores_M');
			$datos['titulo_contenedor'] = 'Persona';
			$datos['titulo_descripcion'] = 'Consultar';
			$datos['contenido'] = 'persona/persona_consultar';
			$persona += array(
				'historial'=> $this->Trabajadores_M->obtener_historial_trabajador($persona['id_dato_personal'])
			);
			$datos['datos'] = $persona;

			$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
			// $datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/js/persona/v_persona_consultar.js'), 'ext' =>'js');
			
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
		$datos['imagen'] = set_value('imagen');
		$datos['act'] = "up";
		// $datos['act'] = "add";

		if ( isset($_SESSION['error_upload']) ) {
			$datos['error_upload'] = $_SESSION['error_upload'];
		}else{ $datos['error_upload'] = NULL; }
		
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

	private function cargar_imagen_servidor($imagen){
		$config['upload_path'] = "./assets/images/fotos/";
		$config['allowed_types'] = "png|jpg|jpeg";
		$config['max_size'] = 1024;
		$config['file_name'] = $this->input->post('cedula').'.jpg';
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->display_errors('<b>', '</b>');
		if ( ! $this->upload->do_upload('imagen') ) { 
			return array('estatus' => FALSE
				,'error' => $this->upload->display_errors()
				,'data' => array()
			);
		}else{
			unset($config);
			$config['source_image'] = './assets/images/fotos/'.$this->upload->data('file_name');
			$config['width'] = '160';
			$config['height'] = '160';
			$this->load->library('image_lib', $config);
			if( !$this->image_lib->resize() ){
				return array('estatus' => FALSE
					,'error' => $this->image_lib->display_errors()
					,'data' => $this->upload->data()
				);
			}

			return array('estatus' => TRUE
				,'error' => NULL
				,'data' => $this->upload->data()
			);
		}
	}

	private function eliminar_imagen_servidor($imagen){
		$delete = unlink('./assets/images/fotos/'.$upload_img['data']['file_name']);
		return $delete;
	}

	public function validar_agregar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){ $this->agregar(); }
		else{

			/* Validar si ingreso algun tipo de imagen */
			$upload_img = array();
			if($_FILES['imagen']['size'] > 0){
				$upload_img = $this->cargar_imagen_servidor($_FILES['imagen']);
				if( !$upload_img['estatus'] ){
					if( count($upload_img['data']) > 0){
						$delete_img = $this->eliminar_imagen_servidor($upload_img['data']['file_name']);
					}
					$this->session->set_flashdata('error_upload',$upload_img['error']);
					$this->agregar();
				}
			}

			$datos = $this->input->post();
			if(count($upload_img)>0) $datos['imagen'] = $upload_img['data']['file_name'];

			$add=$this->Persona_M->agregar_persona($datos);
			if($add){
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se creo el registro de la persona satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__); 
			}else{
				$delete_img = $this->eliminar_imagen_servidor($upload_img['data']['file_name']);
				$merror['title'] = 'Error';
				$merror['text'] = 'Ocurrio un inconveniente al momento de registrar a la persona, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}
			
		}
	}

	public function editar($id = NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$item = $this->Persona_M->consultar_persona($id);
		if(is_null($item)){
				$merror['title'] = 'Error';
				$merror['text'] = 'No se encontro el registro deseado, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__); 

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
			$datos['imagen'] = set_value('imagen',$item['imagen']);
			$datos['act'] = "up";

			if ( isset($_SESSION['error_upload']) ) {
				$datos['error_upload'] = $_SESSION['error_upload'];
			}else{ $datos['error_upload'] = NULL; }

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
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$id = $this->seguridad_lib->execute_encryp($this->input->post('id_dato_personal'),'encrypt',__CLASS__);
			$this->editar($id);
		}else
		{
			$up = $this->Persona_M->editar_persona($this->input->post());
			if($up){ 
				$merror['title'] = 'Registro Actualizado';
				$merror['text'] = 'Se actualizaron los datos del registro de manera exitosa';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__); 
			}else{
				$merror['title'] = 'Error';
				$merror['text'] = 'Ocurrio un inconveniente al momento de procesar los cambios, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}
		}
	}

	public function eliminar($id = NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$merror = array(
			'title'=>'',
			'text'=>"",
			'type'=>'',
			'confirmButtonText'=>'',
			'showCancelButton'=>false,
			'cancelButtonText'=>'',
			'confirmButtonColor'=>'#3085d6',
  			'cancelButtonColor'=>'#d33'
		);

		$item = $this->Persona_M->consultar_persona($id);
		if( !is_null($item) ){
			$delete = $this->Persona_M->eliminar_persona($id);
			if( is_null($delete) ){
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo llevar a cabo esta acción debido a que hay elementos que dependen de este registro';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';

				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);

			}elseif( $delete === FALSE ){
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo llevar a cabo esta acción ya que ocurrio un inconveniente, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';

				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);

			}else{
				$merror['title'] = 'Eliminado';
				$merror['text'] = 'Se elimino el registro satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__); }
		}else{
			$merror['title'] = 'Error';
			$merror['text'] = 'No se pudo llevar a cabo esta acción debido a que no se encontro el registro solicitado, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';

			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);
		}
	}


}