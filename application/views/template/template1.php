<?php 

  // Header File
  if ( isset($data_header) ) { // tiene etiquetas para precargar en el header
    $this->load->view('Template/header/header',$data_header);
  }else{
    $this->load->view('Template/header/header');
  }

  // Main SideBar File
  $this->load->view('Template/main-sidebar/main-sidebar');

  // Content File
  if ( isset($data_content) ) { // tiene contenido para pregargar en el contenido
    $this->load->view('Template/content/content',$data_content);
  }else{
    $this->load->view('Template/content/content');
  }

  // Footer-Content File
  $this->load->view('Template/footer/footer_content_v');

  // Control-SideBar File
  $this->load->view('Template/control-sidebar/control-sidebar');

  // Footer File
  if (isset($e_footer) ) { // tiene etiquetas para precargar en el footer
    $this->load->view('Template/footer/footer',$e_footer);
  }else{
    $this->load->view('Template/footer/footer');
  }

 //* desarrollado por: Jhonny Garcia jhonnycgarcia@gmail.com

?>


