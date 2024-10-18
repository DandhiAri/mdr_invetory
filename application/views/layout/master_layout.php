<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Admin | Dashboard</title>
    <link rel="icon" href="<?= base_url('assets/img/mdr.png') ?>" type="image/png">
	<!-- CSS SENDIRI KALAU PINGIN NGUBAH-->
    <link href="<?= base_url('assets'); ?>/css/style.css" rel="stylesheet" />
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?= base_url('assets'); ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets'); ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets'); ?>/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
	<link href="<?= base_url('assets'); ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
	<link href="<?= base_url('assets'); ?>/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?= base_url('assets'); ?>/css/main.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
	<style>
		table{
			text-align: center;	
			vertical-align: middle;
		}
		.table thead th{
			text-align: center;
		}
		.table td{
			vertical-align: middle;
		}
		.container-status{
			display:flex;
			justify-content: space-between;
			margin-right:1.3em;
		}
		.statuses{
			margin: 0 2em 0 2em;
			display:flex;

		}
		.container-status .status{
			padding: 0 0.8em 0 10px;

		}
		.sorted.asc:after {
			content: ' ▲';
		}
		.sorted.desc:after {
			content: ' ▼';
		}
	</style>
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
    <script src="<?= base_url('assets'); ?>./vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?= base_url('assets'); ?>/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="<?= base_url('assets'); ?>./js/scripts/dashboard_1_demo.js" type="text/javascript"></script>
	<script src="<?= base_url('assets'); ?>./vendors/select2/dist/js/select2.min.js"></script>
    <script src="<?= base_url('assets'); ?>./vendors/chartjs/dist/Chart.min.js" type="text/javascript"></script>



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
							$serialCodeSelect.append('<option value="">Pilih Nomor Serial</option>');
							
							if (serialCodes.length > 0) {
								$.each(serialCodes, function(index, serialCode) {
									if (serialCode.qtty > 0 || selectedSerialCode == serialCode.id_detail_barang ){
										var isSelected = serialCode.id_detail_barang == selectedSerialCode ? "selected" : "";
										var displayValue = serialCode.serial_code ? serialCode.serial_code : "TIDAK ADA SERIAL CODE";
										var valueNull = serialCode.serial_code ? serialCode.serial_code : "-";

										$serialCodeSelect.append('<option value="' + valueNull + '" ' + isSelected + '>' + serialCode.id_detail_barang + "|" + displayValue + '</option>');
									}
								});
								
							} else {
								$serialCodeSelect.append('<option value="">Tidak ada serial code</option>');
							}

							$serialCodeSelect.change(function() {
								var selectedOption = $(this).find('option:selected');
								var selectedIdDetailBarang = selectedOption.text().split('|')[0]; 
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
				<?php if ($title == "Detail Replace") { ?>
					var selectedSerialCode = '<?= isset($Detail_Replace['id_detail_barang']) ? $Detail_Replace['id_detail_barang'] : '' ?>';
				<?php } elseif ($title == "Detail Request") { ?>
					var selectedSerialCode = '<?= isset($Detail_Request['id_detail_barang']) ? $Detail_Request['id_detail_barang'] : '' ?>';
				<?php } elseif ($title == "Detail Pinjam") { ?>
					var selectedSerialCode = '<?= isset($Detail_pinjam['id_detail_barang']) ? $Detail_pinjam['id_detail_barang'] : '' ?>';
				<?php } ?>
				populateSerialCodes(id_barang, selectedSerialCode);
			}

			$('#getIdBarang').change(function() {
				var selectedSerialCode = null; 
				populateSerialCodes($(this).val(), selectedSerialCode);

			});
			
			$('#getIdBarang').select2({
				placeholder: 'Pilih Barang',
				allowClear: true,
				width: 'resolve' 
			});
			$('#showSerialCode').select2({
				placeholder: 'Pilih Serial Code',
				allowClear: true,
				width: 'resolve' 
			});
			$('#getIdPengajuan').select2({
				placeholder: 'Pilih Pengajuan',
				allowClear: true,
				width: 'resolve' 
			});
			$('#id_satuan').select2({
				placeholder: 'Pilih Satuan Barang',
				allowClear: true,
				width: 'resolve' 
			});	
			$('#id_jenis').select2({
				placeholder: 'Pilih Jenis Barang',
				allowClear: true,
				width: 'resolve' 
			});	
		});

		function warnError() {
			var errorElement = document.querySelector('.warn');
			errorElement.style.display = 'none';
		}
		var barang = [];
		var quantity = [];

		<?php
			if(!empty($tinta)){
			foreach ($tinta as $tt){
		?>
			barang.push(<?= json_encode($tt->nama_barang) ?>);
			quantity.push(<?= json_encode($tt->detail_count) ?>);
		<?php
			}
		}
		?>
		var ctx = document.getElementById('BarangChart').getContext('2d');
		var BarangChart = new Chart(ctx, {
			type: 'bar', 
			data: {
				labels: barang, 
				datasets: [{
					label: 'Jumlah', 
					data: quantity,
					backgroundColor: '#FF9999', 
					borderColor: 'rgb(0, 0, 0)', 
					borderWidth: 1 
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true 
						}
					}]
				}
			}
		});
		<?php 
		if(!empty($stB)){
		?>
			var ctx = document.getElementById('RequestChart').getContext('2d');
			var RequestChart = new Chart(ctx, {
				type: 'pie', 
				data: {
					labels: <?= json_encode($stB) ?>,
					datasets: [{
						label: 'Status',
						data: [<?= json_encode($statusBarangInused) ?>,<?= json_encode($statusBarangStored) ?>],
						backgroundColor: [
							'rgba(75, 192, 192, 0.2)',
							'rgba(54, 192, 0, 0.2)'

						],
						borderColor: [
							'rgba(75, 192, 192, 1)',
							'rgba(54, 192, 0, 1)'	
						],
						borderWidth: 1
					}]
				},
				options: {
					responsive: true
				}
			});
		<?php
		}
		?>
		var ctx = document.getElementById('PinjamChart').getContext('2d');
		var PinjamChart = new Chart(ctx, {
			type: 'bar', 
			data: {
				labels: ['January', 'February', 'March', 'April', 'May', 'June'], 
				datasets: [{
					label: 'Sales', 
					data: [12, 19, 3, 5, 2, 3], 
					backgroundColor: 'rgba(75, 192, 192, 0.2)', 
					borderColor: 'rgba(75, 192, 192, 1)', 
					borderWidth: 1 
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true 
						}
					}]
				}
			}
		});
		var ctx = document.getElementById('ReplaceChart').getContext('2d');
		var ReplaceChart = new Chart(ctx, {
			type: 'bar', 
			data: {
				labels: ['January', 'February', 'March', 'April', 'May', 'June'], 
				datasets: [{
					label: 'Sales', 
					data: [12, 19, 3, 5, 2, 3], 
					backgroundColor: 'rgba(75, 192, 192, 0.2)', 
					borderColor: 'rgba(75, 192, 192, 1)', 
					borderWidth: 1 
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true 
						}
					}]
				}
			}
		});
		var ctx = document.getElementById('DognutChart').getContext('2d');
		var DognutChart = new Chart(ctx, {
			type: 'pie', // Ubah tipe menjadi 'doughnut'
			data: {
				labels: ['January', 'February', 'March', 'April', 'May', 'June'],
				datasets: [{
					label: 'Sales',
					data: [12, 19, 3, 5, 2, 3],
					backgroundColor: [
						'rgba(75, 192, 192, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(75, 192, 192, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true
			}
		});
	</script>
</body>

</html>
