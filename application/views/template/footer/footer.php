



<!-- Add the sidebar's background. This div must be placed
 immediately after the control sidebar -->
 <div class="control-sidebar-bg"></div> <!-- Aside -- Control-Sidebar -->
 
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<script> _base_url = '<?= base_url(); ?>'; </script>
<!-- jQuery 2.2.3 JS -->
<script src="<?= base_url('assets/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<!-- Bootstrap 3.3.6 JS -->
<script src="<?= base_url('assets/AdminLTE/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- AdminLTE App JS -->
<script src="<?= base_url('assets/AdminLTE/dist/js/app.min.js'); ?>"></script>
<!-- Slimscroll JS -->
<script src="<?= base_url('assets/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick Js -->
<script src="<?= base_url('assets/AdminLTE/plugins/fastclick/fastclick.js'); ?>"></script>
<!-- IdLetimer Js -->
<script src="<?= base_url('assets/jquery-idletimer/dist/idle-timer.js'); ?>"></script>
<!-- IdLetimer Config Js -->
<!-- <script src="<?= base_url('assets/js/template/v_login.js'); ?>"></script> -->

<?php
	if( isset($e_footer) && !is_null($e_footer) ) // etiquetas precargadas en el header
      $this->template_lib->cargar_etiquetas($e_footer);
?>

</body>
</html>
