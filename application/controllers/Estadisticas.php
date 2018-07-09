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
		if(!$this->seguridad_lib->login_in(FALSE) ){ echo json_encode(NULL);
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



	public function ajax_cargar_datos_tb_trabajadores()
	{
		$fecha = date('d-m-Y');
		$datos = array(
			'fecha' => $fecha
			, 'apellidos_nombres'=> NULL
			, 'hentrada'=> '00:00:00'
			, 'hsalida'=> '00:00:00'
			, 'coordinacion'=> NULL
			, 'direccion'=> NULL);
		if(!$this->seguridad_lib->login_in(FALSE) ){ echo json_encode(NULL);
		}else{
			$this->load->model("Reportes_M");
			$nro_registros = $this->Reportes_M->nro_registros_asistencia_fechas($fecha,$fecha);

			if( $nro_registros>0){
				$trabajadores = $this->Reportes_M->registros_asistencia_por_fecha($fecha);
				echo json_encode($trabajadores,JSON_UNESCAPED_UNICODE);
			}else{
				echo json_encode(NULL);
			}
		}
	}

	public function informacion_direcciones(){
		$datos['contenido'] = 'estadisticas/estadisticas_informacion_direcciones';

		$datos['e_footer'][] = array('nombre' => 'Chart JS','path' => base_url('assets/Chart.js/Chart.bundle.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Informacion General JS','path' => base_url('assets/js/estadisticas/estadisticas_informacion_direcciones.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}


	public function ajax_informacion_general_direcciones()
	{

		$datos = array(
			'nro_trabajadores' => 0
			,'nro_trabajadores_ao' => 0
			// # Asistencias
			,'nro_asistencias' => 0
			,'por_asistencias' => 0
			// # Inasistencias
			,'nro_inasistencias' => 0
			,'por_inasistencias' => 0
			// # Horas requeridas
			,'nro_horas_requeridas' => '00:00:00'
			,'int_horas_requeridas' => 0
			,'por_horas_requeridas' => 0
			// # Horas trabajadas
			,'nro_horas_trabajadas' => '00:00:00'
			,'int_horas_trabajadas' => 0
			,'por_horas_trabajadas' => 0
			// # Horas faltantes para cumplir las requeridas
			,'nro_horas_faltantes' => '00:00:00'
			,'int_horas_faltantes' => 0
			,'por_horas_faltantes' => 0
			// # Horas trabajadas dentro de la jornada laboral
			,'nro_horas_trabajadas_djornada' => '00:00:00'
			,'int_horas_trabajadas_djornada' => 0
			,'por_horas_trabajadas_djornada' => 0
			// # Horas trabajadas fuera del horario de la jornada labora
			,'nro_horas_trabajadas_fjornada' => '00:00:00'
			,'int_horas_trabajadas_fjornada' => 0
			,'por_horas_trabajadas_fjornada' => 0
			// # Horas faltantes de la joranda laboral
			,'nro_horas_jornada_faltantes' => '00:00:00'
			,'int_horas_jornada_faltantes' => 0
			,'por_horas_jornada_faltantes' => 0
			// # Horas extras
			,'nro_horas_extras' => '00:00:00'
			,'int_horas_extras' => 0
			,'por_horas_extras' => 0
			// Datos para la vista dinamica 
			,'st_asistencia' => '0,0'
			,'st_desempeno' => '0,0,0'
			// ,'st_desempeno' => '0,0,0,0,0,0,0'
		);


		if( isset($_POST['mes']) AND isset($_POST['ano']) ){
			$mes = $_POST['mes'];
			$ano = $_POST['ano'];
		}else{
			// $mes = '05';
			$mes = date('m');
			// $ano = '2018';
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

			$nro_horas_requeridas = $this->Estadisticas_M->nro_horas_requeridas_por_mes_ano_direccion($mes,$ano,$value_dir['id_direccion']);
			$int_horas_requeridas = $this->Estadisticas_M->int_horas_requeridas_por_mes_ano_direccion($mes,$ano,$value_dir['id_direccion']);
			$por_horas_requeridas = ($int_horas_requeridas>0) ? 100 : 0;

			$nro_horas_trabajadas = $this->Estadisticas_M->nro_horas_trabajadas_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$int_horas_trabajadas = $this->Estadisticas_M->int_horas_trabajadas_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$por_horas_trabajadas = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_trabajadas/$int_horas_requeridas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_faltantes = $this->Estadisticas_M->nro_horas_faltantes_por_mes_ano_direccion($mes,$ano,$value_dir['id_direccion']);
			$int_horas_faltantes = $this->Estadisticas_M->int_horas_faltantes_por_mes_ano_direccion($mes,$ano,$value_dir['id_direccion']);
			$por_horas_faltantes = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_faltantes/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_trabajadas_djornada = $this->Estadisticas_M->nro_horasd_jornada_trabajadas_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$int_horas_trabajadas_djornada = $this->Estadisticas_M->int_horasd_jornada_trabajadas_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$por_horas_trabajadas_djornada = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_trabajadas_djornada/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_trabajadas_fjornada = $this->Estadisticas_M->nro_horasf_jornada_trabajadas_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$int_horas_trabajadas_fjornada = $this->Estadisticas_M->int_horasf_jornada_trabajadas_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$por_horas_trabajadas_fjornada = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_trabajadas_fjornada/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_jornada_faltantes = $this->Estadisticas_M->nro_horas_jornada_faltantes_por_mes_ano_direccion($mes,$ano,$value_dir['id_direccion']);
			$int_horas_jornada_faltantes = $this->Estadisticas_M->int_horas_jornada_faltantes_por_mes_ano_direccion($mes,$ano,$value_dir['id_direccion']);
			$por_horas_jornada_faltantes = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_jornada_faltantes/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_extras = $this->Estadisticas_M->nro_horas_horas_extras_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$int_horas_extras = $this->Estadisticas_M->int_horas_horas_extras_por_mes_ano_direcion($mes,$ano,$value_dir['id_direccion']);
			$por_horas_extras = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_extras/$int_horas_trabajadas)*100) ,0,PHP_ROUND_HALF_DOWN)
				: 0;

			$direcciones[$key_dir]['nro_trabajadores'] = $nro_trabajadores;
			$direcciones[$key_dir]['nro_trabajadores_ao'] = $nro_trabajadores_ao;
			$direcciones[$key_dir]['nro_asistencias'] = $nro_asistencias;
			$direcciones[$key_dir]['nro_inasistencias'] = $nro_inasistencias;
			$direcciones[$key_dir]['nro_horas_requeridas'] = $nro_horas_requeridas;
			$direcciones[$key_dir]['int_horas_requeridas'] = $int_horas_requeridas;
			$direcciones[$key_dir]['por_horas_requeridas'] = $por_horas_requeridas;
			$direcciones[$key_dir]['nro_horas_trabajadas'] = $nro_horas_trabajadas;
			$direcciones[$key_dir]['int_horas_trabajadas'] = $int_horas_trabajadas;
			$direcciones[$key_dir]['por_horas_trabajadas'] = $por_horas_trabajadas;
			$direcciones[$key_dir]['nro_horas_faltantes'] = $nro_horas_faltantes;
			$direcciones[$key_dir]['int_horas_faltantes'] = $int_horas_faltantes;
			$direcciones[$key_dir]['por_horas_faltantes'] = $por_horas_faltantes;
			$direcciones[$key_dir]['nro_horas_trabajadas_djornada'] = $nro_horas_trabajadas_djornada;
			$direcciones[$key_dir]['int_horas_trabajadas_djornada'] = $int_horas_trabajadas_djornada;
			$direcciones[$key_dir]['por_horas_trabajadas_djornada'] = $por_horas_trabajadas_djornada;
			$direcciones[$key_dir]['nro_horas_trabajadas_fjornada'] = $nro_horas_trabajadas_fjornada;
			$direcciones[$key_dir]['int_horas_trabajadas_fjornada'] = $int_horas_trabajadas_fjornada;
			$direcciones[$key_dir]['por_horas_trabajadas_fjornada'] = $por_horas_trabajadas_fjornada;
			$direcciones[$key_dir]['nro_horas_jornada_faltantes'] = $nro_horas_jornada_faltantes;
			$direcciones[$key_dir]['int_horas_jornada_faltantes'] = $int_horas_jornada_faltantes;
			$direcciones[$key_dir]['por_horas_jornada_faltantes'] = $por_horas_jornada_faltantes;
			$direcciones[$key_dir]['nro_horas_extras'] = $nro_horas_extras;
			$direcciones[$key_dir]['int_horas_extras'] = $int_horas_extras;
			$direcciones[$key_dir]['por_horas_extras'] = $por_horas_extras;

			if($por_horas_trabajadas > 0){
				$direcciones[$key_dir]['st_desempeno'] = 
					// $por_horas_requeridas
					// .','.$por_horas_trabajadas
					$por_horas_trabajadas
					.','.$por_horas_faltantes
					.','.$por_horas_extras;
			}

			if($nro_asistencias>0 ||$nro_inasistencias>0){
				$total_registros = ($nro_asistencias+$nro_inasistencias);
				$por_asistencias = round((($nro_asistencias/$total_registros)*100),0,PHP_ROUND_HALF_DOWN);
				$por_inasistencias = round((($nro_inasistencias/$total_registros)*100),0,PHP_ROUND_HALF_DOWN);
				$direcciones[$key_dir]['por_asistencias'] = $por_asistencias;
				$direcciones[$key_dir]['por_inasistencias'] = $por_inasistencias;
				$direcciones[$key_dir]['st_asistencia'] = $por_inasistencias.','.$por_asistencias;
			}
		}

		echo json_encode($direcciones,JSON_UNESCAPED_UNICODE);
	}

	public function informacion_coordinaciones(){
		$datos['contenido'] = 'estadisticas/estadisticas_informacion_coordinaciones';

		$datos['e_footer'][] = array('nombre' => 'Chart JS','path' => base_url('assets/Chart.js/Chart.bundle.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Informacion General JS','path' => base_url('assets/js/estadisticas/estadisticas_informacion_coordinaciones.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}


	public function ajax_informacion_general_coordinaciones()
	{

		$datos = array(
			'nro_trabajadores' => 0
			,'nro_trabajadores_ao' => 0
			// # Asistencias
			,'nro_asistencias' => 0
			,'por_asistencias' => 0
			// # Inasistencias
			,'nro_inasistencias' => 0
			,'por_inasistencias' => 0
			// # Horas requeridas
			,'nro_horas_requeridas' => '00:00:00'
			,'int_horas_requeridas' => 0
			,'por_horas_requeridas' => 0
			// # Horas trabajadas
			,'nro_horas_trabajadas' => '00:00:00'
			,'int_horas_trabajadas' => 0
			,'por_horas_trabajadas' => 0
			// # Horas faltantes para cumplir las requeridas
			,'nro_horas_faltantes' => '00:00:00'
			,'int_horas_faltantes' => 0
			,'por_horas_faltantes' => 0
			// # Horas trabajadas dentro de la jornada laboral
			,'nro_horas_trabajadas_djornada' => '00:00:00'
			,'int_horas_trabajadas_djornada' => 0
			,'por_horas_trabajadas_djornada' => 0
			// # Horas trabajadas fuera del horario de la jornada labora
			,'nro_horas_trabajadas_fjornada' => '00:00:00'
			,'int_horas_trabajadas_fjornada' => 0
			,'por_horas_trabajadas_fjornada' => 0
			// # Horas faltantes de la joranda laboral
			,'nro_horas_jornada_faltantes' => '00:00:00'
			,'int_horas_jornada_faltantes' => 0
			,'por_horas_jornada_faltantes' => 0
			// # Horas extras
			,'nro_horas_extras' => '00:00:00'
			,'int_horas_extras' => 0
			,'por_horas_extras' => 0
			// Datos para la vista dinamica 
			,'st_asistencia' => '0,0'
			,'st_desempeno' => '0,0,0'
			// ,'st_desempeno' => '0,0,0,0,0,0,0'
		);


		if( isset($_POST['mes']) AND isset($_POST['ano']) ){
			$mes = $_POST['mes'];
			$ano = $_POST['ano'];
		}else{
			// $mes = '05';
			$mes = date('m');
			// $ano = '2018';
			$ano = date('Y');
		}

		$this->load->model("Coordinacion_M");
		$coordinaciones = $this->Coordinacion_M->consultar_lista(TRUE);
		foreach ($coordinaciones as $key_cor => $value_cor) {
			$coordinaciones[$key_cor] += $datos;

			$nro_trabajadores = $this->Estadisticas_M->nro_total_trabajadores_por_coordinacion($value_cor['id_coordinacion']);

			$nro_trabajadores_ao = $this->Estadisticas_M->nro_total_trabajadores_por_coordinacion($value_cor['id_coordinacion'],TRUE);

			$nro_asistencias = $this->Estadisticas_M->nro_registros_asistencia_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$nro_inasistencias = $this->Estadisticas_M->nro_registros_inasistencia_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);

			$nro_horas_requeridas = $this->Estadisticas_M->nro_horas_requeridas_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$int_horas_requeridas = $this->Estadisticas_M->int_horas_requeridas_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$por_horas_requeridas = ($int_horas_requeridas>0) ? 100 : 0;

			$nro_horas_trabajadas = $this->Estadisticas_M->nro_horas_trabajadas_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$int_horas_trabajadas = $this->Estadisticas_M->int_horas_trabajadas_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$por_horas_trabajadas = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_trabajadas/$int_horas_requeridas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_faltantes = $this->Estadisticas_M->nro_horas_faltantes_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$int_horas_faltantes = $this->Estadisticas_M->int_horas_faltantes_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$por_horas_faltantes = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_faltantes/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_trabajadas_djornada = $this->Estadisticas_M->nro_horasd_jornada_trabajadas_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$int_horas_trabajadas_djornada = $this->Estadisticas_M->int_horasd_jornada_trabajadas_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$por_horas_trabajadas_djornada = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_trabajadas_djornada/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_trabajadas_fjornada = $this->Estadisticas_M->nro_horasf_jornada_trabajadas_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$int_horas_trabajadas_fjornada = $this->Estadisticas_M->int_horasf_jornada_trabajadas_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$por_horas_trabajadas_fjornada = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_trabajadas_fjornada/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_jornada_faltantes = $this->Estadisticas_M->nro_horas_jornada_faltantes_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$int_horas_jornada_faltantes = $this->Estadisticas_M->int_horas_jornada_faltantes_por_mes_ano_coordinacion_id($mes,$ano,$value_cor['id_coordinacion']);
			$por_horas_jornada_faltantes = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_jornada_faltantes/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_extras = $this->Estadisticas_M->nro_horas_horas_extras_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);
			$int_horas_extras = $this->Estadisticas_M->int_horas_horas_extras_por_mes_ano_coordinacion($mes,$ano,$value_cor['id_coordinacion']);

			$por_horas_extras = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_extras/$int_horas_trabajadas)*100) ,0,PHP_ROUND_HALF_DOWN)
				: 0;

			$coordinaciones[$key_cor]['nro_trabajadores'] = $nro_trabajadores;
			$coordinaciones[$key_cor]['nro_trabajadores_ao'] = $nro_trabajadores_ao;
			$coordinaciones[$key_cor]['nro_asistencias'] = $nro_asistencias;
			$coordinaciones[$key_cor]['nro_inasistencias'] = $nro_inasistencias;
			$coordinaciones[$key_cor]['nro_horas_requeridas'] = $nro_horas_requeridas;
			$coordinaciones[$key_cor]['int_horas_requeridas'] = $int_horas_requeridas;
			$coordinaciones[$key_cor]['por_horas_requeridas'] = $por_horas_requeridas;
			$coordinaciones[$key_cor]['nro_horas_trabajadas'] = $nro_horas_trabajadas;
			$coordinaciones[$key_cor]['int_horas_trabajadas'] = $int_horas_trabajadas;
			$coordinaciones[$key_cor]['por_horas_trabajadas'] = $por_horas_trabajadas;
			$coordinaciones[$key_cor]['nro_horas_faltantes'] = $nro_horas_faltantes;
			$coordinaciones[$key_cor]['int_horas_faltantes'] = $int_horas_faltantes;
			$coordinaciones[$key_cor]['por_horas_faltantes'] = $por_horas_faltantes;
			$coordinaciones[$key_cor]['nro_horas_trabajadas_djornada'] = $nro_horas_trabajadas_djornada;
			$coordinaciones[$key_cor]['int_horas_trabajadas_djornada'] = $int_horas_trabajadas_djornada;
			$coordinaciones[$key_cor]['por_horas_trabajadas_djornada'] = $por_horas_trabajadas_djornada;
			$coordinaciones[$key_cor]['nro_horas_trabajadas_fjornada'] = $nro_horas_trabajadas_fjornada;
			$coordinaciones[$key_cor]['int_horas_trabajadas_fjornada'] = $int_horas_trabajadas_fjornada;
			$coordinaciones[$key_cor]['por_horas_trabajadas_fjornada'] = $por_horas_trabajadas_fjornada;
			$coordinaciones[$key_cor]['nro_horas_jornada_faltantes'] = $nro_horas_jornada_faltantes;
			$coordinaciones[$key_cor]['int_horas_jornada_faltantes'] = $int_horas_jornada_faltantes;
			$coordinaciones[$key_cor]['por_horas_jornada_faltantes'] = $por_horas_jornada_faltantes;
			$coordinaciones[$key_cor]['nro_horas_extras'] = $nro_horas_extras;
			$coordinaciones[$key_cor]['int_horas_extras'] = $int_horas_extras;
			$coordinaciones[$key_cor]['por_horas_extras'] = $por_horas_extras;

			if($por_horas_trabajadas > 0){
				$coordinaciones[$key_cor]['st_desempeno'] =
					// $por_horas_requeridas
					// .','.$por_horas_trabajadas
					$por_horas_trabajadas
					.','.$por_horas_faltantes
					.','.$por_horas_extras;
			}

			if($nro_asistencias>0 ||$nro_inasistencias>0){
				$total_registros = ($nro_asistencias+$nro_inasistencias);
				$por_asistencias = round((($nro_asistencias/$total_registros)*100),0,PHP_ROUND_HALF_DOWN);
				$por_inasistencias = round((($nro_inasistencias/$total_registros)*100),0,PHP_ROUND_HALF_DOWN);
				$coordinaciones[$key_cor]['por_asistencias'] = $por_asistencias;
				$coordinaciones[$key_cor]['por_inasistencias'] = $por_inasistencias;
				$coordinaciones[$key_cor]['st_asistencia'] = $por_inasistencias.','.$por_asistencias;
			}
		}

		echo json_encode($coordinaciones,JSON_UNESCAPED_UNICODE);
	}


	public function informacion_trabajadores(){
		$datos['contenido'] = 'estadisticas/estadisticas_informacion_trabajadores';

		$datos['e_footer'][] = array('nombre' => 'Chart JS','path' => base_url('assets/Chart.js/Chart.bundle.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'DatePicker JS','path' => base_url('assets/AdminLTE/plugins/datepicker/bootstrap-datepicker.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DatePicker Languaje JS','path' => base_url('assets/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.es.js'), 'ext' =>'js');
		$datos['e_header'][] = array('nombre' => 'DatePicker CSS','path' => base_url('assets/AdminLTE/plugins/datepicker/datepicker3.css'), 'ext' =>'css');

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');

		$datos['e_footer'][] = array('nombre' => 'Informacion General JS','path' => base_url('assets/js/estadisticas/estadisticas_informacion_trabajadores.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	public function ajax_informacion_general_trabajadores()
	{

		$datos = array(
			// # Asistencias
			'nro_asistencias' => 0
			,'por_asistencias' => 0
			// # Inasistencias
			,'nro_inasistencias' => 0
			,'por_inasistencias' => 0
			// # Horas requeridas
			,'nro_horas_requeridas' => '00:00:00'
			,'int_horas_requeridas' => 0
			,'por_horas_requeridas' => 0
			// # Horas trabajadas
			,'nro_horas_trabajadas' => '00:00:00'
			,'int_horas_trabajadas' => 0
			,'por_horas_trabajadas' => 0
			// # Horas faltantes para cumplir las requeridas
			,'nro_horas_faltantes' => '00:00:00'
			,'int_horas_faltantes' => 0
			,'por_horas_faltantes' => 0
			// # Horas trabajadas dentro de la jornada laboral
			,'nro_horas_trabajadas_djornada' => '00:00:00'
			,'int_horas_trabajadas_djornada' => 0
			,'por_horas_trabajadas_djornada' => 0
			// # Horas trabajadas fuera del horario de la jornada labora
			,'nro_horas_trabajadas_fjornada' => '00:00:00'
			,'int_horas_trabajadas_fjornada' => 0
			,'por_horas_trabajadas_fjornada' => 0
			// # Horas faltantes de la joranda laboral
			,'nro_horas_jornada_faltantes' => '00:00:00'
			,'int_horas_jornada_faltantes' => 0
			,'por_horas_jornada_faltantes' => 0
			// # Horas extras
			,'nro_horas_extras' => '00:00:00'
			,'int_horas_extras' => 0
			,'por_horas_extras' => 0
			// Datos para la vista dinamica 
			,'st_asistencia' => '0,0'
			,'st_desempeno' => '0,0,0'
			// ,'st_desempeno' => '0,0,0,0,0,0,0'
		);


		if( isset($_POST['mes']) AND isset($_POST['ano']) ){
			$mes = $_POST['mes'];
			$ano = $_POST['ano'];
		}else{
			$mes = '05';
			// $mes = date('m');
			$ano = '2018';
			// $ano = date('Y');
		}

		$this->load->model("Trabajadores_M");
		$trabajadores = $this->Trabajadores_M->consultar_lista(TRUE);
		foreach ($trabajadores as $key_tra => $value_tra) {
			$trabajadores[$key_tra] += $datos;


			$nro_asistencias = $this->Estadisticas_M->nro_registros_asistencia_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$nro_inasistencias = $this->Estadisticas_M->nro_registros_inasistencia_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);

			$nro_horas_requeridas = $this->Estadisticas_M->nro_horas_requeridas_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$int_horas_requeridas = $this->Estadisticas_M->int_horas_requeridas_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$por_horas_requeridas = ($int_horas_requeridas>0) ? 100 : 0;

			$nro_horas_trabajadas = $this->Estadisticas_M->nro_horas_trabajadas_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$int_horas_trabajadas = $this->Estadisticas_M->int_horas_trabajadas_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$por_horas_trabajadas = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_trabajadas/$int_horas_requeridas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_faltantes = $this->Estadisticas_M->nro_horas_faltantes_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$int_horas_faltantes = $this->Estadisticas_M->int_horas_faltantes_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$por_horas_faltantes = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_faltantes/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_trabajadas_djornada = $this->Estadisticas_M->nro_horasd_jornada_trabajadas_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$int_horas_trabajadas_djornada = $this->Estadisticas_M->int_horasd_jornada_trabajadas_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$por_horas_trabajadas_djornada = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_trabajadas_djornada/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_trabajadas_fjornada = $this->Estadisticas_M->nro_horasf_jornada_trabajadas_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$int_horas_trabajadas_fjornada = $this->Estadisticas_M->int_horasf_jornada_trabajadas_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$por_horas_trabajadas_fjornada = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_trabajadas_fjornada/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_jornada_faltantes = $this->Estadisticas_M->nro_horas_jornada_faltantes_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$int_horas_jornada_faltantes = $this->Estadisticas_M->int_horas_jornada_faltantes_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$por_horas_jornada_faltantes = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_jornada_faltantes/$int_horas_trabajadas)*100) ,2,PHP_ROUND_HALF_DOWN)
				: 0;

			$nro_horas_extras = $this->Estadisticas_M->nro_horas_horas_extras_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);
			$int_horas_extras = $this->Estadisticas_M->int_horas_horas_extras_por_mes_ano_trabajador($mes,$ano,$value_tra['id_trabajador']);

			$por_horas_extras = ($int_horas_trabajadas>0 && $int_horas_requeridas>0)
				? round( ( ($int_horas_extras/$int_horas_trabajadas)*100) ,0,PHP_ROUND_HALF_DOWN)
				: 0;

			$trabajadores[$key_tra]['nro_asistencias'] = $nro_asistencias;
			$trabajadores[$key_tra]['nro_inasistencias'] = $nro_inasistencias;
			$trabajadores[$key_tra]['nro_horas_requeridas'] = $nro_horas_requeridas;
			$trabajadores[$key_tra]['int_horas_requeridas'] = $int_horas_requeridas;
			$trabajadores[$key_tra]['por_horas_requeridas'] = $por_horas_requeridas;
			$trabajadores[$key_tra]['nro_horas_trabajadas'] = $nro_horas_trabajadas;
			$trabajadores[$key_tra]['int_horas_trabajadas'] = $int_horas_trabajadas;
			$trabajadores[$key_tra]['por_horas_trabajadas'] = $por_horas_trabajadas;
			$trabajadores[$key_tra]['nro_horas_faltantes'] = $nro_horas_faltantes;
			$trabajadores[$key_tra]['int_horas_faltantes'] = $int_horas_faltantes;
			$trabajadores[$key_tra]['por_horas_faltantes'] = $por_horas_faltantes;
			$trabajadores[$key_tra]['nro_horas_trabajadas_djornada'] = $nro_horas_trabajadas_djornada;
			$trabajadores[$key_tra]['int_horas_trabajadas_djornada'] = $int_horas_trabajadas_djornada;
			$trabajadores[$key_tra]['por_horas_trabajadas_djornada'] = $por_horas_trabajadas_djornada;
			$trabajadores[$key_tra]['nro_horas_trabajadas_fjornada'] = $nro_horas_trabajadas_fjornada;
			$trabajadores[$key_tra]['int_horas_trabajadas_fjornada'] = $int_horas_trabajadas_fjornada;
			$trabajadores[$key_tra]['por_horas_trabajadas_fjornada'] = $por_horas_trabajadas_fjornada;
			$trabajadores[$key_tra]['nro_horas_jornada_faltantes'] = $nro_horas_jornada_faltantes;
			$trabajadores[$key_tra]['int_horas_jornada_faltantes'] = $int_horas_jornada_faltantes;
			$trabajadores[$key_tra]['por_horas_jornada_faltantes'] = $por_horas_jornada_faltantes;
			$trabajadores[$key_tra]['nro_horas_extras'] = $nro_horas_extras;
			$trabajadores[$key_tra]['int_horas_extras'] = $int_horas_extras;
			$trabajadores[$key_tra]['por_horas_extras'] = $por_horas_extras;

			if($por_horas_trabajadas > 0){
				$trabajadores[$key_tra]['st_desempeno'] =
					// $por_horas_requeridas
					// .','.$por_horas_trabajadas
					$por_horas_trabajadas
					.','.$por_horas_faltantes
					.','.$por_horas_extras;
			}

			if($nro_asistencias>0 ||$nro_inasistencias>0){
				$total_registros = ($nro_asistencias+$nro_inasistencias);
				$por_asistencias = round((($nro_asistencias/$total_registros)*100),0,PHP_ROUND_HALF_DOWN);
				$por_inasistencias = round((($nro_inasistencias/$total_registros)*100),0,PHP_ROUND_HALF_DOWN);
				$trabajadores[$key_tra]['por_asistencias'] = $por_asistencias;
				$trabajadores[$key_tra]['por_inasistencias'] = $por_inasistencias;
				$trabajadores[$key_tra]['st_asistencia'] = $por_inasistencias.','.$por_asistencias;
			}
		}

		echo json_encode($trabajadores,JSON_UNESCAPED_UNICODE);
	}


}