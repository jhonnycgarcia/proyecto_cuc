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
									'rules' => 'trim|required|strip_tags|xss_clean|alpha_numeric'
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
									'rules' => 'trim|required|strip_tags|xss_clean|alpha_numeric'
									),
								),
		);

		