<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header text-center">MODULOS</li>
<?php
  $this->load->helper('menu');
  $cgp = $this->load->database('cgp',TRUE);
  $id_usuario = $this->session->userdata('id_usuario');


  // Obtener todos los Modulos_Contenedores ACTIVOS
  $modulos_contenedor = $cgp->select()->from('seguridad.contenedores')
            ->where( array('contenedor_estatus' => 't') )->order_by('contenedor_posicion','ASC')
            ->get()->result_array();

  if( count($modulos_contenedor) > 0 ){

    foreach ($modulos_contenedor as $key_contenedor => $value_contenedor) {

      $sistemas = $cgp->select("a.roles_id"
                .",b.id_sistemas,b.sistema,b.descripcion,b.sistema_posicion,b.sistema_icono,b.contenedor_id")
                ->from('seguridad.roles_usuario_sistema AS a')
                  ->join("seguridad.sistemas AS b","a.sistema_id = b.id_sistemas")
                ->where( array('a.usuarios_id' => $id_usuario, 'b.contenedor_id' => $value_contenedor['id_contenedor']) )
                ->get()->result_array();

      if( count($sistemas) > 0 ): /* Si consigue sistemas dentro del contenedor*/

        foreach ($sistemas as $key_sistemas => $value_sistemas) {

          // buscar registros padres
          $m_padres = $cgp->select("a.id, a.nombre_menu, a.link, a.icono, a.padre, a.posicion, a.sistema_id")
                ->from('seguridad.menu AS a')
                  ->join("seguridad.roles_menu AS b","b.menu_id = a.id")
                ->where( array("a.sistema_id" => $value_sistemas['id_sistemas'], "a.estatus" => 1, "a.padre" => '0', "b.roles_id" => $value_sistemas['roles_id'] ) )
                ->order_by('a.posicion','ASC')->get()->result_array();

          if( count($m_padres) > 0 ):

            /* imprimir etiqueta del modulo*/
            echo "<li class='active treeview'>"
            ."<a href='#'>".strtoupper( $value_contenedor['contenedor_nombre'] )."</a>\r"
            ."<ul class='treeview-menu'>";

            echo "<li class='active treeview'>" 
            ."<a href='#'>"
                .validar_tipo_icono( $value_sistemas['sistema_icono'] )
                ."<span>".strtoupper( $value_sistemas['descripcion'] )."</span>"
                ."<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>"
            ."</a>"
            ."<ul class='treeview-menu'>";

            foreach ($m_padres as $key_m_padres => $value_m_padres): /* repetir por todos los registros padres*/

              // buscar registros hijos
              $m_hijos = $cgp->select("a.id, a.nombre_menu, a.link, a.icono, a.padre, a.posicion, a.sistema_id")
                                ->from('seguridad.menu AS a')
                                  ->join("seguridad.roles_menu AS b","b.menu_id = a.id")
                                ->where( array("a.estatus" => '1', "a.padre" => $value_m_padres['id'], "b.roles_id" => $value_sistemas['roles_id'] ) )
                                ->order_by('a.posicion','ASC')->get()->result_array();

              if( count($m_hijos) > 0 ): /* tiene registros hijos*/

                $v_icono = obtener_icono($value_m_padres,false); // validar que tipo de icono tiene
                echo "<li class='treeview'>\n"
                  .$v_icono
                  ."<ul class='treeview-menu'>\n";

                foreach ($m_hijos as $key_m_hijos => $value_m_hijos) : /* recorrer por todos los registros hijos*/

                  $v_icono = obtener_icono($value_m_hijos,true); // validar que tipo de icono tiene
                  echo "<li class='treeview'>$v_icono</li>\n";

                endforeach;

                echo "</ul></li>";

              ;else: /* no tiene hijos*/

                $v_icono = obtener_icono($value_m_padres,true); // validar que tipo de icono tiene
                echo "<li class='treeview'>".$v_icono."</li>\n";

              endif;
              
            endforeach;

            echo "</ul></li>"; /* cerrar etiqueta del sistema*/
            echo "</ul></li>"; /* cerrar etiqueta del modulo*/
          endif;
          
        }

      endif;

    } /* /foreach */

  }/* /if */


?>
