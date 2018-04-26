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
		redirect('Roles/lista');
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
				redirect(__CLASS__);
			}else{
				echo '<script language="javascript">
						alert("No se pudo crear el item, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; 
			}
		}

	}

	public function editar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$item = $this->Roles_M->consultar_item($id);
		if( is_null($item) ){
			echo '<script language="javascript">
						alert("No se encontro el item deseado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
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
				redirect(__CLASS__);
			}else{
				echo '<script language="javascript">
						alert("No se pudo actualizar el item, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
			}
		}
	}

	public function eliminar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$item = $this->Roles_M->consultar_item($id);
		if( is_null($item) ){
			echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
		}else{
			$delete = $this->Roles_M->eliminar_item($id);
			if( is_null($delete) ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que hay elementos que dependen de este items");
						window.location="'.base_url(__CLASS__).'";
					</script>'; 
			}elseif ( !$delete ) {
				echo '<script language="javascript">
					alert("No se pudo llevar a cabo esta acción, favor intente nuevamente");
					window.location="'.base_url(__CLASS__).'";
				</script>'; 
			}else{
				redirect(__CLASS__);
			}
		}
	}

}
