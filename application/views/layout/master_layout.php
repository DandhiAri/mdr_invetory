<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Admin | Dashboard</title>
	<!-- CSS SENDIRI KALAU PINGIN NGUBAH-->
    <link href="<?= base_url('assets'); ?>/css/style.css" rel="stylesheet" />
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?= base_url('assets'); ?>./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets'); ?>./vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets'); ?>./vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?= base_url('assets'); ?>/css/main.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <?php echo $this->load->view('layout/templates/nav_header', [], true); ?>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <?php echo $this->load->view('layout/templates/sidebar', [], true); ?>
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
			<div class="page-content fade-in-up">
				<?php echo isset($content) ? $content : ''; ?>
			</div>
            <!-- END PAGE CONTENT-->
        	<?php echo $this->load->view('layout/templates/footer', [], true); ?>
        </div>
    </div>
    
    <!-- END THEME CONFIG PANEL -->
    <!-- BEGIN PAGA BACKDROPS-->
	<!-- <div class="sidenav-backdrop backdrop"></div>
	<div class="preloader-backdrop">
		<div class="page-preloader">Loading</div>
	</div> -->
    <!-- END PAGA BACKDROPS-->
    <!-- SCRIPT SENDIRI BISA DIUBAH-->
	<script>
		function warnError() {
			var errorElement = document.querySelector('.warn');
			errorElement.style.display = 'none';
		}
	</script>
	<?php  if ($title == "Detail Request" || $title == "Detail Replace" || $title == "Detail Pinjam"): ?>
		<script>
			$(document).ready(function() {
				$('#getIdBarang').change(function() {
					var id_barang = $(this).val();
					$.ajax({
						url: '<?= base_url('Detail_request/get_serial_codes') ?>',
						method: 'POST',
						data: {id_barang: id_barang},
						dataType: 'json',
						success: function(response) {
							var options = '<option value="">Pilih Nomor Seri</option>';
							$.each(response, function(index, value) {
								options += '<option value="' + value.serial_code + '">' + value.serial_code + '</option>';
							});
							$('#showSerialCode').html(options);
						}
					});
				});
			});
		</script>
		<script src="<?= base_url('assets/js/ajax.js') ?>"></script>
	<?php endif; ?>
    <script src="<?= base_url('assets'); ?>/js/script.js"></script>
    <!-- CORE PLUGINS-->
    <script src="<?= base_url('assets'); ?>./vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="<?= base_url('assets'); ?>./vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?= base_url('assets'); ?>/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="<?= base_url('assets'); ?>./js/scripts/dashboard_1_demo.js" type="text/javascript"></script>
</body>

</html>
