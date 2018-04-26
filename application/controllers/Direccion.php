<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Direccion extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Direccion_M');
	}


	public function index()
	{
		$this->lista();
	}

	public function lista(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso

		$datos['titulo_contenedor'] = 'Dirección';
		$datos['titulo_descripcion'] = 'Lista de items';
		$datos['contenido'] = 'direccion/direccion_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function agregar(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso

		$datos['titulo_contenedor'] = 'Dirección';
		$datos['titulo_descripcion'] = 'Agregar';
		$datos['contenido'] = 'direccion/direccion_form';

		$datos['form_action'] = 'Direccion/validar_agregar';
		$datos['btn_action'] = 'Agregar';

		$datos['direccion'] = set_value('direccion');
		$datos['descripcion'] = set_value('descripcion');
		$datos['estatus'] = set_value('estatus');
		$datos['id_direccion'] = set_value('id_direccion');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/direccion/v_direccion_form.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function validar_agregar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){ $this->agregar(); }
		else{
			$add = $this->Direccion_M->agregar_direccion($this->input->post() );
			if( $add ){ redirect(__CLASS__);
			}else{
				echo '<script language="javascript">
						alert("No se pudo crear la Dirección, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; 
			}
		}
	}

	public function editar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$item = $this->Direccion_M->consultar_direccion($id);
		if( is_null($item) ){
			echo '<script language="javascript">
						alert("No se encontro el item deseado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
		}else{
			$datos['contenido'] = 'direccion/direccion_form';
			$datos['form_action'] = 'Direccion/validar_editar';
			$datos['btn_action'] = 'Actualizar';

			$datos['direccion'] = set_value('direccion',$item['direccion']);
			$datos['descripcion'] = set_value('descripcion',$item['descripcion']);
			$datos['estatus'] = set_value('estatus',$item['estatus']);
			$datos['id_direccion'] = set_value('id_direccion',$item['id_direccion']);

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/direccion/v_direccion_form.js'), 'ext' =>'js');

			$this->template_lib->render($datos);
		}
	}

	public function validar_editar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$id = $this->seguridad_lib->execute_encryp($this->input->post('id_direccion'),'encrypt',__CLASS__);
			$this->editar($id);
		}else{
			$up = $this->Direccion_M->editar_direccion( $this->input->post() );
			if( $up ){ redirect(__CLASS__);
			}else{
				echo '<script language="javascript">
						alert("No se actualizar los datos de la dirección, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; }
		}

	}

	public function eliminar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$item = $this->Direccion_M->consultar_direccion($id);
		if( !is_null($item) ){
			$delete = $this->Direccion_M->eliminar_direccion($id);
			if( is_null($delete) ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que hay elementos que dependen de este items");
						window.location="'.base_url(__CLASS__).'";
					</script>'; 
			}elseif( $delete === false ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
			}else{
				redirect(__CLASS__); }
		}else{
			echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que no se encontro el registro solicitado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; }
	}
}
