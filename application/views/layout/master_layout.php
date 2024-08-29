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
    <link href="<?= base_url('assets'); ?>./css/main.min.css" rel="stylesheet" />
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
    <!-- CORE PLUGINS-->
    <script src="<?= base_url('assets'); ?>./js/script.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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

	<script>
		$(document).ready(function() {
			var id_barang = $('#getIdBarang').val();
			var $serialCodeSelect = $('#showSerialCode');
			var $idDetailBarangInput = $('#id_detail_barang');

			function populateSerialCodes(id_barang, selectedSerialCode) {
				if (id_barang) {
					$.ajax({
						url: '<?= base_url("detail_request/get_serial_codes") ?>',
						type: 'POST',
						data: { id_barang: id_barang },
						dataType: 'json',
						success: function(serialCodes) {
							$serialCodeSelect.empty();
							$serialCodeSelect.append('<option value="">Pilih Nomor Seri</option>');
							
							if (serialCodes.length > 0) {
								$.each(serialCodes, function(index, serialCode) {
									if (serialCode.qtty > 0 || selectedSerialCode == serialCode.id_detail_barang ){
										var isSelected = serialCode.id_detail_barang == selectedSerialCode ? "selected" : "";
										var displayValue = serialCode.serial_code ? serialCode.serial_code : "TIDAK ADA SERIAL CODE";
										$serialCodeSelect.append('<option value="' + serialCode.serial_code + '" ' + isSelected + '>' + serialCode.id_detail_barang + "|" + displayValue + '</option>');
									}
								});
							} else {
								$serialCodeSelect.append('<option value="">Tidak ada serial code</option>');
							}

							$serialCodeSelect.change(function() {
								var selectedOption = $(this).find('option:selected');
								var selectedIdDetailBarang = selectedOption.text().split('|')[0]; // Extract ID Detail Barang from the option text
								$idDetailBarangInput.val(selectedIdDetailBarang); 
							});
							
							$serialCodeSelect.trigger('change');
						},
						error: function(xhr, status, error) {
							console.error("An error occurred while fetching serial codes: " + error);
						}
					});
				}
			}

			if (id_barang) {
				var selectedSerialCode = '<?= isset($Detail_Request['id_detail_barang']) ? $Detail_Request['id_detail_barang'] : '' ?>';
				populateSerialCodes(id_barang, selectedSerialCode);
			}

			$('#getIdBarang').change(function() {
				var selectedSerialCode = null; 
				populateSerialCodes($(this).val(), selectedSerialCode);
			});
		});


		function warnError() {
			var errorElement = document.querySelector('.warn');
			errorElement.style.display = 'none';
		}
	</script>
</body>

</html>
