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

	public function validar_registro_asistencia(){
		if( count($this->input->post()) < 3) redirect(__CLASS__);

		$configuracion = $this->Configuraciones_M->consultar_lista(true);
		$configuracion = $configuracion[0];
		$mensaje_modal = array();
		$opcion = "Asistencia/validar_registro_asistencia";

		if( $configuracion['camara'] == 't'){ $opcion = "validar_registro_asistencia_camara"; }

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

	public function ultimos_registros(){
		$consulta = $this->Asistencia_M->ultimos_registros();
		if( is_null($consulta)){
			echo json_encode( $consulta, JSON_UNESCAPED_UNICODE );
		}else{
			echo $consulta;
		}

	}

	public function obtener_configuracion(){
		$configuracion = $this->Configuraciones_M->consultar_lista(true);
		if(count($configuracion)<=0) return NULL;
		echo json_encode( $configuracion[0], JSON_UNESCAPED_UNICODE );
	}

}
