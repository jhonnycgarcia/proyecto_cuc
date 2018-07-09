<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper( array('form','security') );
		$this->load->library( array('form_validation') );
		$this->load->model('Usuarios_M');
	}

	public function index()
	{
		$this->lista();
	}

	/**
	 * Funcion para cargar vista del listado de usuarios del sistema
	 * @return [type] [description]
	 */
	public function lista(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Usuarios';
		$datos['titulo_descripcion'] = 'Lista de items';
		$datos['contenido'] = 'usuarios/usuarios_lista';

		$datos['e_footer'][] = array('nombre' => 'DataTable JS','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable BootStrap CSS','path' => base_url('assets/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'DataTable Language ES','path' => base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.es.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	/**
	 * Funcion para cargar el formulario de asignar usuario a trabajador
	 * @return [type] [description]
	 */
	public function asignar(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Usuarios';
		$datos['titulo_descripcion'] = 'Asignar';
		$datos['contenido'] = 'usuarios/usuarios_form';
		$datos['form_action'] = 'Usuarios/validar_asignar';

		$datos['trabajador_id'] = set_value('trabajador_id');
		$datos['usuario'] = set_value('usuario');
		$datos['clave'] = set_value('clave');
		$datos['re_clave'] = set_value('re_clave');
		$datos['rol_id'] = set_value('rol_id');
		$datos['id_usuario'] = set_value('id_usuario');

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/usuarios/v_usuarios_form.js'), 'ext' =>'js');
		
		$this->template_lib->render($datos);
	}

	/**
	 * Funcion de CALLBACK para validar que el usuario a asignar no se encuentre registrado
	 * @param  [type] $usuario [description]
	 * @return [type]          [description]
	 */
	public function check_usuario($usuario){
		$this->form_validation->set_message('check_usuario', 'El {field} ya se encuentra asignado');
		$consulta = $this->Usuarios_M->callback_check_usuario($usuario);
		return $consulta;
	}

	/**
	 * Funcion para validar los datos provenientes del formulario asignar usuario a trabajador
	 * @return [type] [description]
	 */
	public function validar_asignar(){
		if(count($this->input->post())==0) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$this->asignar();
		}else{
			$add = $this->Usuarios_M->asignar_usuario($this->input->post());
			if( $add ){ 
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se asigno el usuario satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}else{	
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo asignar el usuario, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}
		}
	}

	/**
	 * Funcion para consultar los detalles de un usuario
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function detalles($id = NULL)
	{
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if(!isset($id)) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);
		$usuario = $this->Usuarios_M->consultar_usuario($id);

		if(is_null($usuario)){
			$merror['title'] = 'Error';
			$merror['text'] = 'No se encontro el registro deseado, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);
		}else{
			$datos['titulo_contenedor'] = 'Usuario';
			$datos['titulo_descripcion'] = 'Detalles';
			$datos['contenido'] = 'usuarios/usuarios_detalles';
			$datos['usuario'] = $usuario;

			$this->template_lib->render($datos); }
	}

	/**
	 * Funcion para cargar el formulario de editar datos de un usuario
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function editar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if(!isset($id)) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);
		$usuario = $this->Usuarios_M->consultar_usuario($id);

		if(is_null($usuario)){
			$merror['title'] = 'Error';
			$merror['text'] = 'No se encontro el registro deseado, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);
		}else{
			$datos['titulo_contenedor'] = 'Usuario';
			$datos['titulo_descripcion'] = 'Editar';
			$datos['contenido'] = 'usuarios/usuarios_editar_form';
			$datos['form_action'] = 'Usuarios/validar_editar';
			$datos['btn_action'] = 'Actualizar';

			$datos['usuario'] = $usuario;
			$datos['rol_id'] = set_value('rol_id',$usuario['rol_id']);
			$datos['id_usuario'] = set_value('id_usuario',$usuario['id_usuario']);

			$this->template_lib->render($datos); }
	}

	/**
	 * Funcion para validar los datos provenientes del formulario editar usuario
	 * @return [type] [description]
	 */
	public function validar_editar(){
		if( count( $this->input->post() ) == 0 ) redirect(__CLASS__);

		$up = $this->Usuarios_M->editar_usuario($this->input->post());
		if( $up){
			$merror['title'] = 'Registrado';
			$merror['text'] = 'Se actualizaron los datos del usuario satisfactoriamente';
			$merror['type'] = 'success';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);
		}else{
			$merror['title'] = 'Error';
			$merror['text'] = 'No se actualizar los datos del usuario, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);
			}
	}

	/**
	 * Funcion para cargar el formulario de auto gestion de actualziar clave
	 * @return [type] [description]
	 */
	public function actualizar_clave(){
		$this->seguridad_lib->acceso_metodo(__METHOD__);

		$datos['titulo_contenedor'] = 'Usuario';
		$datos['titulo_descripcion'] = 'Actualizar contraseña';
		$datos['contenido'] = 'usuarios/usuarios_actualizar_clave_form';
		$datos['form_action'] = 'Usuarios/validar_actualizar_clave';
		$datos['btn_action'] = 'Actualizar';

		$datos['clave_actual'] = set_value('clave_actual');
		$datos['clave_nueva'] = set_value('clave_nueva');
		$datos['re_clave'] = set_value('re_clave');
		$datos['id_usuario'] = set_value('id_usuario',$this->session->userdata('id_usuario'));

		$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
		$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/usuarios/v_usuarios_actualizar_clave_form.js'), 'ext' =>'js');

		$this->template_lib->render($datos);
	}

	/**
	 * Funcion de CALLBACK para validar que la contraseña actual coincida
	 * @param  [type] $clave [description]
	 * @return [type]        [description]
	 */
	public function check_clave_actual($clave){
		$consulta = $this->Usuarios_M->callback_check_clave_actual($this->session->userdata('id_usuario'),do_hash( $clave.SEMILLA, 'md5' ));
		$this->form_validation->set_message('check_clave_actual', 'La {field} no coincide');
		return $consulta;
	}

	/**
	 * Funcion para validar los datos provenientes del formulario de auto gestion actualizar clave
	 * @return [type] [description]
	 */
	public function validar_actualizar_clave(){
		if(count($this->input->post())==0) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$this->actualizar_clave();
		}else{
			$datos['clave'] = do_hash( $this->input->post('clave_nueva').SEMILLA, 'md5' );
			$datos['id_usuario'] = $this->input->post('id_usuario');
			$up = $this->Usuarios_M->editar_usuario($datos);
			if( $up){
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se actualizo la clave del usuario satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}else{
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo actualizar la contraseña, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
				}
		}
	}

	/**
	 * Funcion para eliminar un usuario
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function eliminar($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);
		$usuario = $this->Usuarios_M->consultar_usuario($id);

		if(is_null($usuario)){
			$merror['title'] = 'Error';
			$merror['text'] = 'No se pudo realizar esta accion debido a que no se consiguio el registro deseado, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);
		}else{
			$delete = $this->Usuarios_M->eliminar_usuario($id);
			if($delete){
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se elimino el usuario satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}else{
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo llevar a cabo esta acción, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}
		}
	}

	/**
	 * Funcion para cargar la vista de restablecer la contraseña a un usuario en modo ADMINISTRADOR
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function restablecer_clave($id = NULL){
		$this->seguridad_lib->acceso_metodo(__METHOD__);
		if( !isset($id) ) redirect(__CLASS__);
		$id = $this->seguridad_lib->execute_encryp($id,'decrypt',__CLASS__);

		if(is_null($id)){
			$merror['title'] = 'Error';
			$merror['text'] = 'No se pudo llevar a cabo esta acción, favor intente nuevamente';
			$merror['type'] = 'error';
			$merror['confirmButtonText'] = 'Aceptar';
			$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
			redirect(__CLASS__);
		}else{
			$datos['titulo_contenedor'] = 'Usuario';
			$datos['titulo_descripcion'] = 'Restablecer contraseña';
			$datos['contenido'] = 'usuarios/usuarios_restablecer_clave_form';
			$datos['form_action'] = 'Usuarios/validar_restablecer_clave';
			$datos['btn_action'] = 'Restaurar';

			$datos['clave_nueva'] = set_value('clave_nueva');
			$datos['re_clave'] = set_value('re_clave');
			$datos['id_usuario'] = set_value('id_usuario',$id);

			$datos['e_footer'][] = array('nombre' => 'jQuery Validate','path' => base_url('assets/jqueryvalidate/dist/jquery.validate.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Language ES','path' => base_url('assets/jqueryvalidate/dist/localization/messages_es.js'), 'ext' =>'js');
			$datos['e_footer'][] = array('nombre' => 'jQuery Validate Function','path' => base_url('assets/js/usuarios/v_usuarios_restablecer_clave_form.js'), 'ext' =>'js');

			$this->template_lib->render($datos);
		}
	}

	/**
	 * Funcion para validar los datos provenientes dle formulario restablecer contraseña
	 * @return [type] [description]
	 */
	public function validar_restablecer_clave(){
		if(count($this->input->post())==0) redirect(__CLASS__);

		$this->form_validation->set_error_delimiters('<span>','</span>');
		if( !$this->form_validation->run() ){
			$this->actualizar_clave();
		}else{
			$datos['clave'] = do_hash( $this->input->post('clave_nueva').SEMILLA, 'md5' );
			$datos['id_usuario'] = $this->input->post('id_usuario');
			$up = $this->Usuarios_M->editar_usuario($datos);
			if( $up){
				$merror['title'] = 'Registrado';
				$merror['text'] = 'Se actualizaron la clave satisfactoriamente';
				$merror['type'] = 'success';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}else{
				$merror['title'] = 'Error';
				$merror['text'] = 'No se pudo actualizar la clave, favor intente nuevamente';
				$merror['type'] = 'error';
				$merror['confirmButtonText'] = 'Aceptar';
				$this->session->set_flashdata('merror', json_encode( $merror,JSON_UNESCAPED_UNICODE) );
				redirect(__CLASS__);
			}
		}
	}

}