<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header text-center">MODULOS</li>
<?php
  $this->load->helper('menu');
  $cgp = $this->load->database('cgp',TRUE);


  // Obtener todos los sistemas
  $sistemas = $cgp->select()
  				->from('seguridad.sistemas AS a')
  				->order_by('a.sistema_posicion','ASC')->get()->result_array();

  	if( count($sistemas) > 0 ){

  		foreach ($sistemas as $key_sistemas => $value_sistemas) { // recorrer todos los sistemas
  			
  			// buscar registros padres
  			$m_padres = $cgp->select()
  						->from('seguridad.menu AS a')
  						->where( array('a.estatus' => '1', 'a.sistema_id' => $value_sistemas['id_sistemas'], 'a.padre' => '0') )
  						->order_by('a.posicion','ASC')->get()->result_array();

  			if( count($m_padres) > 0 ){ // tiene registros MENU_PADRES

  				echo "<li class='active treeview'>\n" 
  					."\t<a href='#'>"
  						.validar_tipo_icono( $value_sistemas['sistema_icono'] )
  						."<span>".strtoupper( $value_sistemas['descripcion'] )."</span>"
  						."<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>"
  					."</a>\n"
  					."<ul class='treeview-menu'>";

  				foreach ($m_padres as $key_m_padres => $value_m_padres) { // recorrer por todos los registros padres
  					
  					// buscar registros hijos
  					$m_hijos = $cgp->select()
                              ->from('seguridad.menu AS a')
                              ->where( array('a.estatus' => '1', 'a.padre' => $value_m_padres['id']) )
                              ->order_by('a.posicion','ASC')->get()->result_array();


                    if( count($m_hijos) > 0 ){ // tiene registros MENU_HIJOS

                    	$v_icono = obtener_icono($value_m_padres,false); // validar que tipo de icono tiene
		                echo "<li class='treeview'>\n"
                          .$v_icono
                          ."<ul class='treeview-menu'>\n";

                        foreach ($m_hijos as $key_m_hijos => $value_m_hijos) { // recorrer por todos los registros hijos

							$v_icono = obtener_icono($value_m_hijos,true); // validar que tipo de icono tiene
							echo "<li class='treeview'>\n"
								.$v_icono
								."</li>\n";
                        }

                        echo "</ul>\n</li>\n";

                    }else{
						$v_icono = obtener_icono($value_m_padres,true); // validar que tipo de icono tiene

						echo "<li class='treeview'>\n"
							.$v_icono
							."</li>\n";
                    }
  				}

  				echo "</ul>"
  					."</li>\n";
  			}

  		}
  	}
?>