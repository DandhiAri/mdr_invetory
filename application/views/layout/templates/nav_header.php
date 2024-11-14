<header class="header">
	<div class="page-brand">
		<a class="link" style="overflow:hidden;" href="<?= base_url('dashboard')?>">
			<img src="<?= base_url("assets/img/mdr.png")?>" class="mr-2"  width="45px" alt="">
			<span class="brand">INIT v0</span>
		</a>
	</div>
	<div class="flexbox flex-1">
		<!-- START TOP-LEFT TOOLBAR-->
		<ul class="nav navbar-toolbar">
			<li>
				<a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
			</li>
		</ul>
		<ul class="nav navbar-toolbar">
			<li class="dropdown dropdown-user">
				<a class="nav-link dropdown-toggle link" data-toggle="dropdown">
					<img src="<?= base_url('assets/img/users/') . $user['image']; ?>" />
					<span><?= $user['name']; ?><i class="fa fa-angle-down m-l-5"></i></a></span>
				<ul class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="<?= base_url('profile'); ?>"><i class="fa fa-user"></i>Profile</a>
					<!-- <a class="dropdown-item" href="<?= base_url('assets'); ?>profile.html"><i class="fa fa-cog"></i>Settings</a> -->
					<li class="dropdown-divider"></li>
					<a class="dropdown-item" href=<?= base_url('auth/logout'); ?>><i class="fa fa-power-off"></i>Logout</a>
				</ul>
			</li>
		</ul>
		<!-- END TOP-RIGHT TOOLBAR-->
	</div>
</header>
