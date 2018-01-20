<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
  <li class="header">Modulos</li>
<?php
  $this->load->helper('menu');
  $cgp = $this->load->database('cgp',TRUE);
  $id_usuario = $this->session->userdata('id_usuario');

  $contenedor = $cgp->select()->from('seguridad.contenedores')
              ->where( array('contenedor_estatus' => 't') )->order_by('contenedor_posicion','ASC')
              ->get()->result_array();

  if( count($contenedor) > 0 ):

    foreach ($contenedor as $key_contenedor => $value_contenedor) :

      /* Buscar los sistemas que pertenezcan a el contenedor*/
      $sistemas = $cgp->select("a.roles_id"
                 .",b.id_sistemas,b.sistema,b.descripcion,b.sistema_posicion,b.sistema_icono,b.contenedor_id")
                ->from("seguridad.roles_usuario_sistema AS a")
                  ->join("seguridad.sistemas AS b","a.sistema_id = b.id_sistemas")
                ->where( array('a.usuarios_id' => $id_usuario, 'b.contenedor_id' => $value_contenedor['id_contenedor']) )
                ->order_by('b.sistema_posicion','ASC')
                ->get()->result_array();

      if( count($sistemas) > 0 ):

        /* Imprimir etiqueta de contenedor*/
        echo "<li>"
        .anchor('#',
          "<i class='fa fa-circle-o text-aqua'></i>"
          ."<span>".$value_contenedor['contenedor_nombre']."</span>"
          ."<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>")
        ."<ul class='treeview-menu'>";

        foreach ($sistemas as $key_sistemas => $value_sistemas):
          
          /* Buscar las opciones de MENU PADRES */
          $m_padres = $cgp->select("a.id, a.nombre_menu, a.link, a.icono, a.padre, a.posicion, a.sistema_id")
                ->from('seguridad.menu AS a')
                  ->join("seguridad.roles_menu AS b","b.menu_id = a.id")
                ->where( array("a.sistema_id" => $value_sistemas['id_sistemas'], "a.estatus" => 1, "a.padre" => '0', "b.roles_id" => $value_sistemas['roles_id'] ) )
                ->order_by('a.posicion','ASC')->get()->result_array();

          if( count($m_padres) > 0 ) : /* tiene registros padres dentro del sistema*/

            /* Imprimir la Etiqueta de Sistema */
            echo "<li>"
            .anchor('#',
              validar_tipo_icono( $value_sistemas['sistema_icono'] )
              .$value_sistemas['descripcion']
              ."<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>")
            ."<ul class='treeview-menu'>";

            foreach ($m_padres as $key_m_padres => $value_m_padres) :

              /* Buscar los hijos de la opcion MENU PADRE */
              $m_hijos = $cgp->select("a.id, a.nombre_menu, a.link, a.icono, a.padre, a.posicion, a.sistema_id")
                                ->from('seguridad.menu AS a')
                                  ->join("seguridad.roles_menu AS b","b.menu_id = a.id")
                                ->where( array("a.estatus" => '1', "a.padre" => $value_m_padres['id'], "b.roles_id" => $value_sistemas['roles_id'] ) )
                                ->order_by('a.posicion','ASC')->get()->result_array();

              if( count($m_hijos) > 0 ):

                /* Imprimir Etiqueta MENU PADRE*/
                $v_icono = obtener_icono($value_m_padres,false); // validar que tipo de icono tiene
                echo "<li>\n"
                  .$v_icono
                  ."<ul class='treeview-menu'>\n";

                foreach ($m_hijos as $key_m_hijos => $value_m_hijos) :
                  $v_icono = obtener_icono($value_m_hijos,true); // validar que tipo de icono tiene
                  echo "<li>$v_icono</li>\n";
                endforeach;

                echo "</ul></li>"; /* cerrar etiquetas </ul></li> de padres*/
                ;else:

                $v_icono = obtener_icono($value_m_padres,true); // validar que tipo de icono tiene
                // echo "<li>"
                // .anchor('#',
                //   validar_tipo_icono($value_m_padres['icono'])
                //   .$value_m_padres['nombre_menu'])
                // ."</li>";
                echo "<li>".$v_icono."</li>\n";

              endif;

            endforeach;

            echo "</ul></li>"; /* Cerrar etiqueta </ul></li> de sistema */
          endif;

        endforeach;

        echo "</ul></li>"; /* cierra etiqueta </ul></li> del contenedor */
      endif;
    
    endforeach;

  endif;

?>

  <li class="header">MAIN NAVIGATION</li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-share"></i> <span>Multilevel</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
      <li>
        <a href="#"><i class="fa fa-circle-o"></i> Level One
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="#">
              <i class="fa fa-circle-o"></i> Level Two
            </a>
          </li>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i> Level Two
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
              <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
    </ul>
  </li>
  <li class="header">LABELS</li>
  <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
  <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
  <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
</ul>