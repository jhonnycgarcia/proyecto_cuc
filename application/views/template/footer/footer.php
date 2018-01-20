



<!-- Add the sidebar's background. This div must be placed
 immediately after the control sidebar -->
 <div class="control-sidebar-bg"></div> <!-- Aside -- Control-Sidebar -->
 
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?= base_url('assets/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url('assets/AdminLTE/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/AdminLTE/dist/js/app.min.js'); ?>"></script>
<!-- Slimscroll -->
<script src="<?= base_url('assets/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?= base_url('assets/AdminLTE/plugins/fastclick/fastclick.js'); ?>"></script>

<?php
	if( isset($e_footer) && !is_null($e_footer) ) // etiquetas precargadas en el header
      $this->template_lib->cargar_etiquetas($e_footer);
?>

</body>
</html>
