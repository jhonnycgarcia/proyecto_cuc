<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinacion extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Coordinacion_M');
	}

	public function index()
	{
		$this->lista();
	}

	public function lista(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso

		$datos['titulo_contenedor'] = 'Coordinación';
		$datos['titulo_descripcion'] = 'Lista de items';
		$datos['contenido'] = 'coordinacion/coordinacion_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function agregar(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso

		$datos['titulo_contenedor'] = 'Coordinación';
		$datos['titulo_descripcion'] = 'Agregar';
		$datos['contenido'] = "coordinacion/coordinacion_form";
		$datos['form_action'] = "Coordinacion/validar_agregar";
		$datos['btn_action'] = "Agregar";

		$datos['coordinacion'] = set_value('coordinacion');
		$datos['descripcion'] = set_value('descripcion');
		$datos['direccion_id'] = set_value('direccion_id');
		$datos['estatus'] = set_value('estatus');
		$datos['id_coordinacion'] = set_value('id_coordinacion');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/coordinacion/v_coordinacion_form.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function validar_agregar(){
		if( count( $this->input->post() ) == 0 ) redirect("Coordinacion");

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){ $this->agregar(); }
		else{
			$add = $this->Coordinacion_M->agregar_coordinacion($this->input->post());
			if($add){redirect('Coordinacion');
			}else{
				echo '<script language="javascript">
						alert("No se pudo crear la Coordinación, favor intente nuevamente");
						window.location="'.base_url('Coordinacion').'";
					</script>'; }
		}
	}


	public function editar($id=NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect("Coordinacion");
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',"Coordinacion");

		$item = $this->Coordinacion_M->consultar_coordinacion($id);
		if(is_null($item)){
			echo '<script language="javascript">
						alert("No se encontro el item deseado, favor intente nuevamente");
						window.location="'.base_url('Coordinacion').'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Coordinación';
			$datos['titulo_descripcion'] = 'Editar';
			$datos['contenido'] = "coordinacion/coordinacion_form";
			$datos['form_action'] = "Coordinacion/validar_editar";
			$datos['btn_action'] = "Actualizar";

			$datos['coordinacion'] = set_value('coordinacion',$item['coordinacion']);
			$datos['descripcion'] = set_value('descripcion',$item['descripcion']);
			$datos['direccion_id'] = set_value('direccion_id',$item['direccion_id']);
			$datos['estatus'] = set_value('estatus',$item['estatus']);
			$datos['id_coordinacion'] = set_value('id_coordinacion',$item['id_coordinacion']);

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/coordinacion/v_coordinacion_form.js'), 'ext' =>'js');

			$this->template_lib->render($datos);
		}
	}

	public function validar_editar(){
		if( count( $this->input->post() ) == 0 ) redirect("Coordinacion");

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$id = $this->seguridad_lib->execute_encryp($this->input->post('id_coordinacion'),'encrypt',"Coordinacion");
			$this->editar($id);
		}else{
			$up = $this->Coordinacion_M->editar_coordinacion($this->input->post());
			if($up){ redirect("Coordinacion");
			}else{
				echo '<script language="javascript">
						alert("No se actualizar los datos de la Coordinacion, favor intente nuevamente");
						window.location="'.base_url('Coordinacion').'";
					</script>'; }
		}
	}

	public function eliminar($id=NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id)) redirect("Coordinacion");
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',"Coordinacion");

		$item = $this->Coordinacion_M->consultar_coordinacion($id);
		if( !is_null($item) ){
			$delete = $this->Coordinacion_M->eliminar_coordinacion($id);
			if( is_null($delete) ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que hay elementos que dependen de este items");
						window.location="'.base_url('Coordinacion').'";
					</script>'; 
			}elseif( $delete === false ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción, favor intente nuevamente");
						window.location="'.base_url('Coordinacion').'";
					</script>';
			}else{
				redirect('Coordinacion'); }
		}else{
			echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que no se encontro el registro solicitado, favor intente nuevamente");
						window.location="'.base_url('Coordinacion').'";
					</script>'; }
	}



}