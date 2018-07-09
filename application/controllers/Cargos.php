<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Cargos_M');
	}

	public function index()
	{
		$this->lista();
	}

	public function lista(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Cargos o Puestos de trabajo';
		$datos['titulo_descripcion'] = 'Lista de items';
		$datos['contenido'] = 'cargos/cargos_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function agregar()
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Condiciones Laborales';
		$datos['titulo_descripcion'] = 'Agregar';
		$datos['form_action'] = 'Cargos/validar_agregar';
		$datos['btn_action'] = 'Agregar';
		$datos['contenido'] = 'cargos/cargos_form';

		$datos['cargo'] = set_value('cargo');
		$datos['estatus'] = set_value('estatus');
		$datos['id_cargo'] = set_value('id_cargo');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/cargo/v_cargo_form.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function validar_agregar()
	{
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){ $this->agregar(); }
		else{
			$add = $this->Cargos_M->agregar_cargo($this->input->post());
			if($add){
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se creo el cargo satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}else{
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo crear el Cargo, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);}
		}
	}

	public function editar($id = NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$item = $this->Cargos_M->consultar_cargo($id);
		if(is_null($item)){
			echo '<script language="javascript">
						alert("No se encontro el item deseado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Cargos';
			$datos['titulo_descripcion'] = 'Editar';
			$datos['form_action'] = 'Cargos/validar_editar';
			$datos['btn_action'] = 'Actualizar';
			$datos['contenido'] = 'cargos/cargos_form';

			$datos['cargo'] = set_value('cargo',$item['cargo']);
			$datos['estatus'] = set_value('estatus',$item['estatus']);
			$datos['id_cargo'] = set_value('id_cargo',$item['id_cargo']);

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/cargo/v_cargo_form.js'), 'ext' =>'js');

			$this->template_lib->render($datos);
		}
	}

	public function validar_editar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$id = $this->seguridad_lib->execute_encryp($this->input->post('id_cargo'),'encrypt',__CLASS__);
			$this->editar($id);
		}else
		{
			$up=$this->Cargos_M->editar_cargo($this->input->post());
			if($up){ 
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se modifico el cargo satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}else{
				$merror['title'] = 'Error';
				$merror['text'] = 'No se actualizar los datos del Cargo, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);}
		}
	}

	public function eliminar($id = NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);

		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$item = $this->Cargos_M->consultar_cargo($id);
		if( !is_null($item) ){
			$delete = $this->Cargos_M->eliminar_cargo($id);
			if( is_null($delete) ){
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo llevar a cabo esta acción debido a que hay elementos que dependen de este items';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}elseif( $delete === false ){
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo llevar a cabo esta acción, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}else{
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se elimino el cargo satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);}
		}else{
			$merror['title'] = 'Error';
			$merror['text'] = 'No se pudo llevar a cabo esta acción debido a que no se encontro el registro solicitado, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);}
	}

}