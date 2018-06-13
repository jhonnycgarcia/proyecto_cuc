<?php 

//VALIDACION SIMPLE HE INDIVIDUAL A TRAVES DE ARRAY
		$config = array(

			'Login/validar_ingreso' => array(
								array(
									'field' => 'usuario',
									'label' => '<b>Usuario</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'contraseña',
									'label' => '<b>Contraseña</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
								),
// -----------------------------------------------------------------------------------------------------------
			'Menu/validar_agregar' => array(
								array(
									'field' => 'menu',
									'label' => '<b>Nombre</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'link',
									'label' => '<b>Link</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'icono',
									'label' => '<b>Icono</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'posicion',
									'label' => '<b>Posición</b>',
									'rules' => 'trim|required|is_natural|strip_tags|xss_clean'
									),
								array(
									'field' => 'rol_menu[]',
									'label' => '<b>Roles</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
								),
			'Menu/validar_editar' => array(
								array(
									'field' => 'menu',
									'label' => '<b>Nombre</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'link',
									'label' => '<b>Link</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'icono',
									'label' => '<b>Icono</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'posicion',
									'label' => '<b>Posición</b>',
									'rules' => 'trim|required|is_natural|strip_tags|xss_clean'
									),
								array(
									'field' => 'rol_menu[]',
									'label' => '<b>Roles</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'id_menu',
									'label' => '<b>id</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
								),
// -----------------------------------------------------------------------------------------------------------
			'Roles/validar_agregar' => array(
								array(
									'field' => 'rol',
									'label' => '<b>Rol</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'descripcion',
									'label' => '<b>Descripción</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									)
								),
			'Roles/validar_editar' => array(
								array(
									'field' => 'rol',
									'label' => '<b>Rol</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'descripcion',
									'label' => '<b>Descripción</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									),
								array(
									'field' => 'id',
									'label' => '<b>Id</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
								),
// -----------------------------------------------------------------------------------------------------------
			'Direccion/validar_agregar' => array(
								array(
									'field' => 'direccion',
									'label' => '<b>Dirección</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'descripcion',
									'label' => '<b>Descripción</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									)
								),
			'Direccion/validar_editar' => array(
								array(
									'field' => 'direccion',
									'label' => '<b>Dirección</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'descripcion',
									'label' => '<b>Descripción</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									)
								),
// -----------------------------------------------------------------------------------------------------------
			'Coordinacion/validar_agregar' => array(
								array(
									'field' => 'coordinacion',
									'label' => '<b>Coordinación</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'descripcion',
									'label' => '<b>Descripción</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									)
								),
			'Coordinacion/validar_editar' => array(
								array(
									'field' => 'coordinacion',
									'label' => '<b>Coordinación</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'descripcion',
									'label' => '<b>Descripción</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									)
								),
// -----------------------------------------------------------------------------------------------------------
			'Condicion_laboral/validar_agregar' => array(
								array(
									'field' => 'condicion_laboral',
									'label' => '<b>Condicion Laboral</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
								),
			'Condicion_laboral/validar_editar' => array(
								array(
									'field' => 'condicion_laboral',
									'label' => '<b>Condicion Laboral</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
								),
// -----------------------------------------------------------------------------------------------------------
			'Cargos/validar_agregar' => array(
								array(
									'field' => 'cargo',
									'label' => '<b>Cargo</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
								),
			'Cargos/validar_editar' => array(
								array(
									'field' => 'cargo',
									'label' => '<b>Cargo</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
								),
// -----------------------------------------------------------------------------------------------------------
			'Persona/validar_agregar' => array(
								array(
									'field' => 'p_apellido',
									'label' => '<b>Primer Apellido</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[3]'
									),
								array(
									'field' => 's_apellido',
									'label' => '<b>Primer Apellido</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									),
								array(
									'field' => 'p_nombre',
									'label' => '<b>Primer Nombre</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[3]'
									),
								array(
									'field' => 's_nombre',
									'label' => '<b>Primer Nombre</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									),
								array(
									'field' => 'cedula',
									'label' => '<b>Cedula</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|is_natural_no_zero|callback_check_cedula'
									),
								array(
									'field' => 'fecha_nacimiento',
									'label' => '<b>Fecha Nacimiento</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'email',
									'label' => '<b>Email</b>',
									'rules' => 'trim|strip_tags|xss_clean|valid_email'
									),
								array(
									'field' => 'telefono_1',
									'label' => '<b>Telefono Principal</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|exact_length[14]'
									),
								array(
									'field' => 'telefono_2',
									'label' => '<b>Telefono Secundario</b>',
									'rules' => 'trim|strip_tags|xss_clean|exact_length[14]'
									),
								array(
									'field' => 'direccion',
									'label' => '<b>Dirección</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								),
			'Persona/validar_editar' => array(
								array(
									'field' => 'p_apellido',
									'label' => '<b>Primer Apellido</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[3]'
									),
								array(
									'field' => 's_apellido',
									'label' => '<b>Primer Apellido</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									),
								array(
									'field' => 'p_nombre',
									'label' => '<b>Primer Nombre</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[3]'
									),
								array(
									'field' => 's_nombre',
									'label' => '<b>Primer Nombre</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									),
								array(
									'field' => 'cedula',
									'label' => '<b>Cedula</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|is_natural_no_zero'
									),
								array(
									'field' => 'fecha_nacimiento',
									'label' => '<b>Fecha Nacimiento</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'email',
									'label' => '<b>Email</b>',
									'rules' => 'trim|strip_tags|xss_clean|valid_email'
									),
								array(
									'field' => 'telefono_1',
									'label' => '<b>Telefono Principal</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|exact_length[14]'
									),
								array(
									'field' => 'telefono_2',
									'label' => '<b>Telefono Secundario</b>',
									'rules' => 'trim|strip_tags|xss_clean|exact_length[14]'
									),
								array(
									'field' => 'direccion',
									'label' => '<b>Dirección</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
								),
// -----------------------------------------------------------------------------------------------------------
			'Trabajadores/validar_ingresar' => array(
								array(
									'field' => 'fecha_ingreso',
									'label' => '<b>Fecha de ingreso</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[9]|max_length[10]'
									),
								array(
									'field' => 'dato_personal_id',
									'label' => '<b>Dato personal</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|callback_check_persona_na'
									)
							),
			'Trabajadores/validar_egresar' => array(
								array(
									'field' => 'fecha_egreso',
									'label' => '<b>Fecha de Egreso</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[9]|max_length[10]'
									),
								array(
									'field' => 'id_trabajador',
									'label' => '<b>Dato Trabajador</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'dato_personal_id',
									'label' => '<b>Dato personal</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
							),
			'Trabajadores/validar_editar' => array(
								array(
									'field' => 'asistencia_obligatoria',
									'label' => '<b>Fecha de Egreso</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'id_trabajador',
									'label' => '<b>Dato Trabajador</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'dato_personal_id',
									'label' => '<b>Dato personal</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
							),
// -----------------------------------------------------------------------------------------------------------
			'Configuraciones/validar_agregar' => array(
								array(
									'field' => 'tiempo_max_inactividad',
									'label' => '<b>Tiempo maximo de inactividad</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[4]|is_natural_no_zero'
									),
								array(
									'field' => 'tiempo_max_alerta',
									'label' => '<b>Tiempo maximo de alerta</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[4]|is_natural_no_zero'
									),
								array(
									'field' => 'tiempo_max_espera',
									'label' => '<b>Tiempo maximo de espera</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[4]|is_natural_no_zero'
									),
								array(
									'field' => 'dias_laborales[]',
									'label' => '<b>Dias Laborales</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|is_natural_no_zero'
									)
							),
			'Configuraciones/validar_editar' => array(
								array(
									'field' => 'tiempo_max_inactividad',
									'label' => '<b>Tiempo maximo de inactividad</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[4]|is_natural_no_zero'
									),
								array(
									'field' => 'tiempo_max_alerta',
									'label' => '<b>Tiempo maximo de alerta</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[4]|is_natural_no_zero'
									),
								array(
									'field' => 'tiempo_max_espera',
									'label' => '<b>Tiempo maximo de espera</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[4]|is_natural_no_zero'
									),
								array(
									'field' => 'dias_laborales[]',
									'label' => '<b>Dias Laborales</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|is_natural_no_zero'
									)
							),
// -----------------------------------------------------------------------------------------------------------
			'Usuarios/validar_asignar' => array(
								array(
									'field' => 'usuario',
									'label' => '<b>Usuario</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[5]|callback_check_usuario'
									),
								array(
									'field' => 'clave',
									'label' => '<b>Clave</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[5]|max_length[12]'
									),
								array(
									'field' => 're_clave',
									'label' => '<b>Clave</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[5]|max_length[12]|matches[clave]'
									)
							),
			'Usuarios/validar_actualizar_clave' => array(
								array(
									'field' => 'clave_actual',
									'label' => '<b>Clave Actual</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[5]|callback_check_clave_actual'
									),
								array(
									'field' => 'clave_nueva',
									'label' => '<b>Clave Nueva</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[5]|max_length[12]|differs[clave_actual]'
									),
								array(
									'field' => 're_clave',
									'label' => '<b>Confirmar Clave</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[5]|max_length[12]|matches[clave_nueva]'
									)
							),
			'Usuarios/validar_restablecer_clave' => array(
								array(
									'field' => 'clave_nueva',
									'label' => '<b>Clave Nueva</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[5]|max_length[12]'
									),
								array(
									'field' => 're_clave',
									'label' => '<b>Confirmar Clave</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[5]|max_length[12]|matches[clave_nueva]'
									)
							),
// -----------------------------------------------------------------------------------------------------------
			'Asistencia/validar_registro_asistencia_camara' => array(
								array(
									'field' => 'img',
									'label' => "<b>Imagen</b>",
									'rules' => 'trim|required'
									),
								array(
									'field' => 'cedula',
									'label' => '<b>Cedula</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[7]|max_length[8]'
									),
								array(
									'field' => 'tipo_registro',
									'label' => '<b>Tipo Registro</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'trabajador_id',
									'label' => '<b>Trabajador</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
							),
			'Asistencia/validar_registro_asistencia' => array(
								array(
									'field' => 'cedula',
									'label' => '<b>Cedula</b>',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[7]|max_length[8]'
									),
								array(
									'field' => 'tipo_registro',
									'label' => '<b>Tipo Registro</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'trabajador_id',
									'label' => '<b>Trabajador</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
							),
			'Asistencia/validar_registro_asistencia_manual' => array(
								array(
									'field' => 'hora',
									'label' => 'Hora',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'fecha',
									'label' => 'Fecha',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'tipo_registro',
									'label' => 'Tipo Registro',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'trabajador_id',
									'label' => 'Trabajador',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'observaciones',
									'label' => 'Observaciones',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[5]'
									)
							),
			'Asistencia/validar_registro_asistencia_manual_camara' => array(
								array(
									'field' => 'imagen',
									'label' => "Imagen",
									'rules' => 'trim|required'
									),
								array(
									'field' => 'hora',
									'label' => 'Hora',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'fecha',
									'label' => 'Fecha',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'tipo_registro',
									'label' => 'Tipo Registro',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'trabajador_id',
									'label' => 'Trabajador',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'observaciones',
									'label' => 'Observaciones',
									'rules' => 'trim|required|strip_tags|xss_clean|min_length[5]'
									)
							),
// -----------------------------------------------------------------------------------------------------------
			'Reportes/registros_asistencia1' => array(
								array(
									'field' => 'fdesde',
									'label' => "<b>Fecha desde</b>",
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'fhasta',
									'label' => "<b>Fecha hasta</b>",
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
							),
			'Reportes/registros_asistencia2' => array(
								array(
									'field' => 'fdesde',
									'label' => "<b>Fecha desde</b>",
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'fhasta',
									'label' => "<b>Fecha hasta</b>",
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'cargos_excluidos[]',
									'label' => "<b>Cargos a excluir</b>",
									'rules' => 'trim|strip_tags|xss_clean|is_natural'
									),
							),
			'Reportes/reporte_horas_extras1' => array(
								array(
									'field' => 'fecha',
									'label' => "<b>Fechas</b>",
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
							),
			'Reportes/reporte_horas_extras2' => array(
								array(
									'field' => 'fecha',
									'label' => "<b>Fechas</b>",
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'cargos_excluidos[]',
									'label' => "<b>Cargos a excluir</b>",
									'rules' => 'trim|strip_tags|xss_clean|is_natural'
									),
							)

		);

		