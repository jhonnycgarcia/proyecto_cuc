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

		$this->load->view('template/template',$datos);
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

		$this->load->view('template/template',$datos);
	}

	public function validar_agregar()
	{
		if( count( $this->input->post() ) == 0 ) redirect("Cargos");

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){ $this->agregar(); }
		else{
			$add = $this->Cargos_M->agregar_cargo($this->input->post());
			if($add){redirect('Cargos');
			}else{
				echo '<script language="javascript">
						alert("No se pudo crear el Cargo, favor intente nuevamente");
						window.location="'.base_url('Cargos').'";
					</script>'; }
		}
	}

	public function editar($id=NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) || !is_numeric($id) || ($id == 0 ) ) redirect("Cargos");

		$item = $this->Cargos_M->consultar_cargo($id);
		if(is_null($item)){
			echo '<script language="javascript">
						alert("No se encontro el item deseado, favor intente nuevamente");
						window.location="'.base_url('Cargos').'";
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

			$this->load->view('template/template',$datos);
		}
	}

	public function validar_editar(){
		if( count( $this->input->post() ) == 0 ) redirect("Cargos");

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$this->editar();
		}else
		{
			$up=$this->Cargos_M->editar_cargo($this->input->post());
			if($up){ redirect("Cargos");
			}else{
				echo '<script language="javascript">
						alert("No se actualizar los datos del Cargo, favor intente nuevamente");
						window.location="'.base_url('Cargos').'";
					</script>'; }
		}
	}

	public function eliminar($id)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) || !is_numeric($id) || ($id == 0 ) ) redirect("Cargos");

		$item = $this->Cargos_M->consultar_cargo($id);
		if( !is_null($item) ){
			$delete = $this->Cargos_M->eliminar_cargo($id);
			if( is_null($delete) ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que hay elementos que dependen de este items");
						window.location="'.base_url('Cargos').'";
					</script>'; 
			}elseif( $delete === false ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción, favor intente nuevamente");
						window.location="'.base_url('Cargos').'";
					</script>';
			}else{
				redirect('Cargos'); }
		}else{
			echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que no se encontro el registro solicitado, favor intente nuevamente");
						window.location="'.base_url('Cargos').'";
					</script>'; }
	}

}