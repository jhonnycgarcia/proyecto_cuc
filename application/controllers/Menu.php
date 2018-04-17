<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Menu_M');
	}

	public function index()
	{
		// $this->lista();
		redirect('Menu/lista');
	}

	public function lista(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso

		$datos['titulo_descripcion'] = "Lista de items";
		$datos['titulo_contenedor'] = "Menu";
		$datos['contenido'] = "menu/menu_lista";

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');
		
		$this->load->view('template/template',$datos);
	}

	public function agregar(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso

		$datos['titulo_contenedor'] = "Menu";
		$datos['titulo_descripcion'] = "Agregar";

		$datos['contenido'] = "menu/menu_form";
		$datos['form_action'] = "Menu/validar_agregar";
		$datos['btn_action'] = "Agregar";

		$datos['menu'] = set_value('menu');
		$datos['link'] = set_value('link');
		$datos['icono'] = set_value('icono');
		$datos['visible_menu'] = set_value('visible_menu');
		$datos['estatus'] = set_value('estatus');
		$datos['posicion'] = set_value('posicion');
		$datos['relacion'] = set_value('relacion');
		$datos['rol_menu'] = set_value('rol_menu');
		$datos['id_menu'] = set_value('id_menu');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/menu/v_menu_form.js'), 'ext' =>'js');

		$this->load->view('template/template',$datos);
	}

	public function validar_agregar(){
		if( count( $this->input->post() ) == 0 )
			redirect('Menu');

		$this->form_validation->set_error_delimiters('<span>','</span>');

		if( !$this->form_validation->run() ){
			$this->agregar();
		}else{
			$add = $this->Menu_M->agregar_item( $this->input->post() );
			if( $add ){
				redirect('Menu');
			}else{
				echo '<script language="javascript">
						alert("No se pudo crear el item, favor intente nuevamente");
						window.location="'.base_url('Menu').'";
					</script>'; 
			}
		}
	}

	public function editar($id){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso
		if( !isset($id) || !is_numeric($id) || ($id == 0 ) ) redirect("Menu");

		$item = $this->Menu_M->consultar_item($id);
		if( is_null($item) ){
			echo '<script language="javascript">
						alert("No se encontro el item deseado, favor intente nuevamente");
						window.location="'.base_url('Menu').'";
					</script>';
		}else{
			
			$datos['titulo_contenedor'] = "Menu";
			$datos['titulo_descripcion'] = "Editar item";
			$datos['btn_action'] = "Actualizar";

			$datos['menu'] = set_value('menu',$item['menu']);
			$datos['link'] = set_value('link',$item['link']);
			$datos['icono'] = set_value('icono',$item['icono']);
			$datos['visible_menu'] = set_value('visible_menu',$item['visible_menu']);
			$datos['estatus'] = set_value('estatus',$item['estatus']);
			$datos['relacion'] = set_value('relacion',$item['relacion']);
			$datos['posicion'] = set_value('posicion',$item['posicion']);
			$datos['rol_menu'] = set_value('rol_menu',$item['rol_menu']);
			$datos['id_menu'] = set_value('id_menu',$item['id_menu']);

			$datos['contenido'] = "menu/menu_form";
			$datos['form_action'] = "Menu/validar_editar";

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/menu/v_menu_form.js'), 'ext' =>'js');

			$this->load->view('template/template',$datos);

		}
	}

	function validar_editar(){
		if( count( $this->input->post() ) == 0 ) redirect("Menu");
		$this->form_validation->set_error_delimiters('<span>','</span>');

		if( !$this->form_validation->run() ){
			$this->editar();
		}else{
			$up = $this->Menu_M->actualizar_item( $this->input->post() );
			if( $up ){
				redirect('Menu');
			}else{
				echo '<script language="javascript">
						alert("No se pudo actualizar el item, favor intente nuevamente");
						window.location="'.base_url('Menu').'";
					</script>';
			}
		}
	}

	public function eliminar($id){
		$this->seguridad_lib->acceso_metodo(__METHOD__);				// Validar acceso
		if( !isset($id) || !is_numeric($id) || ($id == 0 ) ) redirect("Menu");

		$datos = $this->Menu_M->consultar_item($id);
		if( is_null($datos) ){
			echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción, favor intente nuevamente");
						window.location="'.base_url('Menu').'";
					</script>';
		}else{
			$delete = $this->Menu_M->eliminar_item($id,$datos['relacion']);

			if( is_null($delete) ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que hay elementos que dependen de este items");
						window.location="'.base_url('Menu').'";
					</script>'; 
			}elseif ( $delete == false ) {
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción, favor intente nuevamente");
						window.location="'.base_url('Menu').'";
					</script>'; 
			}else{
				redirect("Menu");
			}
		}
	}

}
