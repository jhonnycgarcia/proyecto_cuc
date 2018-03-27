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
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso

		$datos['titulo_contenedor'] = 'Roles';
		$datos['titulo_descripcion'] = 'Lista de items';
		$datos['contenido'] = 'roles/roles_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$this->load->view('template/template',$datos);
	}

	public function agregar(){
		$datos['titulo_contenedor'] = 'Roles';
		$datos['titulo_descripcion'] = 'Agregar';
		$datos['form_action'] = 'Roles/validar_agregar';
		$datos['btn_action'] = 'Agregar';
		$datos['contenido'] = 'roles/roles_form';

		$datos['id'] = set_value('id');
		$datos['rol'] = set_value('rol');
		$datos['estatus'] = set_value('estatus');
		$datos['descripcion'] = set_value('descripcion');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/menu/v_roles_form.js'), 'ext' =>'js');

		$this->load->view("template/template",$datos);
	}

	public function validar_agregar(){
		if( count( $this->input->post() ) == 0 )
			redirect('Roles');

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$this->agregar();
		}else{
			$add = $this->Roles_M->agregar_item( $this->input->post() );
			if( $add ){
				redirect("Roles");
			}else{
				echo '<script language="javascript">
						alert("No se pudo crear el item, favor intente nuevamente");
						window.location="'.base_url('Roles').'";
					</script>'; 
			}
		}

	}

	public function editar($id){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso
		if( !isset($id) || !is_numeric($id) || ($id == 0 ) )
			redirect("Roles");

		$item = $this->Roles_M->consultar_item($id);
		if( is_null($item) ){
			echo '<script language="javascript">
						alert("No se encontro el item deseado, favor intente nuevamente");
						window.location="'.base_url('Menu').'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Roles';
			$datos['titulo_descripcion'] = 'Editar item';
			$datos['form_action'] = 'Roles/validar_editar';
			$datos['btn_action'] = 'Actualizar';
			$datos['contenido'] = 'roles/roles_form';

			$datos['id'] = set_value('id',$item['id']);
			$datos['rol'] = set_value('rol',$item['rol']);
			$datos['estatus'] = set_value('estatus',$item['estatus']);
			$datos['descripcion'] = set_value('descripcion',$item['descripcion']);

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/menu/v_roles_form.js'), 'ext' =>'js');

			$this->load->view("template/template",$datos);
		}
	}

	public function validar_editar(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso
		if( count( $this->input->post() ) == 0 )
			redirect("Roles");

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$this->editar();
		}else{
			$up = $this->Roles_M->actualizar_item( $this->input->post() );
			if( $up ){
				redirect("Roles");
			}else{
				echo '<script language="javascript">
						alert("No se pudo actualizar el item, favor intente nuevamente");
						window.location="'.base_url('Roles').'";
					</script>';
			}
		}
	}

	public function eliminar($id){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso
		if( !isset($id) || !is_numeric($id) || ($id == 0 ) )
			redirect("Roles");

		$item = $this->Roles_M->consultar_item($id);
		if( is_null($item) ){
			echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción, favor intente nuevamente");
						window.location="'.base_url('Roles').'";
					</script>';
		}else{
			$delete = $this->Roles_M->eliminar_item($id);
			if( is_null($delete) ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que hay elementos que dependen de este items");
						window.location="'.base_url('Roles').'";
					</script>'; 
			}elseif ( !$delete ) {
				echo '<script language="javascript">
					alert("No se pudo llevar a cabo esta acción, favor intente nuevamente");
					window.location="'.base_url('Roles').'";
				</script>'; 
			}else{
				redirect("Roles");
			}
		}
	}

}
