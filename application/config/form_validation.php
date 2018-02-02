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
		);

		