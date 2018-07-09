<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Roles_M');
	}

	public function index()
	{
		$this->lista();
	}

	public function lista(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Roles';
		$datos['titulo_descripcion'] = 'Lista de items';
		$datos['contenido'] = 'roles/roles_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function agregar(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		
		$datos['titulo_contenedor'] = 'Roles';
		$datos['titulo_descripcion'] = 'Agregar';
		$datos['form_action'] = 'Roles/validar_agregar';
		$datos['btn_action'] = 'Agregar';
		$datos['contenido'] = 'roles/roles_form';

		$datos['id_rol'] = set_value('id_rol');
		$datos['rol'] = set_value('rol');
		$datos['estatus'] = set_value('estatus');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/roles/v_roles_form.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function validar_agregar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$this->agregar();
		}else{
			$add = $this->Roles_M->agregar_item( $this->input->post() );
			if( $add ){
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se creo el rol satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}else{
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo crear el rol, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}
		}

	}

	public function editar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$item = $this->Roles_M->consultar_item($id);
		if( is_null($item) ){
			$merror['title'] = 'Error';
			$merror['text'] = 'No se encontro el item deseado, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);
		}else{
			$datos['titulo_contenedor'] = 'Roles';
			$datos['titulo_descripcion'] = 'Editar item';
			$datos['form_action'] = 'Roles/validar_editar';
			$datos['btn_action'] = 'Actualizar';
			$datos['contenido'] = 'roles/roles_form';

			$datos['rol'] = set_value('rol',$item['rol']);
			$datos['estatus'] = set_value('estatus',$item['estatus']);
			$datos['id_rol'] = set_value('id_rol',$item['id_rol']);

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/roles/v_roles_form.js'), 'ext' =>'js');

			$this->template_lib->render($datos);
		}
	}

	public function validar_editar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$id = $this->seguridad_lib->execute_encryp($this->input->post('id_rol'),'encrypt',__CLASS__);
			$this->editar($id);
		}else{
			$up = $this->Roles_M->actualizar_item( $this->input->post() );
			if( $up ){
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se actualizaron los datos del rol satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}else{
				$merror['title'] = 'Error';
				$merror['text'] = 'No se actualizar los datos del rol, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}
		}
	}

	public function eliminar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$item = $this->Roles_M->consultar_item($id);
		if( is_null($item) ){
			$merror['title'] = 'Error';
			$merror['text'] = 'No se pudo llevar a cabo esta acción, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);
		}else{
			$delete = $this->Roles_M->eliminar_item($id);
			if( is_null($delete) ){
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo llevar a cabo esta acción debido a que hay elementos que dependen de este item';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}elseif ( !$delete ) {
					$merror['title'] = 'Error';
					$merror['text'] = 'No se pudo llevar a cabo esta acción, favor intente nuevamente';
					$merror['type'] = 'error';
					$merror['confirmButtonText'] = 'Aceptar';
					$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
					redirect(__CLASS__);
			}else{
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se elimino el rol satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}
		}
	}

}
