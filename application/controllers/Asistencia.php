<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia extends CI_Controller {

	public $formato = array(
			'consulta' => null,
			'cedula' => null,
			'apellidos' => null,
			'nombres' => null,
			'cargo'	=> null,
			'coordinacion' => null,
			'condicion_laboral' => null,
			'bloqueo' => null,
			'fecha' => null,
			'tipo_registro' => null,
			'trabajador_id' => null
		);

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model(array('Asistencia_M',"Configuraciones_M"));
	}


	public function index(){
		$configuracion = $this->Configuraciones_M->consultar_lista(true);
		$datos['form_action'] = 'Asistencia/validar_registro_asistencia';
		$datos['configuracion'] = json_encode($configuracion[0]);

		$mensaje_modal = 'null';
		if( $this->session->has_userdata('mensaje_modal') ){$mensaje_modal = $_SESSION['mensaje_modal'];}
		$datos['mensaje_modal'] = $mensaje_modal;

		$this->load->view('asistencia/asistencia_form',$datos);
	}

	/**
	 * Funcion para validar los campos provenientes del formulario de registro de asistencia publico
	 * @return [type] [description]
	 */
	public function validar_registro_asistencia(){
		if( count($this->input->post()) < 3) redirect(__CLASS__);

		$configuracion = $this->Configuraciones_M->consultar_lista(true);
		$configuracion = $configuracion[0];
		$mensaje_modal = array();
		$opcion = "Asistencia/validar_registro_asistencia";

		if( $configuracion['camara'] == 't'){ $opcion = "Asistencia/validar_registro_asistencia_camara"; }
		$this->form_validation->set_error_delimiters('','');
		if( !$this->form_validation->run($opcion) ){

			$mensaje_modal =	array(
							'clase' => "danger",
							'titulo' => "Alerta",
							'mensaje' => 'A ocurrido un inconveniente, favor intente nuevamente'
						);
			$this->session->set_flashdata('mensaje_modal',json_encode( $mensaje_modal,JSON_UNESCAPED_UNICODE) );
			redirect('Asistencia');
		}else{
			$datos['trabajador_id'] = $this->input->post('trabajador_id');
			$datos['fecha'] = date('d-m-Y');
			$datos['hora'] = date('h:i:s');
			$datos['tipo_registro'] = $this->input->post('tipo_registro');
			if( !empty( $_POST['observaciones'] ) ) $datos['observaciones'] = $this->input->post('observaciones');

			if( $configuracion['camara'] == 't'){$datos['imagen'] = $this->input->post('img');}

			$add = $this->Asistencia_M->registrar_asistencia($datos);
			if( $add ){
				$mensaje_modal =	array(
					'clase' => "success",
					'titulo' => "Registrado",
					'mensaje' => 'Se proceso su registro de '.$this->input->post('tipo_registro').' satisfactoriamente'
				);
			}else{
				$mensaje_modal =	array(
					'clase' => "danger",
					'titulo' => "Error",
					'mensaje' => 'Ocurrio un inconveniente al momento de intentar registrar su '.$this->input->post('tipo_registro').', favor intente nuevamente'
				);}
			$this->session->set_flashdata('mensaje_modal',json_encode( $mensaje_modal,JSON_UNESCAPED_UNICODE) );
			redirect('Asistencia');
		}

	}

	/**
	 * Funcion para consultar la cedula en el formulario de asistencia
	 *
	 * -- BLOQUEO EN CASO DE TENER EL DIA REGISTRADO (ENTRADA-SALIDA)
	 * @return [type] [description]
	 */
	public function consultar_cedula(){
		$consulta = $this->formato;
		// $cedula = '21535233';
		$cedula = $this->input->post('cedula');
		if( is_null($cedula) ){ echo json_encode( $consulta, JSON_UNESCAPED_UNICODE );}
		else{
			$datos = $this->Asistencia_M->consultar_cedula($cedula);
			if( !is_null($datos) ){
				$consulta['consulta'] = TRUE;
				$consulta['cedula'] = $datos['cedula'];
				$consulta['apellidos'] = $datos['apellidos'];
				$consulta['nombres'] = $datos['nombres'];
				$consulta['cargo'] = $datos['cargo'];
				$consulta['coordinacion'] = $datos['coordinacion'];
				$consulta['condicion_laboral'] = $datos['condicion_laboral'];
				$consulta['bloqueo'] = $datos['bloqueo'];
				$consulta['fecha'] = $datos['fecha'];
				$consulta['tipo_registro'] = $datos['tipo_registro'];
				$consulta['trabajador_id'] = $datos['id_trabajador'];
			}
			echo json_encode( $consulta, JSON_UNESCAPED_UNICODE );
		}
	}

	public function consultar_cedula_manual(){
		$consulta = $this->formato;
		// $cedula = '21535233';
		$cedula = $this->input->post('cedula');
		if( is_null($cedula) ){ echo json_encode( $consulta, JSON_UNESCAPED_UNICODE );}
		else{
			$datos = $this->Asistencia_M->consultar_cedula($cedula);
			if( !is_null($datos) ){
				$consulta['consulta'] = TRUE;
				$consulta['cedula'] = $datos['cedula'];
				$consulta['apellidos'] = $datos['apellidos'];
				$consulta['nombres'] = $datos['nombres'];
				$consulta['cargo'] = $datos['cargo'];
				$consulta['coordinacion'] = $datos['coordinacion'];
				$consulta['condicion_laboral'] = $datos['condicion_laboral'];
				if( $datos['bloqueo'] && is_null($datos['fecha']) ){
					$consulta['bloqueo'] = FALSE;
				}else{$consulta['bloqueo'] = $datos['bloqueo'];}
				// $consulta['bloqueo'] = $datos['bloqueo'];
				$consulta['fecha'] = $datos['fecha'];
				$consulta['tipo_registro'] = $datos['tipo_registro'];
				$consulta['trabajador_id'] = $datos['id_trabajador'];
			}
			echo json_encode( $consulta, JSON_UNESCAPED_UNICODE );
		}

	}

	/**
	 * Funcion para obtener los ultimos registros de asistencia, funcion utilizada en el formulario de asistencia publico a traves de AJAX
	 * @return [type] [description]
	 */
	public function ultimos_registros(){
		$consulta = $this->Asistencia_M->ultimos_registros();
		if( is_null($consulta)){
			echo json_encode( $consulta, JSON_UNESCAPED_UNICODE );
		}else{
			echo $consulta;
		}

	}

	/**
	 * Funcion para obtener la configuracion del sistema via AJAX, funcion utilziada pen el formulario de registro de asistencia publico
	 * @return [type] [description]
	 */
	public function obtener_configuracion(){
		$configuracion = $this->Configuraciones_M->consultar_lista(true);
		if(count($configuracion)<=0) return NULL;
		echo json_encode( $configuracion[0], JSON_UNESCAPED_UNICODE );
	}

	/**
	 * Funcion para cargar el formulario de registro de asistencia manual
	 * @return [type] [description]
	 */
	public function registro_manual(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Asistencia';
		$datos['titulo_descripcion'] = 'Registro Manual';
		$datos['form_action'] = 'Asistencia/validar_registro_manual';
		$datos['contenido'] = 'asistencia/asistencia_manual_form';

		$configuracion = $this->Configuraciones_M->consultar_lista(true);
		$datos['configuracion'] = json_encode($configuracion[0]);

		$mensaje_modal = 'null';
		if( $this->session->has_userdata('mensaje_modal') ){$mensaje_modal = $_SESSION['mensaje_modal'];}
		$datos['mensaje_modal'] = $mensaje_modal;

		$datos['e_footer'][] = array('nombre' => 'SayCheese JS','path' => base_url('assets/say-cheese/say-cheese.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'WickedPicker Timer JS','path' => base_url('assets/wickedpicker/src/wickedpicker.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'WickedPicker Timer JS','path' => base_url('assets/wickedpicker/stylesheets/wickedpicker.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Config Form JS','path' => base_url('assets/js/asistencia/v_asistencia_manual_form.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	/**
	 * Funcion para validar los datos provenientes del formulario de registro de asistencia manual
	 * @return [type] [description]
	 */
	public function validar_registro_manual(){
		if( count($this->input->post()) < 5) redirect(__CLASS__);

		$configuracion = $this->Configuraciones_M->consultar_lista(true);
		$configuracion = $configuracion[0];
		$mensaje_modal = array();
		$opcion = "Asistencia/validar_registro_asistencia_manual";

		if( $configuracion['camara'] == 't'){ $opcion = "Asistencia/validar_registro_asistencia_manual_camara"; }

		$this->form_validation->set_error_delimiters('','');
		if( !$this->form_validation->run($opcion) ){
			$mensaje_modal =	array(
							'clase' => "danger",
							'titulo' => "Alerta",
							'mensaje' => 'A ocurrido un inconveniente,favor intente nuevamente'
						);
			$this->session->set_flashdata('mensaje_modal',json_encode( $mensaje_modal,JSON_UNESCAPED_UNICODE) );
			redirect('Asistencia/registro_manual');
		}else{
			$datos['trabajador_id'] = $this->input->post('trabajador_id');
			$datos['fecha'] = $this->input->post('fecha');
			$datos['hora'] = date('H:i:s',strtotime( str_replace(' ','',$this->input->post('hora')) ));
			$datos['tipo_registro'] = $this->input->post('tipo_registro');
			$datos['manual'] = true;

			if( $configuracion['camara'] == 't'){$datos['imagen'] = $this->input->post('imagen');}

			$check_day = $this->Asistencia_M->validar_registro_manual_fecha($datos['trabajador_id'],$datos['fecha'],$datos['tipo_registro']);
			if(!$check_day){
				$mensaje_modal =	array(
							'clase' => "danger",
							'titulo' => "Alerta",
							'mensaje' => 'Ocurrio un inconveniente en el registro de la asistencia debido a que ya existen registros para este día '.$datos['fecha'].", favor intente nuevamente con otra fecha."
						);
				$this->session->set_flashdata('mensaje_modal',json_encode( $mensaje_modal,JSON_UNESCAPED_UNICODE) );
				redirect('Asistencia/registro_manual');
			}

			$add = $this->Asistencia_M->registrar_asistencia($datos);
			if( $add ){
				$mensaje_modal =	array(
					'clase' => "success",
					'titulo' => "Registrado",
					'mensaje' => 'Se proceso su registro de '.$this->input->post('tipo_registro').' satisfactoriamente'
				);
			}else{
				$mensaje_modal =	array(
					'clase' => "danger",
					'titulo' => "Error",
					'mensaje' => 'Ocurrio un inconveniente al momento de intentar registrar su '.$this->input->post('tipo_registro').', favor intente nuevamente'
				);}
			$this->session->set_flashdata('mensaje_modal',json_encode( $mensaje_modal,JSON_UNESCAPED_UNICODE) );
			redirect('Asistencia/registro_manual');
		}
	}

	function consultar_registro(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		
		$datos['titulo_contenedor'] = 'Asistencia';
		$datos['titulo_descripcion'] = 'Consultar registro';
		$datos['form_action'] = 'Asistencia/validar_registro_manual';
		$datos['contenido'] = 'asistencia/consultar_registro_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Additional Method','path' => base_url('assets/jqueryvalidate/dist/additional-methods.js'), 'ext' =>'js');
		
		$datos['e_footer'][] = array('nombre' => 'Config Form JS','path' => base_url('assets/js/asistencia/v_consultar_registro.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function detalles_registro(){
		$datos = NULL;
		if( !isset($_POST['id_registro']) ) echo json_encode($datos,JSON_UNESCAPED_UNICODE);
		
		$id_registro = $this->input->post('id_registro');
		$consulta = $this->Asistencia_M->consultar_registro_unico($id_registro);

		echo json_encode($consulta,JSON_UNESCAPED_UNICODE);
	}

	public function ajax_consultar_registros_dia(){
		$datos = NULL;
		if( !isset($_POST['fecha']) ) {
			echo json_encode($datos,JSON_UNESCAPED_UNICODE);
		}else{
			$fecha = $this->input->post('fecha');
			$consulta = $this->Asistencia_M->registros_asistencia_por_fecha($fecha);

			echo json_encode($consulta,JSON_UNESCAPED_UNICODE);
		}

	}

	public function ajax_desactivar_registro_dia(){
		$datos = NULL;
		if( !isset($_POST['id_registro']) ) {
			echo json_encode($datos,JSON_UNESCAPED_UNICODE);
		}else{
			$id_registro = $this->input->post('id_registro');
			$consulta = $this->Asistencia_M->desactivar_registro_unico($id_registro);

			echo json_encode($consulta,JSON_UNESCAPED_UNICODE);
		}

	}

}
