<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ( isset($data_header) && array_key_exists('titulo_page', $data_header) && !is_null($data_header['titulo_page']) )?$data_header['titulo_page']:TITULO_NAV; ?></title>
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
  <link rel="shortcut icon" type="image/ico" href="<?= base_url('assets/images/icovzla.png'); ?>">
  <?php
    if( isset($data_header) && array_key_exists('e_header', $data_header) && !is_null($data_header['e_header']) ): // etiquetas precargadas en el header
      cargar_etiqueta($data_header['e_header']);
    endif;

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
<body class="hold-transition skin-blue sidebar-mini">

  <div class="wrapper">

    
    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="<?= base_url(); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>M</b>SIG</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Master</b>SIGEI</span>
      </a>

<?php 
  
  // NavBar
  $this->load->view('Template/header/navbar/navbar') 

?> 
    </header> <!-- Header -->
