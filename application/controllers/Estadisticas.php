<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadisticas extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Estadisticas_M');
	}

	public function index()
	{
		$this->informacion_general();
	}

	/**
	 * Funcion para cargar vista con la informacion general 
	 * @return [type] [description]
	 */
	public function informacion_general(){
		// $datos['titulo_contenedor'] = 'Información';
		// $datos['titulo_descripcion'] = 'Lista del personal';
		$datos['contenido'] = 'estadisticas/estadisticas_informacion_general';

		$this->load->model(array('Direccion_M','Coordinacion_M'));
		$datos['direcciones'] = $this->Direccion_M->obtener_todos(TRUE);
		$datos['coordinaciones'] = $this->Coordinacion_M->consultar_lista(TRUE);

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Informacion General JS','path' => base_url('assets/js/estadisticas/estadisticas_informacion_general.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function informacion_direcciones(){
		$datos['contenido'] = 'estadisticas/estadisticas_informacion_direcciones';

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Informacion General JS','path' => base_url('assets/js/estadisticas/estadisticas_informacion_direcciones.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	/**
	 * Funcion para cargar los datos generales a traves de AJAX 
	 * @return [type] [description]
	 */
	public function ajax_cargar_datos_generales(){
		$datos = array(
			'nro_personas'=>0
			,'nro_trabajadores'=>0
			,'nro_direcciones'=>0
			,'nro_coordinaciones'=>0
		);
		if( !$this->seguridad_lib->login_in(FALSE) ){ echo json_encode($datos);
		}else{
			$this->load->model(array('Trabajadores_M','Direccion_M','Coordinacion_M','Persona_M'));
			$nro_trabajadores = count($this->Trabajadores_M->consultar_lista(TRUE));
			$nro_direcciones = count($this->Direccion_M->obtener_todos(TRUE));
			$nro_coordinaciones = count($this->Coordinacion_M->consultar_lista(TRUE));
			$nro_personas = count($this->Persona_M->consultar_lista(TRUE));

			$datos['nro_trabajadores'] = $nro_trabajadores;
			$datos['nro_direcciones'] = $nro_direcciones;
			$datos['nro_coordinaciones'] = $nro_coordinaciones;
			$datos['nro_personas'] = $nro_personas;
			echo json_encode($datos);
		}


	}

	/**
	 * Funcion para cargar el numero de registros de asistencia e inasistencia para la fecha actual a traves de AJAX
	 * @param  [type] $fecha [description]
	 * @return [type]        [description]
	 */
	public function ajax_cargas_nro_registros_asistencia_fecha($fecha = NULL){
		$fecha = date('d-m-Y');
		$datos = array('nro_asistencias'=>0,'nro_inasistencias'=>0);
		if ( is_null($fecha) || !$this->seguridad_lib->login_in(FALSE) ) {
			echo json_encode($datos);
		}else{
			$this->load->model(array('Reportes_M'));

			$nro_asistencias = $this->Estadisticas_M->nro_registros_asistencia_por_fecha($fecha);
			$nro_inasistencias = $this->Estadisticas_M->nro_registros_inasistencia_fechas($fecha);

			$datos['nro_asistencias'] = $nro_asistencias;
			$datos['nro_inasistencias'] = $nro_inasistencias;
			echo json_encode($datos);
		}
	}

	/**
	 * Funcion para rellenar la tabla de Control de Asistencia por Direcciones
	 * @return [type] [description]
	 */
	public function ajax_cargar_datos_tb_direcciones(){
		$fecha = date('d-m-Y');
		$datos = array('nro_asistencias' => 0
			, 'nro_inasistencias'=>0
			, 'nro_total_trabajadores'=>0
			,'porcentaje' => 0);
		if(!$this->seguridad_lib->login_in(FALSE) ){ echo json_encode(array(NULL));
		}else{
			$this->load->model(array('Direccion_M'));
			$direcciones = $this->Direccion_M->obtener_todos(TRUE);
			foreach ($direcciones as $key_dir => $value_dir) {
				$direcciones[$key_dir] += $datos;
				$porcentaje = 0;

				$nro_total_trabajadores = $this->Estadisticas_M->nro_total_trabajadores_por_direccion($value_dir['id_direccion'],TRUE);
				$nro_asistencias = $this->Estadisticas_M->nro_registros_asistencia_por_fecha_direccion($fecha,$value_dir['id_direccion']);
				$nro_inasistencias = $this->Estadisticas_M->nro_registros_inasistencia_por_fecha_direccion($fecha,$value_dir['id_direccion']);

				if($nro_asistencias >0){
					$porcentaje = ($nro_asistencias/$nro_total_trabajadores)*100;
				}

				$direcciones[$key_dir]['nro_total_trabajadores'] = $nro_total_trabajadores;
				$direcciones[$key_dir]['nro_asistencias'] = $nro_asistencias;
				$direcciones[$key_dir]['nro_inasistencias'] = $nro_inasistencias;
				$direcciones[$key_dir]['porcentaje'] = $porcentaje;
			}
			echo json_encode($direcciones,JSON_UNESCAPED_UNICODE);
		};
	}


	public function ajax_cargar_datos_tb_coordinaciones()
	{
		$fecha = date('d-m-Y');
		$datos = array('nro_asistencias' => 0
			, 'nro_inasistencias'=>0
			, 'nro_total_trabajadores'=>0
			,'porcentaje' => 0);
		if(!$this->seguridad_lib->login_in(FALSE) || !isset($_POST['direccion_id']) ){ echo json_encode(NULL);
		}else{
			// $direccion_id = '1';
			$direccion_id = $_POST['direccion_id'];
			$this->load->model('Coordinacion_M');
			$coordinaciones = $this->Coordinacion_M->obtener_coordinaciones_por_direcciones($direccion_id,TRUE);
			foreach ($coordinaciones as $key_cor => $value_cor) {
				$coordinaciones[$key_cor] += $datos;
				$porcentaje = 0;

				$nro_total_trabajadores = $this->Estadisticas_M->nro_total_trabajadores_por_coordinacion($value_cor['id_coordinacion'],TRUE);
				$nro_asistencias = $this->Estadisticas_M->nro_registros_asistencia_por_fecha_coordinacion($fecha,$value_cor['id_coordinacion']);
				$nro_inasistencias = $this->Estadisticas_M->nro_registros_inasistencia_por_fecha_coordinacion($fecha,$value_cor['id_coordinacion']);

				if($nro_asistencias >0){
					$porcentaje = ($nro_asistencias/$nro_total_trabajadores)*100;
				}


				$coordinaciones[$key_cor]['nro_total_trabajadores'] = $nro_total_trabajadores;
				$coordinaciones[$key_cor]['nro_asistencias'] = $nro_asistencias;
				$coordinaciones[$key_cor]['nro_inasistencias'] = $nro_inasistencias;
				$coordinaciones[$key_cor]['porcentaje'] = $porcentaje;
			}
			echo json_encode($coordinaciones,JSON_UNESCAPED_UNICODE);
		}
	}

	public function ajax_informacion_general_direcciones()
	{

		$datos = array(
			'nro_trabajadores' => 0
			,'nro_trabajadores_ao' => 0
			,'nro_asistencias' => 0
			,'porc_asistencias' => 0
			,'nro_inasistencias' => 0
			,'porc_inasistencias' => 0
			,'nro_horas_trabajadas' => 0
			,'nro_horas_jornada_trabajadas' => 0
			,'nro_horas_jornada_faltantes' => 0
			,'nro_horas_extras' => 0
		);


		if( isset($_POST['mes']) AND isset($_POST['ano']) ){
			$mes = $_POST['mes'];
			$ano = $_POST['ano'];
		}else{
			$mes = date('m');
			$ano = date('Y');
		}

		$this->load->model("Direccion_M");
		$direcciones = $this->Direccion_M->obtener_todos(TRUE);
		foreach ($direcciones as $key_dir => $value_dir) {
			$direcciones[$key_dir] += $datos;

			$nro_trabajadores = $this->Estadisticas_M->nro_total_trabajadores_por_direccion($value_dir['id_direccion']);
			$nro_trabajadores_ao = $this->Estadisticas_M->nro_total_trabajadores_por_direccion($value_dir['id_direccion'],TRUE);
			$nro_asistencias = $this->Estadisticas_M->nro_registros_asistencia_por_mes_ano_direccion($mes,$ano,$value_dir['id_direccion']);
			$nro_inasistencias = $this->Estadisticas_M->nro_registros_inasistencia_por_mes_ano_direccion($mes,$ano,$value_dir['id_direccion']);
			$nro_horas_trabajadas = $this->Estadisticas_M->nro_horas_trabajadas_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$nro_horas_jornada_trabajadas = $this->Estadisticas_M->nro_horas_jornada_trabajadas_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$nro_horas_jornada_faltantes = $this->Estadisticas_M->nro_horas_jornada_faltantes_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$nro_horas_extras = $this->Estadisticas_M->nro_horas_horas_extras_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);

			$direcciones[$key_dir]['nro_trabajadores'] = $nro_trabajadores;
			$direcciones[$key_dir]['nro_trabajadores_ao'] = $nro_trabajadores_ao;
			$direcciones[$key_dir]['nro_asistencias'] = $nro_asistencias;
			$direcciones[$key_dir]['nro_inasistencias'] = $nro_inasistencias;
			$direcciones[$key_dir]['nro_horas_trabajadas'] = $nro_horas_trabajadas;
			$direcciones[$key_dir]['nro_horas_jornada_trabajadas'] = $nro_horas_jornada_trabajadas;
			$direcciones[$key_dir]['nro_horas_jornada_faltantes'] = $nro_horas_jornada_faltantes;
			$direcciones[$key_dir]['nro_horas_extras'] = $nro_horas_extras;
		}

		echo json_encode($direcciones,JSON_UNESCAPED_UNICODE);
	}


}