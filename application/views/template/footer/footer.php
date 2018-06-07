



<!-- Add the sidebar's background. This div must be placed
 immediately after the control sidebar -->
 <div class="control-sidebar-bg"></div> <!-- Aside Control-Sidebar -->
 	<?php
 		$this->load->view('template/modal/modal');
 	?>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 JS -->
<script src="<?= base_url('assets/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<!-- REQUIRED JS SCRIPTS -->
<script> 
	window.onload = function(){
		var _contenedor_preload = document.getElementById('contenedor_carga');
		_contenedor_preload.style.visibility = 'hidden';
		_contenedor_preload.style.opacity = '0';
	} 

	window.onunload = function(){
		var _contenedor_preload = document.getElementById('contenedor_carga');
		_contenedor_preload.style.visibility = 'visible';
		_contenedor_preload.style.opacity = '0.9';
	}

	function espera(opcion = false){
		if( opcion == false){
			$("#contenedor_carga").css({
				visibility: 'hidden',
				opacity: '0'
			});
		}else{
			$("#contenedor_carga").css({
				visibility: 'visible',
				opacity: '0.9'
			});
		}
	}
	
	var _base_url = "<?= base_url(); ?>";
	var _merror = '<?= (!isset($_SESSION["merror"]))?"null":$_SESSION["merror"]; ?>';
	if(_merror !== 'null' ){ _merror = JSON.parse(_merror);	}else{ _merror = null;}
</script>
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
<!-- Config Template -->
<script src="<?= base_url('assets/js/template/config.js'); ?>"></script>

<?php
	if( isset($e_footer) && !is_null($e_footer) ) // etiquetas precargadas en el header
      $this->template_lib->cargar_etiquetas($e_footer);
?>

</body>
</html>
