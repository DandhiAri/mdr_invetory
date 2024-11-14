<nav class="page-sidebar" id="sidebar">
	<div id="sidebar-collapse">
		<div class="admin-block d-flex mb-1 ">
			<div >
				<img src="<?= base_url('assets/img/users/') . $user['image']; ?>" width="45px" />
			</div>
			<div class="admin-info">
				<div class="font-strong"><?= $user['name']; ?></div>
				<small>Administrator</small>
			</div>
		</div>
		<ul class="side-menu metismenu">
			<li>
				<a class="active" href=<?= base_url('dashboard'); ?>><i class="sidebar-item-icon fa fa-th-large"></i>
					<span class="nav-label">Dashboard</span>
				</a>
			</li>
			<li class="heading">FEATURES</li>
			<li>
				<a href="#"><i class="sidebar-item-icon fa fa-handshake-o"></i>
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
					<li>
						<a href="<?= base_url('pengajuan'); ?>">Pengajuan</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#" ><i class="sidebar-item-icon fa fa-trophy"></i>
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
			<li class="heading">Documentation</li>
			<?php 
			$documFile = "documentationINIT.pdf";
			$ManuaFile = "manualINIT101.pdf";
			?>
			<li>
				<a target="_blank" href=<?= base_url('Welcome/docum/'. $documFile); ?>><i class="sidebar-item-icon fa fa-file"></i>
					<span class="nav-label">Documentation</span>
				</a>
			</li>
			<li>
				<a target="_blank" href=<?= base_url('Welcome/docum/'. $ManuaFile); ?>><i class="sidebar-item-icon fa fa-file"></i>
					<span class="nav-label">Manual 101</span>
				</a>
			</li>
		</ul>
	</div>
</nav>
