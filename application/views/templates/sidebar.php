<nav class="page-sidebar" id="sidebar">
	<div id="sidebar-collapse">
		<div class="admin-block d-flex">
			<div>
				<img src="<?= base_url('assets/img/users/') . $user['image']; ?>" width="45px" />
			</div>
			<div class="admin-info">
				<div class="font-strong"><?= $user['name']; ?></div><small>Administrator</small></div>
		</div>
		<ul class="side-menu metismenu">
			<li>
				<a class="active" href=<?= base_url('dashboard'); ?>><i class="sidebar-item-icon fa fa-th-large"></i>
					<span class="nav-label">Dashboard</span>
				</a>
			</li>
			<li class="heading">FEATURES</li>
			<li>
				<a class="active" href=<?= base_url('detail_barang'); ?>><i class="sidebar-item-icon fa fa-briefcase"></i>
					<span class="nav-label">Detail Barang</span>
				</a>
			</li>
			<li>
				<a href="#"><i class="sidebar-item-icon fa fa-bookmark"></i>
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
				<a href="#" ><i class="sidebar-item-icon fa fa-edit"></i>
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
