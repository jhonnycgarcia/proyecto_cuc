<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuraciones extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Configuraciones_M');
	}

	public function index(){
		$this->lista();
	}

	/**
	 * Funcion para imprimir el listado de registros de la tabla CONFIGURACIONES
	 * @return [type] [description]
	 */
	public function lista()
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Configuraciones';
		$datos['titulo_descripcion'] = 'Lista';
		$datos['contenido'] = 'configuraciones/configuraciones_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	/**
	 * Funcion para ver detalles de un registro de CONFIGURACIONES
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function detalles($id = null)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);

		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$configuracion = $this->Configuraciones_M->consultar_configuracion($id);
		if(is_null($configuracion)){
			echo '<script language="javascript">
						alert("No se encontro el registro deseado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Configuraciones';
			$datos['titulo_descripcion'] = 'Detalles';
			$datos['contenido'] = 'configuraciones/configuraciones_detalles';

			$datos['configuracion'] = $configuracion;

			$this->template_lib->render($datos);
		}
	}

	/**
	 * Funcion para cargar el formulario de agregar configuracion
	 * @return [type] [description]
	 */
	public function agregar(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Configuraciones';
		$datos['titulo_descripcion'] = 'Agregar';
		$datos['form_action'] = 'Configuraciones/validar_agregar';
		$datos['btn_action'] = 'Agregar';
		$datos['contenido'] = 'configuraciones/configuraciones_form';

		$datos['tema_template'] = set_value('tema_template');
		$datos['tiempo_max_inactividad'] = set_value('tiempo_max_inactividad');
		$datos['tiempo_max_alerta'] = set_value('tiempo_max_alerta');
		$datos['tiempo_max_espera'] = set_value('tiempo_max_espera');
		$datos['camara'] = set_value('camara');
		$datos['hora_inicio'] = set_value('hora_inicio');
		$datos['hora_fin'] = set_value('hora_fin');
		$datos['id_configuracion'] = set_value('id_configuracion');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/configuraciones/v_configuraciones_agregar_form.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'WickedPicker Timer JS','path' => base_url('assets/wickedpicker/src/wickedpicker.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'WickedPicker Timer JS','path' => base_url('assets/wickedpicker/stylesheets/wickedpicker.css'), 'ext' =>'css');

		$this->template_lib->render($datos);

	}

	/**
	 * Funcion para validar los datos provenientes del formulario agregar configuracion
	 * @return [type] [description]
	 */
	public function validar_agregar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$this->agregar();
		}else
		{
			$add = $this->Configuraciones_M->agregar_configuracion($this->input->post());
			if($add){redirect(__CLASS__);
			}else{
				echo '<script language="javascript">
						alert("No se pudo crear el registro de configuracion, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; }
		}
	}

	/**
	 * Funcion para cargar el formulario de editar configuracion
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function editar($id = NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if(!isset($id)) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$configuracion = $this->Configuraciones_M->consultar_configuracion($id);
		if(is_null($configuracion)){
			echo '<script language="javascript">
						alert("No se encontro el item deseado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Configuraciones';
			$datos['titulo_descripcion'] = 'Actualizar';
			$datos['form_action'] = 'Configuraciones/validar_editar';
			$datos['btn_action'] = 'Actualizar';
			$datos['contenido'] = 'configuraciones/configuraciones_form';

			$datos['tema_template'] = set_value('tema_template',$configuracion['tema_template']);
			$datos['tiempo_max_inactividad'] = set_value('tiempo_max_inactividad',$configuracion['tiempo_max_inactividad']);
			$datos['tiempo_max_alerta'] = set_value('tiempo_max_alerta',$configuracion['tiempo_max_alerta']);
			$datos['tiempo_max_espera'] = set_value('tiempo_max_espera',$configuracion['tiempo_max_espera']);
			$datos['camara'] = set_value('camara',$configuracion['camara']);
			$datos['hora_inicio'] = set_value('hora_inicio',$configuracion['hora_inicio']);
			$datos['hora_fin'] = set_value('hora_fin',$configuracion['hora_fin']);
			$datos['id_configuracion'] = set_value('id_configuracion',$configuracion['id_configuracion']);

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/configuraciones/v_configuraciones_editar_form.js'), 'ext' =>'js');

			$datos['e_footer'][] = array('nombre' => 'WickedPicker Timer JS','path' => base_url('assets/wickedpicker/src/wickedpicker.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'WickedPicker Timer JS','path' => base_url('assets/wickedpicker/stylesheets/wickedpicker.css'), 'ext' =>'css');

			$this->template_lib->render($datos);
		}
	}

	/**
	 * Funcion para validar los datos provenientes del formulario editar configuracion
	 * @return [type] [description]
	 */
	public function validar_editar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$id = $this->seguridad_lib->execute_encryp($this->input->post('id_configuracion'),'encrypt',__CLASS__);
			$this->editar($id);
		}else
		{
			$up = $this->Configuraciones_M->editar_configuracion($this->input->post());
			if($up){ redirect(__CLASS__);
			}else{
				echo '<script language="javascript">
						alert("No se actualizar los datos del Cargo, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; }
		}
	}

	/**
	 * Funcion para activar un registro de configuraciones
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function activar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if(!isset($id)) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);
		
		$configuracion = $this->Configuraciones_M->consultar_configuracion($id);
		if( is_null($configuracion)){
			echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que no se encontro el registro solicitado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
		}else{
			$up = $this->Configuraciones_M->activar_configuracion($configuracion['id_configuracion']);
			if($up){ redirect(__CLASS__);
			}else{
				echo '<script language="javascript">
						alert("No se activar la configuracion, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; }
		}
	}


	/**
	 * Funcion para eliminar un registro de configuraciones
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function eliminar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if(!isset($id)) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$configuracion = $this->Configuraciones_M->consultar_configuracion($id);
		if( !is_null($configuracion) ){
			$delete = $this->Configuraciones_M->eliminar_configuracion($id);
			if( is_null($delete) ){
				echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que ocurrio un inconveniente, favor intente nuevamente");
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