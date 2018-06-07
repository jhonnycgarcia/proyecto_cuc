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

			if( is_null($datos) ){
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
		$datos['contenido'] = 'reportes/consulta_asistencia_form';

		$datos['form_action'] = 'Reportes/registros_inasistencia';

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/datepicker/dist/js/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/datepicker/dist/locales/bootstrap-datepicker.es.min.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/datepicker/dist/css/bootstrap-datepicker3.min.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Config Form JS','path' => base_url('assets/js/reportes/v_consultar_asistencia_form.js'), 'ext' =>'js');

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

			if( is_null($datos) ){
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

}