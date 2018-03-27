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
			'Roles/validar_agregar' => array(
								array(
									'field' => 'rol',
									'label' => '<b>Rol</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									),
								array(
									'field' => 'descripcion',
									'label' => '<b>Descripcion</b>',
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
									'label' => '<b>Descripcion</b>',
									'rules' => 'trim|strip_tags|xss_clean'
									),
								array(
									'field' => 'id',
									'label' => '<b>Id</b>',
									'rules' => 'trim|required|strip_tags|xss_clean'
									)
								),
		);

		