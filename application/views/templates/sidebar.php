
<html lang="en">

<!-- START SIDEBAR-->
    <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
						<img src="<?= base_url('assets'); ?>./img/mdr.png" width="45px" />
                        <!--<img src="<?= base_url('assets/img/users/') . $user['image']; ?>" width="45px" />-->
						<!--<?php if(isset($user) && isset($user['image']) && !empty($user['image'])): ?>
							<img src="<?= base_url('assets/img/users/') . $user['image']; ?>" width="45px" />
						<?php else: ?>
							<p>Gambar tidak tersedia.</p>
						<?php endif; ?>-->
                    </div>
                    <div class="admin-info">
                        <div class="font-strong">Admin</div><small>Administrator</small></div>
                </div>
                <ul class="side-menu metismenu">

                    <li>
                        <a class="active" href=<?= base_url('user/index'); ?>><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li class="heading">FEATURES</li>
					<li>
						<a href="<?= base_url('detail_barang');?>" id="barangDropdown">
							<i class="sidebar-item-icon fa fa-briefcase"></i>
                            <span class="nav-label">Detail Barang</span>
						</a>
					</li>	
                   	<li>
						<a href="#" id="Dropdown"><i class="sidebar-item-icon fa fa-bookmark"></i>
							<span class="nav-label">Transaksi</span><i class="fa fa-angle-left arrow"></i></a>
						<ul class="nav-2-level collapse">
							<li>
								<a href="<?= base_url('request'); ?>">Request</a>
							</li>
							<li>
								<a href="<?= base_url('replace'); ?>">Replace</a>
							</li>
							<li>
								<a href="<?= base_url('pinjam'); ?>">Pinjam</a>
							</li>
						</ul>
					</li>
                    <li>
                        <a href="#" id="Dropdown"><i class="sidebar-item-icon fa fa-edit"></i>
                            <span class="nav-label">Barang</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href=<?= base_url('satuan'); ?>>Satuan Barang</a>
                            </li>
                            <li>
                                <a href=<?= base_url('jenis'); ?>>Jenis Barang</a>
                            </li>
                            <li>
                                <a href=<?= base_url('barang'); ?>>Data Barang</a>
                            </li>
                        </ul>
                    </li> 
                </ul>
            </div>
        </nav>
		
        
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
                <style>
                    .visitors-table tbody tr td:last-child {
                        display: flex;
                        align-items: center;
                    }

                    .visitors-table .progress {
                        flex: 1;
                    }

                    .visitors-table .progress-parcent {
                        text-align: right;
                        margin-left: 10px;
                    }
                </style>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var Dropdown = document.getElementById('Dropdown');
			Dropdown.addEventListener('click', function(event) {
				event.preventDefault(); // Menghentikan event default dari link
				Dropdown.nextElementSibling.classList.toggle('show'); // Menampilkan dropdown
			});
		});
	</script>
	<script src="<?= base_url('assets'); ?>./vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="<?= base_url(''); ?>assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="<?= base_url('assets'); ?>./vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="<?= base_url('assets'); ?>./vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?= base_url('assets'); ?>/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="<?= base_url('assets'); ?>./js/scripts/dashboard_1_demo.js" type="text/javascript"></script>

    </html>
