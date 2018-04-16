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

		$this->load->view('template/template',$datos);
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

		$this->load->view('template/template',$datos);
	}

	public function editar(){

	}

	public function eliminar(){

	}
}
