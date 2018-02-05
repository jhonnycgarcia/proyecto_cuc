<!-- Header Navbar -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
<?php
  
  // Dropdown Messages
  // $this->load->view('Template/header/navbar/navbar-dropdown-messages');
  
  // Dropdown Notifications
  // $this->load->view('Template/header/navbar/navbar-dropdown-notifications');
  
  // Dropdown Tasks
  // $this->load->view('Template/header/navbar/navbar-dropdown-tasks');
  
  // Dropdown User Menu
  $this->load->view('Template/header/navbar/navbar-dropdown-user-menu');
  
?>
      <!-- Control Sidebar Toggle Button -->
<!--       <li>
        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
      </li> -->
      
    </ul>
  </div>
</nav> <!-- NavBar Items -->