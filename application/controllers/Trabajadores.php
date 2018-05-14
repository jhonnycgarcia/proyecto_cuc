<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trabajadores extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Trabajadores_M');
	}

	public function index()
	{
		$this->lista_activos();
	}

	/**
	 * Funcion para cargar la vista del listado de todos los Trabajadores activos
	 * @return [type] [description]
	 */
	public function lista_activos(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Trabajadores Activos';
		$datos['titulo_descripcion'] = 'Lista';
		$datos['contenido'] = 'trabajadores/trabajadores_lista_activos';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	/**
	 * Funcion para consultar listado de trabajadores por AJAX
	 * @return [type] [description]
	 */
	public function lista_activos_ajax($opcion = NULL){
		$trabajadores = $this->Trabajadores_M->consultar_lista($opcion);
		echo  json_encode($trabajadores,JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Funcion para cargar la vista de ingresar trabajador
	 * @param  [type] $id_dato_personal [description]
	 * @return [type]                   [description]
	 */
	public function ingresar($id_dato_personal = NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id_dato_personal) ) redirect(__CLASS__);
		$id_dato_personal = $this->seguridad_lib->execute_encryp($id_dato_personal,'decrypt',"Persona");

		$persona = $this->Trabajadores_M->consultar_personal($id_dato_personal);
		if( is_null($persona)){
			echo '<script language="javascript">
						alert("No se encontro el item deseado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Trabajador';
			$datos['titulo_descripcion'] = 'Ingresar';
			$datos['form_action'] = 'Trabajadores/validar_ingresar';
			$datos['btn_action'] = 'Ingresar';
			$datos['btn_cancelar'] = 'Persona';
			$datos['contenido'] = 'trabajadores/trabajadores_form';

			$datos['persona'] = $persona;
			$datos['coordinacion_id'] = set_value('coordinacion_id');
			$datos['condicion_laboral_id'] = set_value('condicion_laboral_id');
			$datos['cargo_id'] = set_value('cargo_id');
			$datos['fecha_ingreso'] = set_value('fecha_ingreso');
			$datos['fecha_egreso'] = set_value('fecha_egreso');
			$datos['asistencia_obligatoria'] = set_value('asistencia_obligatoria');
			$datos['id_trabajador'] = set_value('id_trabajador');
			$datos['dato_personal_id'] = set_value('dato_personal_id',$persona['id_dato_personal']);

			$datos['coordinacion_id_opciones'] = array();
			$datos['condicion_laboral_id_opciones'] = array();
			$datos['cargo_id_opciones'] = array();
			$datos['fecha_ingreso_opciones'] = array();
			$datos['fecha_egreso_opciones'] = array('disabled'=>'disabled');
			$datos['asistencia_obligatoria_opciones'] = array();

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/trabajadores/v_trabajadores_ingreso_form.js'), 'ext' =>'js');

			$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
			$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');
		

			$this->template_lib->render($datos);
		}
	}

	/**
	 * Funcion para el CALLBACK para verificar que la persona a registrar como trabajador no se encuentre activa ya como trabajador dentro del sistema
	 *
	 * Consultar persona no activa en trabajadores
	 * @param  [type] $id_dato_personal [description]
	 * @return [type]                   [description]
	 */
	public function check_persona_na($id_dato_personal){
		$ans = FALSE;
		$this->form_validation->set_message('check_persona_na', 'La <b>{field}</b> ingresada ya se encuentra registrada.');
		if( !is_null($id_dato_personal) ) $ans = $this->Trabajadores_M->check_persona_na($id_dato_personal);
		return $ans;
	}

	/**
	 * Funcion para validar los datos provenientes del formulario de ingresar trabajador
	 * @return [type] [description]
	 */
	public function validar_ingresar()
	{
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$id = $this->seguridad_lib->execute_encryp($this->input->post('dato_personal_id'),'encrypt',__CLASS__);
			$this->ingresar($id); 
		}else{
			$add = $this->Trabajadores_M->registrar_trabajador($this->input->post());
			if($add){
				$this->Trabajadores_M->estatus_persona($this->input->post('dato_personal_id'),true);
				redirect(__CLASS__);
			}else{
				echo '<script language="javascript">
						alert("No se pudo registrar el trabajador, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; }
		}
	}

	/**
	 * Funcion para ver los detalles de un registro de trabajador
	 * @param  [integer] 		$id 		[ID del trabajador]
	 * @return [type]     [description]
	 */
	public function detalles($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$trabajador = $this->Trabajadores_M->consultar_trabajador($id);
		if( is_null($trabajador) ){
			echo '<script language="javascript">
						alert("No se encontro el registro deseado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Trabajador';
			$datos['titulo_descripcion'] = 'Detalles';
			$datos['contenido'] = 'trabajadores/trabajadores_detalles';
			$datos['trabajador'] = $trabajador;
			$datos['btn_cancelar'] = 'Trabajadores/lista_activos';

			$this->template_lib->render($datos);
		}
	}

	/**
	 * Funcion para cargar el fomulario de egreso de trabajadores
	 * @param  [integer] 		$id 		[ID del trabajador]
	 * @return [type]     [description]
	 */
	public function egresar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$trabajador = $this->Trabajadores_M->consultar_trabajador($id);
		if( is_null($trabajador) ){
			echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que no se encontro el registro solicitado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Trabajador';
			$datos['titulo_descripcion'] = 'Egresar';
			$datos['form_action'] = 'Trabajadores/validar_egresar';
			$datos['btn_action'] = 'Egresar';
			$datos['btn_cancelar'] = 'Trabajadores';
			$datos['contenido'] = 'trabajadores/trabajadores_form';

			$datos['persona'] = $trabajador;
			$datos['coordinacion_id'] = set_value('coordinacion_id',$trabajador['coordinacion_id']);
			$datos['condicion_laboral_id'] = set_value('condicion_laboral_id',$trabajador['condicion_laboral_id']);
			$datos['cargo_id'] = set_value('cargo_id',$trabajador['cargo_id']);
			$datos['fecha_ingreso'] = set_value('fecha_ingreso',$trabajador['fecha_ingreso']);
			$datos['fecha_egreso'] = set_value('fecha_egreso');
			$datos['asistencia_obligatoria'] = set_value('asistencia_obligatoria',$trabajador['asistencia_obligatoria']);
			$datos['id_trabajador'] = set_value('id_trabajador',$trabajador['id_trabajador']);
			$datos['dato_personal_id'] = set_value('dato_personal_id',$trabajador['dato_personal_id']);

			$datos['coordinacion_id_opciones'] = array('disabled'=>'disabled');
			$datos['condicion_laboral_id_opciones'] = array('disabled'=>'disabled');
			$datos['cargo_id_opciones'] = array('disabled'=>'disabled');
			$datos['fecha_ingreso_opciones'] = array('disabled'=>'disabled');
			$datos['fecha_egreso_opciones'] = array();
			$datos['asistencia_obligatoria_opciones'] = array('disabled'=>'disabled');

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/trabajadores/v_trabajadores_egreso_form.js'), 'ext' =>'js');

			$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
			$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');
		
			$this->template_lib->render($datos);
		}
	}

	/**
	 * Funcion para validar los datos provenientes del formulario para egresar trabajadores
	 * @return [type] [description]
	 */
	public function validar_egresar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$id = $this->seguridad_lib->execute_encryp($this->input->post('id_trabajador'),'encrypt',__CLASS__);
			$this->egresar($id);
		}else{
			$datos = $this->input->post();
			$id_dato_personal = array_pop($datos);
			$up = $this->Trabajadores_M->egresar_trabajador($datos);
			if($up){
				$this->Trabajadores_M->estatus_persona($id_dato_personal,false);
				$this->Trabajadores_M->estatus_usuario($datos['id_trabajador'],false);
				redirect(__CLASS__);
			}else{
				echo '<script language="javascript">
						alert("No se pudo actualizar los datos, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; }
		}
	}

	/**
	 * Funcion para editar un registro de trabajadores
	 * @param  [integer] 		$id 		[ID del trabajador]
	 * @return [type]     [description]
	 */
	public function editar($id = NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		$trabajador = $this->Trabajadores_M->consultar_trabajador($id);
		if( is_null($trabajador) ){
			echo '<script language="javascript">
						alert("No se pudo llevar a cabo esta acción debido a que no se encontro el registro solicitado, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>';
		}else{
			$datos['titulo_contenedor'] = 'Trabajador';
			$datos['titulo_descripcion'] = 'Actualizar';
			$datos['form_action'] = 'Trabajadores/validar_editar';
			$datos['btn_action'] = 'Actualizar';
			$datos['btn_cancelar'] = 'Trabajadores';
			$datos['contenido'] = 'trabajadores/trabajadores_form';

			$datos['persona'] = $trabajador;
			$datos['coordinacion_id'] = set_value('coordinacion_id',$trabajador['coordinacion_id']);
			$datos['condicion_laboral_id'] = set_value('condicion_laboral_id',$trabajador['condicion_laboral_id']);
			$datos['cargo_id'] = set_value('cargo_id',$trabajador['cargo_id']);
			$datos['fecha_ingreso'] = set_value('fecha_ingreso',$trabajador['fecha_ingreso']);
			$datos['fecha_egreso'] = set_value('fecha_egreso');
			$datos['asistencia_obligatoria'] = set_value('asistencia_obligatoria',$trabajador['asistencia_obligatoria']);
			$datos['id_trabajador'] = set_value('id_trabajador',$trabajador['id_trabajador']);
			$datos['dato_personal_id'] = set_value('dato_personal_id',$trabajador['dato_personal_id']);

			$datos['coordinacion_id_opciones'] = array('disabled'=>'disabled');
			$datos['condicion_laboral_id_opciones'] = array('disabled'=>'disabled');
			$datos['cargo_id_opciones'] = array('disabled'=>'disabled');
			$datos['fecha_ingreso_opciones'] = array('disabled'=>'disabled');
			$datos['fecha_egreso_opciones'] = array('disabled'=>'disabled');
			$datos['asistencia_obligatoria_opciones'] = array();

			$this->template_lib->render($datos);
		}
	}

	/**
	 * Funcion para validar los datos provenientes del formulario de editar trabajadores
	 * @return [type] [description]
	 */
	public function validar_editar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$id = $this->seguridad_lib->execute_encryp($this->input->post('id_trabajador'),'encrypt',__CLASS__);
			$this->editar($id);
		}else{
			$up = $this->Trabajadores_M->editar_ao_trabajador($this->input->post('id_trabajador'),$this->input->post('asistencia_obligatoria'));
			if($up){ redirect(__CLASS__);
			}else{
				echo '<script language="javascript">
						alert("No se pudo actualizar los datos del trabajador, favor intente nuevamente");
						window.location="'.base_url(__CLASS__).'";
					</script>'; }
		}
	}

	/**
	 * Funcion para mostrar el listado de trabajadores egresados
	 * @return [type] [description]
	 */
	public function egresados(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Trabajador';
		$datos['titulo_descripcion'] = 'Egresos';
		$datos['contenido'] = 'trabajadores/trabajadores_lista_egresos';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');


		$this->template_lib->render($datos);
	}
}