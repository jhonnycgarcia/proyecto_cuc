<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ( isset($titulo_pagina) && !is_null($titulo_pagina) && !empty($titulo_pagina) )?$titulo_pagina:TITULO_NAV; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!-- Bootstrap CSS AdminLTE folder -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/bootstrap/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/ionicons/css/ionicons.min.css'); ?>">
  <!-- Theme style AdminLTE folder -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/AdminLTE.min.css'); ?>">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
      -->
      <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/skins/_all-skins.min.css'); ?>">
  <!-- FavIcon -->
  <link rel="shortcut icon" type="image/ico" href="<?= base_url('assets/images/favicon.ico'); ?>">
  <?php
    if( isset($e_header) && !is_null($e_header) ) // etiquetas precargadas en el header
      $this->template_lib->cargar_etiquetas($e_header);
  ?>

      <style>
        .icono{
          font-size: 10px;
          line-height: 50px;
        }

        .icono.izquierda{
          float: left;
          padding-right: 5px;
        }
        
        *,*:after,*:before{
          margin: 0;
          padding: 0;
          -webkit-box-sizing: border-box;
          -moz-box-sizing: border-box;
          box-sizing: border-box;
        }

        #contenedor_carga{
          /*background-color: rgba(46,136,215,0.9);*/
          background-color: rgba(255,255,245,0.9);
          height: 100%;
          width: 100%;
          position: fixed;
          -webkit-transition: all 1s ease;
          -o-transition: all 1s ease;
          transition: all 1s ease;
          z-index: 10000;
        }

        #carga{
          border: 15px solid #ccc;
          border-top-color: #6A696C;
          /*border-top-color: #F4266A;*/
          border-top-style: groove;
          height: 100px;
          width: 100px;
          border-radius: 100%;

          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          margin: auto;
          -webkit-animation: girar 1.5s linear infinite;
          -o-animation: girar 1.5s linear infinite;
          animation: girar 1.5s linear infinite;
        }

          .divider {
            height: 1px;
            width:100%;
            display:block; /* for use on default inline elements like span */
            margin: 9px 0;
            overflow: hidden;
            background-color: #e5e5e5;
          }

        @keyframes girar{
          from { transform: rotate(0deg); }
          to { transform: rotate(360deg); }
        }

      </style>

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<?php 
  $config = $this->session->userdata('configuracion');
  $tema = "skin-blue" ;
  if( isset($config['tema_template']) ) $tema = $config['tema_template']; 

  echo '<body class="hold-transition '.$tema.' sidebar-mini">';
?>
<!-- <body class="hold-transition skin-blue sidebar-mini"> -->

<!-- Contenedor de Pre Loading -->
<div id="contenedor_carga">
  <div id="carga"></div>
</div>

  <div class="wrapper">

    
    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="<?= base_url(); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>CGP</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>CGP</b>Web</span>
      </a>

<?php 
  
  // NavBar
  $this->load->view('Template/header/navbar/navbar');

?> 
    </header> <!-- Header -->
