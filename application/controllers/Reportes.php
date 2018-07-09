<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Reportes_M');
	}

	public function index()
	{
		$this->load->view('errors');
	}

	/**
	 * Funcion para cargar el formulario de consulta de registros de asistencia
	 * @return [type] [description]
	 */
	public function consultar_asistencia()
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Reportes';
		$datos['titulo_descripcion'] = 'Consultar asistencia';
		$datos['contenido'] = 'reportes/consulta_asistencia_form';

		$datos['form_action'] = 'Reportes/registros_asistencia';

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/datepicker/dist/js/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/datepicker/dist/locales/bootstrap-datepicker.es.min.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/datepicker/dist/css/bootstrap-datepicker3.min.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Config Form JS','path' => base_url('assets/js/reportes/v_consultar_asistencia_form.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	/**
	 * Funcion para crear el reporte de registros de asistencia
	 * @return [type] [description]
	 */
	public function registros_asistencia()
	{
		if(count($this->input->post()) == 0 ) echo '<script>window.close();</script>';
		$opcion = "Reportes/registros_asistencia1";
		if( array_key_exists('cargos_excluidos', $this->input->post() ) ) $opcion = "Reportes/registros_asistencia2";

		if( !$this->form_validation->run($opcion) ){
			$error = validation_errors();
			echo '<script language="javascript">
						alert("Ocurrio un inconveniente al momento de validar los datos del formulario debido favor intente nuevamente ");
						window.close();
					</script>';
		}else{
			$fdesde = $this->input->post('fdesde');
			$fhasta = $this->input->post('fhasta');

			if( array_key_exists('cargos_excluidos', $this->input->post() ) ){
				$excluidos = $this->input->post('cargos_excluidos');
			}else{ $excluidos = array(); }

			$datos = $this->Reportes_M->registros_asistencia($fdesde,$fhasta,$excluidos);

			if( is_null($datos) || count($datos) <=0 ){
				echo '<script language="javascript">
						alert("En rango de fechas seleccionadas no posee registros de asistencia, favor intente nuevamente");
						window.close();
					</script>';
			}else{

				$this->load->view('reportes/reporte_asistencia',array('datos'=>$datos));
			}
		}
	}

	/**
	 * Funcion para cargar el formulario de consulta de inasistencias
	 * @return [type] [description]
	 */
	public function consultar_inasistencia()
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Reportes';
		$datos['titulo_descripcion'] = 'Consultar inasistencia';
		$datos['contenido'] = 'reportes/consulta_inasistencia_form';

		$datos['form_action'] = 'Reportes/registros_inasistencia';

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/datepicker/dist/js/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/datepicker/dist/locales/bootstrap-datepicker.es.min.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/datepicker/dist/css/bootstrap-datepicker3.min.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Config Form JS','path' => base_url('assets/js/reportes/v_consultar_inasistencia_form.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	/**
	 * Funcion para generar el reporte de inasistencias
	 * @return [type] [description]
	 */
	public function registros_inasistencia()
	{
		if(count($this->input->post()) == 0 ) echo '<script>window.close();</script>';
		$opcion = "Reportes/registros_asistencia1";
		if( array_key_exists('cargos_excluidos', $this->input->post() ) ) $opcion = "Reportes/registros_asistencia2";

		if( !$this->form_validation->run($opcion) ){
			$error = validation_errors();
			echo '<script language="javascript">
						alert("Ocurrio un inconveniente al momento de validar los datos del formulario debido favor intente nuevamente ");
						window.close();
					</script>';
		}else{
			$fdesde = $this->input->post('fdesde');
			$fhasta = $this->input->post('fhasta');

			if( array_key_exists('cargos_excluidos', $this->input->post() ) ){
				$excluidos = $this->input->post('cargos_excluidos');
			}else{ $excluidos = array(); }

			$datos = $this->Reportes_M->registros_inasistencia($fdesde,$fhasta,$excluidos);

			if( is_null($datos) || count($datos)<=0 ){
				echo '<script language="javascript">
						alert("En rango de fechas seleccionadas no se encontraron registros de inasistencias, favor intente nuevamente");
						window.close();
					</script>';
			}else{

				$this->load->view('reportes/reporte_inasistencia',array('datos'=>$datos));
			}
		}
	}

	/**
	 * Funcion para cargar formulario de consulta de horas extras
	 * @return [type] [description]
	 */
	public function consultar_horas_extras()
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Reportes';
		$datos['titulo_descripcion'] = 'Consultar horas extras';
		$datos['contenido'] = 'reportes/consulta_horas_extras_form';

		$datos['form_action'] = 'Reportes/reporte_horas_extras';

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/datepicker/dist/js/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/datepicker/dist/locales/bootstrap-datepicker.es.min.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/datepicker/dist/css/bootstrap-datepicker3.min.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Config Form JS','path' => base_url('assets/js/reportes/v_consultar_horas_extras_form.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function reporte_horas_extras()
	{
		if(count($this->input->post()) == 0 ) echo '<script>window.close();</script>';
		$opcion = "Reportes/reporte_horas_extras1";
		if( array_key_exists('cargos_excluidos', $this->input->post() ) ) $opcion = "Reportes/reporte_horas_extras2";

		header("HTTP/1.1 404 Not Found"); 

		if( !$this->form_validation->run($opcion) ){
			$error = validation_errors();
			echo '<script language="javascript">
						alert("Ocurrio un inconveniente al momento de validar los datos del formulario debido favor intente nuevamente ");
						window.close();
					</script>';
		}else{
			$fecha = $this->input->post('fecha');

			if( array_key_exists('cargos_excluidos', $this->input->post() ) ){
				$excluidos = $this->input->post('cargos_excluidos');
			}else{ $excluidos = array(); }

			$datos = $this->Reportes_M->registro_horas_extras($fecha,$excluidos);

			if( is_null($datos) ){
				echo '<script language="javascript">
						alert("Para la fecha seleccionada no se consiguieron registros de horas extras, favor intente nuevamente");
						window.close();
					</script>';
			}else{

				$this->load->view('reportes/reporte_horas_extras',array('datos'=>$datos));
			}
		}
	}

	/**
	 * Funcion para generar informe detallado de una persona
	 * @param  INTEGER $id [description]
	 * @return [type]     [description]
	 */
	public function consultar_persona_informe($id = NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$id  = $this->seguridad_lib->execute_encryp($id,'decrypt',"Persona");
		$this->load->model('Persona_M');
		$persona = $this->Persona_M->consultar_persona($id);
		if(is_null($persona)){
			$merror['title'] = 'Error';
			$merror['text'] = 'No se encontro el registro deseado, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect("Persona");
		}else{
			$this->load->model('Trabajadores_M');
			$persona += array(
				'historial'=> $this->Trabajadores_M->obtener_historial_trabajador($persona['id_dato_personal'])
			);
			$this->load->view("reportes/reporte_persona_informe",array("datos"=>$persona));
		}
	}

	/**
	 * Funcion para generar un reporte general de todos los trabajadores organizado desde direcciones, coordinaciones y trabajadores
	 * @return [type] [description]
	 */
	public function reporte_general_trabajadores()
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$this->load->model(array('Direccion_M','Coordinacion_M','Trabajadores_M'));
		$direcciones = $this->Direccion_M->obtener_todos(TRUE);
		if( count($direcciones) > 0){
			foreach ($direcciones as $key_dir => $value_dir) {
				$direcciones[$key_dir] += array('coordinaciones'=>NULL
										, 'nro_coordinaciones'=>0
										, 'nro_trabajadores_total'=>0);

				$coordinaciones = $this->Coordinacion_M->obtener_coordinaciones_por_direcciones($value_dir['id_direccion'],TRUE);
				if(count($coordinaciones)>0){
					$direcciones[$key_dir]['nro_coordinaciones'] = $direcciones[$key_dir]['nro_coordinaciones'] + count($coordinaciones);
					foreach ($coordinaciones as $key_cor => $value_cor) {
						$coordinaciones[$key_cor] += array('trabajadores' => NULL, 'nro_trabajadores' => 0);
						$trabajadores = $this->Trabajadores_M->obtener_trabajadores_por_coordinacion($value_cor['id_coordinacion']);
						$coordinaciones[$key_cor]['trabajadores'] =  $trabajadores;
						$coordinaciones[$key_cor]['nro_trabajadores'] = $coordinaciones[$key_cor]['nro_trabajadores']+count($trabajadores);
						$direcciones[$key_dir]['nro_trabajadores_total'] = $direcciones[$key_dir]['nro_trabajadores_total']+count($trabajadores);
					}
				}

				$direcciones[$key_dir]['coordinaciones'] = $coordinaciones;
				// var_export($direcciones[$key_dir]);echo "<br><br>";
			}
			// exit();
			$this->load->view('reportes/reporte_trabajadores_general',array('datos'=>$direcciones));
		}else{
			$merror['title'] = 'Error';
			$merror['text'] = 'No se encontraron registros de trabajadores';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect("Trabajadores");
		}

	}

}