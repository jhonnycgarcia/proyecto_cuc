<!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">OPCIONES</li>
<?php
  
  $padres = $this->template_lib->obtener_items_menu($this->session->userdata('id_usuario'));

  if(!is_null($padres)){
    foreach ($padres as $key_p => $value_p) {
      $hijos = $this->template_lib->obtener_items_menu($this->session->userdata('id_usuario'),$value_p['id']);

    if( !is_null($hijos) ){
      $etiqueta = imprimir_item($value_p);
      echo "\t\t<li class='treeview'>\n\t\t\t"
        .$etiqueta
        ."\r\t\t\t<ul class='treeview-menu'>\n";
      foreach ($hijos as $key_h => $value_h) {
        $etiqueta = imprimir_item($value_h,true);
        echo "\t\t<li>\n\t\t\t"
          .$etiqueta
          ."\r\t\t</li>\n";
      }
      echo "\t\t\t</ul>\n"
        ."\r\t\t</li>\r";
    }else{
      $etiqueta = imprimir_item($value_p,true);
      echo "\t\t<li>\n\t\t\t".$etiqueta."\r\t\t</li>\r";
    }
    }
  }
?>
      </ul>
<!-- /.sidebar-menu --> <!-- Menu Vertical <-->